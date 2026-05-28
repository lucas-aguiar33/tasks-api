<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();

        $tasks = $user->tasks()->with('user')->paginate(5);

        return TaskResource::collection($tasks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $validated = $request->validated();

        $user = $request->user();

        $task = $user->tasks()->create([
            'title' => $validated['title'],
            'description' => $validated['description'],
            'status' => $validated['status']
        ]);

        return (new TaskResource($task))->additional(['success' => true])->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, String $id)
    {
        $user = $request->user();
        $task = $user->tasks()->findOrFail($id);

        return new TaskResource($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, string $id)
    {
        $validated = $request->validated();

        $user = $request->user();
        $task = $user->tasks()->findOrFail($id);

        $task->update($validated);

        return (new TaskResource($task))->additional([
            'success' => 'true',
        ])->response()->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $user = $request->user();
        $task = $user->tasks()->findOrFail($id);
        $task->delete();

        return response()->json([], 204);
    }

}
