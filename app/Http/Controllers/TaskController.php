<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Traits\Api;
use Illuminate\Support\Facades\DB;

class TaskController extends Controller
{

    use Api;

    /**
     * Display a listing of the resource.
     */
    public function index(TaskRequest $request)
    {
        //
        try {
            // Get Query Params
            $per_page = $request->get('per_page') ?? 5;
            $current_page = $request->get('current_page') ?? 1;
            $keywords = $request->get('keywords');

            // Initialize Primary Query
            $tasks = Task::owned()->orderBy('id', 'desc');

            // Search Query
            if ($keywords) {
                $tasks
                    ->where('title', 'like', "%$keywords%")
                    ->orWhere('description', 'like', "%$keywords%");
            }

            // Initialize Pagination
            $data = $tasks->paginate($per_page, ['*'], 'page', $current_page);

            // Create Pagination
            return $this->paginate(TaskResource::collection($data), [
                'total' => $data->total(),
                'last_page' => $data->lastPage(),
                'current_page' => $data->currentPage(),
                'per_page' => $data->perPage(),
            ], "Success");

        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request)
    {
        //
        try {
            DB::beginTransaction();

            $user_id = Auth()->user()->id;

            $task = Task::create([
                'title' => $request->get('title'),
                'description' => $request->get('description'),
                'date_due' => $request->get('date_due'),
                'is_completed' => $request->get('is_completed'),
                'user_id' => 1
            ]);

            DB::commit();

            return $this->apiSuccess('Task has been created successfully.', new TaskResource($task));
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        try {
            $task = Task::owned()->find($id);
            return $this->apiSuccess('Action Success', new TaskResource(($task)));
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskRequest $request, string $id)
    {
        //
        try {
            DB::beginTransaction();

            $task = Task::owned()->find($id);
            $task->title = $request->get('title');
            $task->description = $request->get('description');
            $task->date_due = $request->get('date_due');
            $task->is_completed = $request->get('is_completed');
            $task->save();

            DB::commit();

            return $this->apiSuccess('Task has been updated successfully.', new TaskResource($task));
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::beginTransaction();
            $ids = $myArray = explode(',', $id);

            Task::owned()->whereIn('id', $ids)->delete();

            DB::commit();

            return $this->apiSuccess('Task has been deleted successfully.');
        } catch (\Exception $e) {
            abort(500, $e->getMessage());
        }
    }
}
