<?php

namespace App\Http\Controllers\User;

use App\Task;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardUserController extends Controller
{
    public function index()
    {
        $currentTime = date('Y-m-d');
        //////Counting tasks
        $taskCount = Task::where('user_id',Auth::user()->id)->get();

        $todoCount = Task::where('status',false)
        ->where('user_id',Auth::user()->id)
        ->where('schedule','>=',$currentTime);

        $doneCount = Task::where('status',true)->get()->where('user_id',Auth::user()->id);
        
        
        $overdueCount = Task::where('user_id',Auth::user()->id)
            ->where('schedule','<',$currentTime)
            ->where('status',false)
            ->count();
        //////finish counting tasks

        /////////SENDING TO THE DASHBOARD

        $doneTasks = Task::where('user_id','=',Auth::user()->id)->where('status',true)->get();

        $todoTasks = Task::where('user_id','=',Auth::user()->id)->where('status',false)
        ->where('schedule','>=',$currentTime)->get();

        $overdueTasks = Task::where('user_id','=',Auth::user()->id)
        ->where('schedule','<',$currentTime)
        ->where('status',false)->get();

        return view('user.dashboard',compact('taskCount','todoCount','doneCount','overdueCount','doneTasks','todoTasks','overdueTasks'));
    }
}
