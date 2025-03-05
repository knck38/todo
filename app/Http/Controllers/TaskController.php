<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {
        $userId = session('user_id');

        if ($userId) {
            $tasks = Task::where('user_id', $userId)->orderBy('created_at', 'asc')->get();
        } else {
            $tasks = Task::orderBy('created_at', 'asc')->get();
        }

        return Inertia::render('Index', [
            'tasks' => $tasks,
            'userId' => $userId,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {

        $validated = $request->validate([
            'task' => 'required|string|max:255',
        ]);

        $userId = session('user_id');

        Task::create([
            'task' => $validated['task'],
            'user_id' => $userId,
        ]);
    
        return to_route('index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task): Response
    {
        return Inertia::render('Edit', [
            'task' => $task,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task): RedirectResponse
    {
        if ($request->has('status')) {
            //ステータス更新
            $task->status = $request->status;
            $task->save();

        } else {
            //TODO編集画面での更新
            $validated = $request->validate([
                'task' => 'required|string|max:255',
            ]);

            $task->update([
                'task' => $validated['task'],
            ]);
        }

        return to_route('index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task): RedirectResponse
    {
        $task->delete();
        return to_route('index');
    }
}
