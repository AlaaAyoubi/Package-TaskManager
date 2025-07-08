<?php

namespace Alaa\TaskManager\Http\Controllers;

use Alaa\TaskManager\Models\Team;
use App\Models\User;
use Alaa\TaskManager\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Alaa\TaskManager\Http\Requests\StoreTaskRequest;
use Alaa\TaskManager\Http\Requests\UpdateTaskRequest;
use Alaa\TaskManager\Services\NotificationService;
use Illuminate\Routing\Controller;

class ManagerTeamController extends Controller
{
    // عرض جميع الفرق التي يديرها المدير الحالي
    public function index(Request $request)
    {
        $user = $request->user();
        $teams = $user->teams()->wherePivot('role', 'manager')->with('users')->latest()->paginate(10);
        return view('manager.teams.index', compact('teams'));
    }

    // عرض تفاصيل فريق
    public function show(Request $request, Team $team)
    {
        $user = $request->user();
        if (!$team->users()->where('user_id', $user->id)->where('role', 'manager')->exists()) {
            abort(403);
        }
        $team->load('users');
        $tasks = $team->tasks()->with('user')->latest()->paginate(10);
        return view('manager.teams.show', compact('team', 'tasks'));
    }

    // عرض نموذج تعديل فريق
    public function edit(Request $request, Team $team)
    {
        $user = $request->user();
        if (!$team->users()->where('user_id', $user->id)->where('role', 'manager')->exists()) {
            abort(403);
        }
        $users = User::all();
        $team->load('users');
        return view('manager.teams.edit', compact('team', 'users'));
    }

    // تحديث بيانات فريق
    public function update(Request $request, Team $team)
    {
        $user = $request->user();
        if (!$team->users()->where('user_id', $user->id)->where('role', 'manager')->exists()) {
            abort(403);
        }
        $request->validate([
            'name' => 'required|string|max:255',
            'members' => 'array',
            'members.*' => 'exists:users,id',
        ]);
        DB::transaction(function () use ($request, $team) {
            $team->update(['name' => $request->name]);
            $currentManager = $team->users()->where('role', 'manager')->first();
            $team->users()->detach();
            if ($currentManager) {
                $team->users()->attach($currentManager->id, ['role' => 'manager']);
            }
            if ($request->has('members')) {
                $members = collect($request->members)->filter(fn($id) => $id != $currentManager->id);
                foreach ($members as $memberId) {
                    $team->users()->attach($memberId, ['role' => 'member']);
                }
            }
        });
        return redirect()->route('manager.teams.show', $team)->with('success', 'تم تحديث بيانات الفريق بنجاح!');
    }

    // حذف فريق
    public function destroy(Request $request, Team $team)
    {
        $user = $request->user();
        if (!$team->users()->where('user_id', $user->id)->where('role', 'manager')->exists()) {
            abort(403);
        }
        $team->delete();
        return redirect()->route('manager.teams')->with('success', 'تم حذف الفريق بنجاح!');
    }

    // =============================
    // إدارة مهام الفرق
    // =============================

    // عرض مهام فريق معين
    public function teamTasks(Request $request, Team $team)
    {
        $user = $request->user();
        if (!$team->users()->where('user_id', $user->id)->where('role', 'manager')->exists()) {
            abort(403);
        }
        $tasksQuery = $team->tasks()->with(['user']);
        if ($request->filled('priority')) {
            $tasksQuery->where('priority', $request->priority);
        }
        if ($request->filled('status')) {
            $tasksQuery->where('status', $request->status);
        }
        $tasks = $tasksQuery->latest()->paginate(10);
        $members = $team->users;
        return view('manager.teams.tasks.index', [
            'team' => $team,
            'tasks' => $tasks,
            'members' => $members,
        ]);
    }

    // عرض نموذج إضافة مهمة جديدة لفريق
    public function createTask(Request $request, Team $team)
    {
        $user = $request->user();
        if (!$team->users()->where('user_id', $user->id)->where('role', 'manager')->exists()) {
            abort(403);
        }
        $members = $team->users;
        return view('manager.teams.tasks.create', [
            'team' => $team,
            'members' => $members,
        ]);
    }

    // حفظ مهمة جديدة لفريق
    public function storeTask(StoreTaskRequest $request, Team $team)
    {
        $user = $request->user();
        $pivot = $team->users()->where('user_id', $user->id)->first();
        if (!$pivot || $pivot->role !== 'manager') {
            abort(403, 'غير مصرح لك بإضافة مهام لهذا الفريق.');
        }
        $data = $request->validated();
        $task = Task::create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'status' => $data['status'],
            'priority' => $data['priority'],
            'due_date' => $data['due_date'] ?? null,
            'team_id' => $team->id,
            'user_id' => $data['assigned_user_id'],
        ]);
        NotificationService::taskCreated($task, $user);
        return redirect()->route('manager.teams.tasks', $team)->with('success', 'تمت إضافة المهمة بنجاح.');
    }

    // عرض نموذج تعديل مهمة
    public function editTask(Request $request, Team $team, Task $task)
    {
        $user = $request->user();
        $pivot = $team->users()->where('user_id', $user->id)->first();
        if (!$pivot || $pivot->role !== 'manager') {
            abort(403, 'غير مصرح لك بتعديل مهام لهذا الفريق.');
        }
        $members = $team->users;
        return view('manager.teams.tasks.edit', [
            'team' => $team,
            'task' => $task,
            'members' => $members,
        ]);
    }

    // تحديث مهمة
    public function updateTask(UpdateTaskRequest $request, Team $team, Task $task)
    {
        $user = $request->user();
        $pivot = $team->users()->where('user_id', $user->id)->first();
        if (!$pivot || $pivot->role !== 'manager') {
            abort(403, 'غير مصرح لك بتعديل مهام لهذا الفريق.');
        }
        $data = $request->validated();
        $task->update($data);
        return redirect()->route('manager.teams.tasks', $team)->with('success', 'تم تحديث المهمة بنجاح.');
    }

    // حذف مهمة
    public function destroyTask(Request $request, Team $team, Task $task)
    {
        $user = $request->user();
        $pivot = $team->users()->where('user_id', $user->id)->first();
        if (!$pivot || $pivot->role !== 'manager') {
            abort(403, 'غير مصرح لك بحذف مهام لهذا الفريق.');
        }
        $task->delete();
        return redirect()->route('manager.teams.tasks', $team)->with('success', 'تم حذف المهمة بنجاح.');
    }
} 