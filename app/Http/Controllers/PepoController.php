<?php

namespace App\Http\Controllers;

use App\Models\Pepo;
use App\Models\Ppos;
use App\Models\projects;
use Illuminate\Http\Request;

class PepoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $pepo= Pepo::all();
        return view('dashboard.PEPO.index', compact('pepo'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $projects=projects::all();
        return view('dashboard.PEPO.create',compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data=$request->validate([
            'pr_number' => 'required|exists:projects,id',
            'category' => 'nullable|string|max:255',
            'planned_cost' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
        ]);

        Pepo::create($data);
        session()->flash('Add', 'Registration successful');
            return redirect('/epo');

        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Pepo $pepo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $Pepo=Pepo::find($id);
        $projects=projects::all();
        return view('dashboard.PEPO.edit',compact('projects','Pepo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pepo $pepo)
    {
        //
        $data=$request->validate([
            'pr_number' => 'required|exists:projects,id',
            'category' => 'nullable|string|max:255',
            'planned_cost' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
        ]);

        $pepo->update($data);
        session()->flash('edit', 'The section has been successfully modified');
        return redirect('/epo'); // 
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $id=$request->id;
        Pepo::find($id)->delete();
        session()->flash('delete', 'Deleted successfully');

        return redirect('/epo');

    }
}
