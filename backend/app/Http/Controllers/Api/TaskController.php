<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
      public function __construct()
    {
        $this->middleware('verified');
    }
    
    public function index()
    {
        return Task::all();
    }

    public function store(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
            'note' => 'nullable|string',
            'isActive' => 'required|boolean',
            'isFinished' => 'required|boolean',
            'isDeleted' => 'required|boolean',
            'user_id' => 'required|exists:users,id',
            'orderNumber' => 'nullable|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }

        // Create a new task
        $task = Task::create($request->all());

        return response()->json(['message' => 'Task created successfully', 'task' => $task], 201);
    }
    
    public function updateOrderNumber(Request $request, $id)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'orderNumber' => 'required|integer', // Add validation for orderNumber
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }

        // Find the task
        $task = Task::findOrFail($id);

        // Update the orderNumber
        $task->orderNumber = $request->input('orderNumber');
        $task->save();

        return response()->json(['message' => 'Order number updated successfully', 'task' => $task], 200);
    }

    public function show($id)
    {
        return Task::findOrFail($id);
    }

    public function active($id)
    {
        $task = Task::findOrFail($id);

        if ($task->isActive) {
            return response()->json(['error' => 'Task is already active'], 400);
        }

        $task->isActive = 1;
        $task->save();

        return response()->json(['message' => 'Task marked as active'], 201);
    }

    public function finished($id)
    {
        $task = Task::findOrFail($id);

        if ($task->isFinished) {
            return response()->json(['error' => 'Task is already finished'], 400);
        }

        $task->isFinished = 1;
        $task->save();

        return response()->json(['message' => 'Task marked as finished'], 201);
    }

    public function isfiltered($id)
    {
        $task = Task::findOrFail($id);

        if ($task->isDeleted) {
            return response()->json(['error' => 'Task is already filtered'], 400);
        }

        $task->isDeleted = 1;
        $task->save();

        return response()->json(['message' => 'Task marked as filtered'], 201);
    }

    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return response()->json(['message' => 'Task deleted'], 201);
    }
    
    public function update(Request $request, $id)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'content' => 'required|string',
            'note' => 'nullable|string',
            'isActive' => 'required|boolean',
            'isFinished' => 'required|boolean',
            'isDeleted' => 'required|boolean',
            'user_id' => 'required|exists:users,id',
            'orderNumber' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 400);
        }

        // Find the task
        $task = Task::findOrFail($id);

        // Update the task
        $task->update($request->all());

        return response()->json(['message' => 'Task updated successfully', 'task' => $task], 200);
    }
}
