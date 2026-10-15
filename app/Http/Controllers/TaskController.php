<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request, Project $project)
    {
        abort_unless($project->user_id === $request->user()->id, 403);

        $tasks = $project->tasks()->latest()->get();

        return view('tasks.index', [
            'project' => $project,
            'tasks' => $tasks,
        ]);
    }

    public function store(Request $request, Project $project)
    {
        abort_unless($project->user_id === $request->user()->id, 403);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
        ]);

        $project->tasks()->create($validated);

        return redirect()->route('tasks.index', $project)
            ->with('success', 'Task created successfully.');
    }

    public function edit(Request $request, Task $task)
    {
        abort_unless($task->project->user_id === $request->user()->id, 403);

        return view('tasks.edit', [
            'task' => $task,
        ]);
    }

    public function update(Request $request, Task $task)
    {
        abort_unless($task->project->user_id === $request->user()->id, 403);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
        ]);

        $task->update($validated);

        return redirect()->route('tasks.index', $task->project_id)
            ->with('success', 'Task updated successfully.');
    }

    public function destroy(Request $request, Task $task)
    {
        abort_unless($task->project->user_id === $request->user()->id, 403);

        $projectId = $task->project_id;

        $task->delete();

        return redirect()->route('tasks.index', $projectId)
            ->with('success', 'Task deleted successfully.');
    }

    public function completion(Request $request, Task $task)
    {
        abort_unless($task->project->user_id === $request->user()->id, 403);

        $validated = $request->validate([
            'is_completed' => ['required', 'boolean'],
        ]);

        $task->update($validated);

        return response()->json([
            'is_completed' => $task->is_completed,
        ]);
    }

}