<?php

namespace App\Http\Controllers;

use App\Models\ds;
use App\Models\Pepo;
use App\Models\Ppos;
use App\Models\projects;
use Illuminate\Http\Request;

class PposController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        
        $ppos= Ppos::all();
        return view('dashboard.PPOs.index', compact('ppos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = Projects::all();
        
        $pepos = Pepo::all();

        $ds = ds::all();

        return view('dashboard.PPOs.create',compact('projects', 'pepos', 'ds'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validated = $request->validate([
            'pr_number' => 'required|exists:projects,id',
            'category' => 'required|exists:pepos,id',
            'supplier_name' => 'nullable|exists:ds,id',
            'po_number' => 'required|string',
            'value' => 'nullable|numeric',
            'date' => 'nullable|date',
            'status' => 'nullable|string',
            'updates' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        Ppos::create($validated);

       
        session()->flash('Add', 'Registration successful');
            return redirect('/ppos');


    }

    /**
     * Display the specified resource.
     */
    public function show(Ppos $ppos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $ppos=Ppos::find($id);
        $projects = Projects::all();
        $pepos = Pepo::all();
        $ds = ds::all();
        
        return view('dashboard.PPOs.edit',compact('projects', 'pepos', 'ds','ppos'));
       
       
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $ppos=Ppos::find($id);
        $data = $request->validate([
            'pr_number' => 'required|exists:projects,id',
            'category' => 'required|exists:pepos,id',
            'supplier_name' => 'nullable|exists:ds,id',
            'po_number' => 'required|string',
            'value' => 'nullable|numeric',
            'date' => 'nullable|date',
            'status' => 'nullable|string',
            'updates' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        

        $ppos->update($data);
        session()->flash('edit', 'The section has been successfully modified');
        return redirect('/ppos'); // 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ppos $ppos,Request $request)
    {
        //
        $id=$request->id;
        Ppos::find($id)->delete();
        session()->flash('delete', 'Deleted successfully');
            return redirect('/ppos');

    }
}
