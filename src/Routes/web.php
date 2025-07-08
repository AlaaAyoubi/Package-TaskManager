<?php

use Illuminate\Support\Facades\Route;
use Alaa\TaskManager\Http\Controllers\TaskController;
use Alaa\TaskManager\Http\Controllers\NotificationController;
use Alaa\TaskManager\Http\Controllers\TeamController;
use Alaa\TaskManager\Http\Controllers\ManagerTeamController;

// =============================
// مسارات إدارة المهام (Tasks)
// =============================

// للأدمن: CRUD كامل على المهام
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('tasks', TaskController::class);
});

// للمدير: CRUD كامل على مهام فرقه
Route::middleware(['auth', 'team.role:manager'])->group(function () {
    // قائمة المهام
    Route::get('manager/tasks', [TaskController::class, 'index'])->name('manager.tasks.index');
    // إضافة مهمة
    Route::get('manager/tasks/create', [TaskController::class, 'create'])->name('manager.tasks.create');
    Route::post('manager/tasks', [TaskController::class, 'store'])->name('manager.tasks.store');
    // عرض مهمة
    Route::get('manager/tasks/{task}', [TaskController::class, 'show'])->name('manager.tasks.show');
    // تعديل مهمة
    Route::get('manager/tasks/{task}/edit', [TaskController::class, 'edit'])->name('manager.tasks.edit');
    Route::put('manager/tasks/{task}', [TaskController::class, 'update'])->name('manager.tasks.update');
    // حذف مهمة
    Route::delete('manager/tasks/{task}', [TaskController::class, 'destroy'])->name('manager.tasks.destroy');
    // مهامي كعضو
    Route::get('manager/my-tasks', [TaskController::class, 'managerMyTasks'])->name('manager.my-tasks');
    Route::patch('manager/my-tasks/{task}', [TaskController::class, 'updateStatus'])->name('manager.my-tasks.updateStatus');
});

// للعضو: عرض مهامه فقط وتعديل حالتها
Route::middleware(['auth', 'role:member'])->group(function () {
    Route::get('my-tasks', [TaskController::class, 'myTasks'])->name('tasks.my');
    Route::patch('my-tasks/{task}', [TaskController::class, 'updateStatus'])->name('tasks.updateStatus');
});

// =============================
// مسارات الإشعارات
// =============================
Route::middleware('auth')->group(function () {
    Route::get('notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('notifications/unread', [NotificationController::class, 'unread'])->name('notifications.unread');
    Route::patch('notifications/{notification}/read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::patch('notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::delete('notifications/{notification}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::delete('notifications', [NotificationController::class, 'destroyAll'])->name('notifications.destroyAll');
    // مسارات AJAX
    Route::get('notifications/unread-count', [NotificationController::class, 'unreadCount'])->name('notifications.unreadCount');
    Route::get('notifications/latest', [NotificationController::class, 'latest'])->name('notifications.latest');
});

// =============================
// مسارات إدارة الفرق (Teams) للأدمن
// =============================
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::resource('teams', TeamController::class);
});

// =============================
// مسارات فرق المدير (Manager Teams)
// =============================
Route::middleware(['auth', 'team.role:manager'])->group(function () {
    Route::get('manager/teams', [ManagerTeamController::class, 'index'])->name('manager.teams');
    Route::get('manager/teams/{team}', [ManagerTeamController::class, 'show'])->name('manager.teams.show');
    Route::get('manager/teams/{team}/edit', [ManagerTeamController::class, 'edit'])->name('manager.teams.edit');
    Route::put('manager/teams/{team}', [ManagerTeamController::class, 'update'])->name('manager.teams.update');
    Route::delete('manager/teams/{team}', [ManagerTeamController::class, 'destroy'])->name('manager.teams.destroy');
    // إدارة مهام الفرق
    Route::get('manager/teams/{team}/tasks', [ManagerTeamController::class, 'teamTasks'])->name('manager.teams.tasks');
    Route::get('manager/teams/{team}/tasks/create', [ManagerTeamController::class, 'createTask'])->name('manager.teams.tasks.create');
    Route::post('manager/teams/{team}/tasks', [ManagerTeamController::class, 'storeTask'])->name('manager.teams.tasks.store');
    Route::get('manager/teams/{team}/tasks/{task}/edit', [ManagerTeamController::class, 'editTask'])->name('manager.teams.tasks.edit');
    Route::put('manager/teams/{team}/tasks/{task}', [ManagerTeamController::class, 'updateTask'])->name('manager.teams.tasks.update');
    Route::delete('manager/teams/{team}/tasks/{task}', [ManagerTeamController::class, 'destroyTask'])->name('manager.teams.tasks.destroy');
});

// =============================
// مسار جلب أعضاء فريق معين (AJAX)
// =============================
Route::middleware('auth')->group(function () {
    Route::get('teams/{team}/members', [TeamController::class, 'getMembers'])->name('teams.members');
});
