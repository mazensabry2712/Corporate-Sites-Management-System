<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Ptasks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PtasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ptasks = Cache::remember('ptasks_list', 3600, function () {
            return Ptasks::with(['project:id,pr_number,name'])
                ->latest()
                ->get();
        });

        return view('dashboard.PTasks.index', compact('ptasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    $projects=Project::all();
       // print_r($projects);
        return view('dashboard.PTasks.create',compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        $validatedData = $request->validate([
            'expected_com_date' => 'nullable',
            'task_date' => 'required',
            'details' => 'nullable|string',
            'assigned' => 'nullable|string',
            'status' => 'required',
            'pr_number'=>"required|exists:projects,id"
        ]);


        Ptasks::create($validatedData);
        Cache::forget('ptasks_list');

        session()->flash('Add', 'Task added successfully');
        return redirect()->route('ptasks.index');


    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $ptask = Ptasks::with(['project'])->findOrFail($id);
        return view('dashboard.PTasks.show', compact('ptask'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
    $projects = Project::all();

        $ptasks=Ptasks::find($id);
        return view('dashboard.PTasks.edit', compact('ptasks', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $ptasks=Ptasks::find($id);
        $validatedData = $request->validate([
            'expected_com_date' => 'nullable',
            'task_date' => 'required',
            'details' => 'nullable|string',
            'assigned' => 'nullable|string',
            'status' => 'required',
            'pr_number'=>"required|exists:projects,id"
        ]);

        $ptasks->update($validatedData);
        Cache::forget('ptasks_list');

        session()->flash('edit', 'Task updated successfully');
        return redirect()->route('ptasks.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        Ptasks::findOrFail($id)->delete();
        Cache::forget('ptasks_list');

        session()->flash('delete', 'Task deleted successfully');
        return redirect()->route('ptasks.index');
    }
}
