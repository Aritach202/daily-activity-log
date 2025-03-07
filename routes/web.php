<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DailyTaskController;

Route::resource('daily-tasks', DailyTaskController::class);

Route::get('/', function () {
    return redirect()->route('daily-tasks.create');
});
