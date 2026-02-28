<?php

namespace App\Http\Controllers\Job;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Application;

class JobApplicationController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'job_id'      => ['required', 'exists:jobs,id'],
            'name'        => ['required', 'string', 'max:120'],
            'email'       => ['required', 'email', 'max:150'],
            'resume_link' => ['nullable', 'url', 'max:255'],
            'cover_note'  => ['nullable', 'string', 'max:2000'],
        ]);

        $app = Application::create($data);

        return response()->json([
            'success' => true,
            'message' => 'Application submitted successfully.',
            'data'    => $app,
        ], 201);
    }
}
