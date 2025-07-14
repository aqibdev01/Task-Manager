<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

       
        $tasks = Task::where('user_id', auth()->id())->get(); // Fetch tasks for the logged-in user
        return view('tasks.index', compact('tasks')); // Pass 'tasks' to the view
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'=> 'required|string|max:255',
            'description'=> 'nullable|string',
            'deadline'=> 'nullable|date',
        ]);

        Task::create([
            'user_id'=>Auth::id(),
            'title'=> $request->title,
            'description'=> $request->description,
            'status'=> 'Pending',
            'deadline'=> $request->deadline,
        ]);

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        if ($task->user_id !== Auth::id()){
            abort(403);         //Prevent unauthorized Access
        }
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        if ($task->user_id !== Auth::id()){
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:Pending,In_Progress,Completed',
            'deadline' => 'nullable|date',
        ]);
        // dd($request->all());

        $task->update($request->all());

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $task = Task::find($id);
        
        if (!$task) {
            return redirect()->back()->with('error', 'Task not found');
        }

        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully');
    }

}
