<?php
namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Project;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    // Show tasks and projects
    public function index(Request $request)
    {
        $projects = Project::all();
        $tasks = [];
        $selectedProject = null;

        if ($request->has('project_id') && $request->project_id) {
            $selectedProject = Project::find($request->project_id);
            $tasks = $selectedProject ? $selectedProject->tasks()->orderBy('priority')->get() : [];
        }

        return view('tasks.index', compact('projects', 'tasks', 'selectedProject'));
    }

    // Store a new project
    public function storeProject(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Project::create(['name' => $request->name]);

        return redirect()->back()->with('success', 'Project created successfully!');
    }

    // Store a new task
    public function storeTask(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'project_id' => 'required|exists:projects,id',
        ]);

        $priority = Task::where('project_id', $request->project_id)->max('priority') + 1;

        Task::create([
            'name' => $request->name,
            'priority' => $priority,
            'project_id' => $request->project_id,
        ]);

        return redirect()->back()->with('success', 'Task added successfully!');
    }

    // Edit a task
    public function edit(Task $task)
    {
        $projects = Project::all();
        $selectedProject = $task->project;
        return view('tasks.edit', compact('task', 'projects', 'selectedProject'));
    }

    // Update a task
    public function update(Request $request, Task $task)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $task->name = $request->name;
        $task->save();

        return redirect()->route('tasks.index', ['project_id' => $task->project_id])
            ->with('success', 'Task updated successfully!');
    }


    // Delete a task
    public function destroy(Task $task)
    {
        $task->delete();
        return redirect()->back()->with('success', 'Task deleted successfully!');
    }

    // Reorder tasks
    public function reorder(Request $request)
    {
        foreach ($request->order as $index => $taskId) {
            Task::where('id', $taskId)->update(['priority' => $index + 1]);
        }

        return response()->json('Task priorities updated');
    }
}
