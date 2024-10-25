<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller {
    public function index() {
        return Project::all();
    }

    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
        ]);

        $project = $request->user()->projects()->create($request->all());

        return response()->json($project, 201);
    }

    public function show($id)
    {
        $project = Project::find($id);
    
        if (!$project) {
            return response()->json(['message' => 'Project not found'], 404);
        }
    
        return response()->json($project, 200);
    }
    

    public function update(Request $request, Project $project) {
        $this->authorize('update', $project);
        $project->update($request->all());

        return response()->json($project, 200);
    }

    public function destroy(Project $project) {
        $this->authorize('delete', $project);
        $project->delete();

        return response()->json(null, 204);
    }
}
