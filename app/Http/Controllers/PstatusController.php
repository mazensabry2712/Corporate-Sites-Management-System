<?php

namespace App\Http\Controllers;

use App\Models\ppms;
use App\Models\projects;
use App\Models\Pstatus;
use Illuminate\Http\Request;

class PstatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $pstatus= Pstatus::all();
        return view('dashboard.PStatus.index', compact('pstatus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $projects=projects::all();
        $ppms=ppms::all();
        return view('dashboard.PStatus.create',compact('projects','ppms'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        $validated = $request->validate([
            'pr_number' => 'nullable|exists:projects,id',
            'date_time' => 'nullable|date',
            'pm_name' => 'nullable||exists:ppms,id',
            'status' => 'nullable|string',
            'actual_completion' => 'nullable|numeric|min:0',
            'expected_completion' => 'nullable|date',
            'date_pending_cost_orders' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        Pstatus::create($validated);
        session()->flash('Add', 'Registration successful');
        return redirect('/pstatus');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pstatus $pstatus)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $projects=projects::all();
        $pstatus=Pstatus::find($id);
        $ppms=ppms::all();
        return view('dashboard.PStatus.edit',compact('projects','pstatus','ppms'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $pstatus=Pstatus::find($id);
        $validated = $request->validate([
            'pr_number' => 'required|exists:projects,id',
            'date_time' => 'nullable|date',
            'pm_name' => 'required||exists:ppms,id',
            'status' => 'nullable|string',
            'actual_completion' => 'nullable|numeric|min:0|max:100',
            'expected_completion' => 'nullable|date',
            'date_pending_cost_orders' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);
        $pstatus->update($validated);
        session()->flash('edit', 'The section has been successfully modified');
        return redirect('/pstatus');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $id=$request->id;
        Pstatus::find($id)->delete();
        session()->flash('delete', 'Deleted successfully');

        return redirect('/pstatus');

    }
}
