<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = auth()->user()->projects()->with('contents')->latest()->get();

        return Inertia::render('projects/index', [
            'projects' => $projects,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('projects/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        try{
        $project = auth()->user()->projects()->create($validated);
        return redirect()->route('projects.show', $project)->with('success', 'Project sikeresen létrehozva.');
        }

        catch(\Exception $e){
            return redirect()->back()->with('error', 'Hiba történt a project létrehozása során.');
        }

    }


    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        abort_if($project->user_id !== auth()->id(), 403);

        $project->load('contents');

        return Inertia::render('projects/show', [
            'project' => $project,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        abort_if($project->user_id !== auth()->id(), 403);

        return Inertia::render('projects/edit', [
            'project' => $project,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        abort_if($project->user_id !== auth()->id(), 403);
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);
        try{
            $project->update($validated);
            return redirect()->route('projects.show', $project)->with('success', 'Project sikeresen frissítve.');
        }

        catch(\Exception $e){
            return redirect()->back()->with('error', 'Hiba történt a project frissítése során.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        abort_if($project->user_id !== auth()->id(), 403);

        try{
            $project->delete();
            return redirect()->route('projects.index')->with('success', 'Project sikeresen törölve.');
        }

        catch(\Exception $e){
            return redirect()->back()->with('error', 'Hiba történt a project törlése során.');
        }
    }
}
