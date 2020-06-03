<?php

namespace App\Http\Controllers;

use App\Models\AdminPower;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    //
    public function  home(){
        $admin_power = new AdminPower();
        return 'Hello World';
    }

    public function index(){
        return view('task.index')
            ->with('tasks',Task::all());
    }

    public function store(Request $request){
        $task = new Task();
        $task->title = $request->input('title');
        $task->description = $request->input('description');
        $task->save();
        return redirect('task');
    }
}
