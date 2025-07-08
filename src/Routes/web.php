<?php

use Illuminate\Support\Facades\Route;
use Alaa\TaskManager\Http\Controllers\TaskController;
use Alaa\TaskManager\Http\Controllers\NotificationController;

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
