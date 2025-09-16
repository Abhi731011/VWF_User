<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    /**
     * Display a listing of available projects.
     */
    public function index()
    {
        $projects = Project::where('status', 'published')
                          ->where('visibility', true)
                          ->with('category')
                          ->orderBy('created_at', 'desc')
                          ->paginate(12);

        return view('projects.index', compact('projects'));
    }

    /**
     * Display the specified project.
     */
    public function show(Project $project)
    {
        // Ensure project is visible and published
        if (!$project->visibility || $project->status !== 'published') {
            abort(404, 'Project not found.');
        }

        // Load related data
        $project->load('category');

        return view('projects.show', compact('project'));
    }
}