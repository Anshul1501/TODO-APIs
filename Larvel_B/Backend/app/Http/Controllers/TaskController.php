<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;


class TaskController extends Controller
{
    /*Create a task */
    public function store(Request $request)
{
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    $task = Task::create($validated);

    return response()->json(['message' => 'Task created successfully', 'task' => $task], 201);
}

        /*List all task */
        public function index()
{
    $tasks = Task::all();
    return response()->json(['tasks' => $tasks], 200);
}

/*Update a task*/
public function update(Request $request, $id)
{
    $validated = $request->validate([
        'name' => 'sometimes|string|max:255',
        'description' => 'nullable|string',
    ]);

    $task = Task::find($id);
    if (!$task) {
        return response()->json(['error' => 'Task not found'], 404);
    }

    $task->update($validated);
    return response()->json(['message' => 'Task updated successfully', 'task' => $task], 200);
}

/*Delete a task */
public function destroy($id)
{
    $task = Task::find($id);
    if (!$task) {
        return response()->json(['error' => 'Task not found'], 404);
    }

    $task->delete();
    return response()->json(['message' => 'Task deleted successfully'], 200);
}

}
