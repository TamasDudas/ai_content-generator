<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Project $project)
    {
        abort_if($project->user_id !== auth()->id(), 403);
        $contents = $project->contents()->latest()->get();
        return Inertia::render('contents/index', [
            'contents' => $contents
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('contents/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Project $project)
    {
        abort_if($project->user_id !== auth()->id(), 403);
        try{
            $validated = $request->validate([
            
            'type' => 'required|in:text,image',
            'prompt' => 'required|string',
            'style' => 'nullable|string',
           
        ]);
            $validated['project_id'] = $project->id;
    
            $content = Content::create($validated);
            return redirect()->route('contents.show', $content);
        
        }catch(\Exception $e){
             return redirect()->back()->with('error', 'Hiba történt a project létrehozása során.');
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Content $content)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Content $content)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Content $content)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Content $content)
    {
        //
    }
}
