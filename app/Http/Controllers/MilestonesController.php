<?php

namespace App\Http\Controllers;

use App\Models\Milestones;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class MilestonesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Milestones = Cache::remember('milestones_list', 3600, function () {
            return Milestones::with(['project:id,pr_number,name'])->get();
        });
        return view('dashboard.Milestones.index', compact('Milestones'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    $projects = Project::all();


        return view('dashboard.Milestones.create', compact( 'projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'milestone' => 'required|max:255',
            'planned_com' => 'nullable',
            'actual_com' => 'nullable',
            'status' => 'required',
            'comments' => 'nullable|string',
            'pr_number'=>"required|exists:projects,id"
        ]);

        Milestones::create($validatedData);
        Cache::forget('milestones_list');
        session()->flash('Add', 'Registration successful');
        return redirect()->route('milestones.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $milestones = Milestones::with('project')->findOrFail($id);
        return view('dashboard.Milestones.show', compact('milestones'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //

    $projects = Project::all();
        $milestones=Milestones::find($id);

        return view('dashboard.Milestones.edit', compact('milestones', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $milestones = Milestones::findOrFail($id);
        $validatedData = $request->validate([
            'milestone' => 'required|max:255',
            'planned_com' => 'nullable',
            'actual_com' => 'nullable',
            'status' => 'required',
            'comments' => 'nullable|string',
            'pr_number'=>"required|exists:projects,id"
        ]);

        $milestones->update($validatedData);
        Cache::forget('milestones_list');
        session()->flash('edit', 'The section has been successfully modified');
        return redirect()->route('milestones.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        Milestones::findOrFail($id)->delete();
        Cache::forget('milestones_list');
        session()->flash('delete', 'Deleted successfully');
        return redirect()->route('milestones.index');
    }
}
