<?php

use App\Http\Controllers\Admin\AnnouncementController as AdminAnnouncementController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\DepartmentController;
use App\Http\Controllers\Admin\RequirementController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Hr\AnnouncementController as HrAnnouncementController;
use App\Http\Controllers\Hr\ApplicationController as HrApplicationController;
use App\Http\Controllers\Hr\AssignmentController as HrAssignmentController;
use App\Http\Controllers\Hr\DashboardController as HrDashboardController;
use App\Http\Controllers\Hr\ReportController;
use App\Http\Controllers\Hr\SubmissionController as HrSubmissionController;
use App\Http\Controllers\Intern\AnnouncementController as InternAnnouncementController;
use App\Http\Controllers\Intern\ApplicationController as InternApplicationController;
use App\Http\Controllers\Intern\DailyLogController as InternDailyLogController;
use App\Http\Controllers\Intern\DashboardController as InternDashboardController;
use App\Http\Controllers\Intern\ProfileController;
use App\Http\Controllers\Supervisor\AnnouncementController as SupervisorAnnouncementController;
use App\Http\Controllers\Supervisor\DailyLogController as SupervisorDailyLogController;
use App\Http\Controllers\Supervisor\DashboardController as SupervisorDashboardController;
use App\Http\Controllers\Supervisor\EvaluationController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::get('/', fn () => redirect()->route('login'));
    Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('login', [LoginController::class, 'login']);
    Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('register', [RegisterController::class, 'register']);
});

Route::middleware('auth', 'active')->group(function () {
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::middleware('role:Intern')->prefix('intern')->name('intern.')->group(function () {
        Route::get('/dashboard', [InternDashboardController::class, 'index'])->name('dashboard');
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');

        Route::get('/applications', [InternApplicationController::class, 'index'])->name('applications.index');
        Route::get('/applications/create', [InternApplicationController::class, 'create'])->name('applications.create');
        Route::post('/applications', [InternApplicationController::class, 'store'])->name('applications.store');
        Route::get('/applications/{application}', [InternApplicationController::class, 'show'])->name('applications.show');
        Route::get('/applications/{application}/submissions/create', [InternApplicationController::class, 'createSubmission'])->name('submissions.create');
        Route::post('/applications/{application}/submissions', [InternApplicationController::class, 'storeSubmission'])->name('submissions.store');

        Route::get('/logs', [InternDailyLogController::class, 'index'])->name('logs.index');
        Route::get('/logs/create', [InternDailyLogController::class, 'create'])->name('logs.create');
        Route::post('/logs', [InternDailyLogController::class, 'store'])->name('logs.store');
        Route::get('/logs/{log}', [InternDailyLogController::class, 'show'])->name('logs.show');

        Route::get('/announcements', [InternAnnouncementController::class, 'index'])->name('announcements.index');
        Route::get('/announcements/{announcement}', [InternAnnouncementController::class, 'show'])->name('announcements.show');

        Route::get('/evaluations', [InternApplicationController::class, 'evaluations'])->name('evaluations.index');
    });

    Route::middleware('role:HR')->prefix('hr')->name('hr.')->group(function () {
        Route::get('/dashboard', [HrDashboardController::class, 'index'])->name('dashboard');

        Route::get('/applications', [HrApplicationController::class, 'index'])->name('applications.index');
        Route::get('/applications/{application}', [HrApplicationController::class, 'show'])->name('applications.show');
        Route::patch('/applications/{application}/approve', [HrApplicationController::class, 'approve'])->name('applications.approve');
        Route::patch('/applications/{application}/reject', [HrApplicationController::class, 'reject'])->name('applications.reject');

        Route::get('/submissions', [HrSubmissionController::class, 'index'])->name('submissions.index');
        Route::get('/submissions/{submission}', [HrSubmissionController::class, 'show'])->name('submissions.show');
        Route::get('/submissions/{submission}/download', [HrSubmissionController::class, 'download'])->name('submissions.download');
        Route::patch('/submissions/{submission}/approve', [HrSubmissionController::class, 'approve'])->name('submissions.approve');
        Route::patch('/submissions/{submission}/reject', [HrSubmissionController::class, 'reject'])->name('submissions.reject');

        Route::get('/assignments', [HrAssignmentController::class, 'index'])->name('assignments.index');
        Route::get('/assignments/create', [HrAssignmentController::class, 'create'])->name('assignments.create');
        Route::post('/assignments', [HrAssignmentController::class, 'store'])->name('assignments.store');
        Route::get('/assignments/{assignment}', [HrAssignmentController::class, 'show'])->name('assignments.show');
        Route::patch('/assignments/{assignment}/complete', [HrAssignmentController::class, 'complete'])->name('assignments.complete');

        Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

        Route::get('/announcements', [HrAnnouncementController::class, 'index'])->name('announcements.index');
        Route::get('/announcements/create', [HrAnnouncementController::class, 'create'])->name('announcements.create');
        Route::post('/announcements', [HrAnnouncementController::class, 'store'])->name('announcements.store');
        Route::get('/announcements/{announcement}/edit', [HrAnnouncementController::class, 'edit'])->name('announcements.edit');
        Route::put('/announcements/{announcement}', [HrAnnouncementController::class, 'update'])->name('announcements.update');
        Route::delete('/announcements/{announcement}', [HrAnnouncementController::class, 'destroy'])->name('announcements.destroy');
    });

    Route::middleware('role:Supervisor')->prefix('supervisor')->name('supervisor.')->group(function () {
        Route::get('/dashboard', [SupervisorDashboardController::class, 'index'])->name('dashboard');

        Route::get('/interns', [SupervisorDashboardController::class, 'interns'])->name('interns.index');
        Route::get('/interns/{assignment}', [SupervisorDashboardController::class, 'internShow'])->name('interns.show');

        Route::get('/logs', [SupervisorDailyLogController::class, 'index'])->name('logs.index');
        Route::get('/logs/{log}', [SupervisorDailyLogController::class, 'show'])->name('logs.show');
        Route::patch('/logs/{log}/approve', [SupervisorDailyLogController::class, 'approve'])->name('logs.approve');
        Route::patch('/logs/{log}/reject', [SupervisorDailyLogController::class, 'reject'])->name('logs.reject');

        Route::get('/evaluations', [EvaluationController::class, 'index'])->name('evaluations.index');
        Route::get('/evaluations/create/{assignment}', [EvaluationController::class, 'create'])->name('evaluations.create');
        Route::post('/evaluations/{assignment}', [EvaluationController::class, 'store'])->name('evaluations.store');
        Route::get('/evaluations/{evaluation}', [EvaluationController::class, 'show'])->name('evaluations.show');

        Route::get('/announcements', [SupervisorAnnouncementController::class, 'index'])->name('announcements.index');
        Route::get('/announcements/{announcement}', [SupervisorAnnouncementController::class, 'show'])->name('announcements.show');
    });

    Route::middleware('role:Admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

        Route::get('/users', [UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/users', [UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::put('/users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::patch('/users/{user}/activate', [UserController::class, 'activate'])->name('users.activate');
        Route::patch('/users/{user}/deactivate', [UserController::class, 'deactivate'])->name('users.deactivate');

        Route::get('/departments', [DepartmentController::class, 'index'])->name('departments.index');
        Route::post('/departments', [DepartmentController::class, 'store'])->name('departments.store');
        Route::get('/departments/{department}/edit', [DepartmentController::class, 'edit'])->name('departments.edit');
        Route::put('/departments/{department}', [DepartmentController::class, 'update'])->name('departments.update');
        Route::delete('/departments/{department}', [DepartmentController::class, 'destroy'])->name('departments.destroy');

        Route::get('/requirements', [RequirementController::class, 'index'])->name('requirements.index');
        Route::post('/requirements', [RequirementController::class, 'store'])->name('requirements.store');
        Route::get('/requirements/{requirement}/edit', [RequirementController::class, 'edit'])->name('requirements.edit');
        Route::put('/requirements/{requirement}', [RequirementController::class, 'update'])->name('requirements.update');
        Route::delete('/requirements/{requirement}', [RequirementController::class, 'destroy'])->name('requirements.destroy');

        Route::get('/announcements', [AdminAnnouncementController::class, 'index'])->name('announcements.index');
        Route::get('/announcements/create', [AdminAnnouncementController::class, 'create'])->name('announcements.create');
        Route::post('/announcements', [AdminAnnouncementController::class, 'store'])->name('announcements.store');
        Route::delete('/announcements/{announcement}', [AdminAnnouncementController::class, 'destroy'])->name('announcements.destroy');
    });
});
