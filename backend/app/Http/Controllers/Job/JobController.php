<?php

namespace App\Http\Controllers\Job;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\Category;

class JobController extends Controller
{
    // GET /api/jobs
    public function index()
    {
        $jobs = Job::with('category:id,name')->latest()->paginate(10);

        return response()->json([
            'success' => true,
            'data' => $jobs,
        ]);
    }

    // GET /api/jobs/{id}
    public function show($id)
    {
        $job = Job::with('category:id,name')->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $job,
        ]);
    }

    // get all category
    public function showCategory(){
        $categorices = Category::all();

        return response()->json([
            'success' => true,
            'data' => $categorices,
        ]);
    }

    // POST /api/jobs (Admin)
    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'company'     => ['required', 'string', 'max:255'],
            'location'    => ['nullable', 'string', 'max:255'],
            'category_id' => ['required', 'integer', 'exists:categories,id'],
            'description' => ['nullable', 'string'],
            'is_active'   => ['nullable', 'boolean'],
        ]);

        // logged-in admin/user id set
        $data['user_id'] = $request->user()->id;

        // if not sent, default true
        $data['is_active'] = (bool)($data['is_active'] ?? true);

        $job = Job::create($data);

        // load relations for response
        $job->load(['user:id,name,email,role', 'category:id,name']);

        return response()->json([
            'success' => true,
            'message' => 'Job created successfully.',
            'data' => $job,
        ], 201);
    }

    // DELETE /api/jobs/{id} (Admin)
    public function destroy($id)
    {
        $job = Job::find($id);

        if (! $job) {
            return response()->json([
                'success' => false,
                'message' => 'Job not found.',
            ], 404);
        }

        $job->delete();

        return response()->json([
            'success' => true,
            'message' => 'Job deleted successfully.',
            'data' => ['id' => $id],
        ]);
    }

    public function show8Jobs(){
        $jobs = Job::with('category:id,name')->latest()->take(8)->get();

        return response()->json([
            'success' => true,
            'data' => $jobs,
        ]);
    }
}
