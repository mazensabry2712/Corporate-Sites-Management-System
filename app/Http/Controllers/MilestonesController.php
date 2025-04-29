<?php

namespace App\Http\Controllers;

use App\Models\Milestones;
use App\Models\projects;
use Illuminate\Http\Request;

class MilestonesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $Milestones = Milestones::all();
        return view('dashboard.Milestones.index', compact('Milestones'));
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $projects = projects::all();
    
        
        return view('dashboard.Milestones.create', compact( 'projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        $validatedData = $request->validate([
            'milestone' => 'required|max:255',
            'planned_com' => 'nullable',
            'actual_com' => 'nullable',
            'status' => 'required',
            'comments' => 'nullable|string',
            'pr_number'=>"required|exists:projects,id"
        ]);

        Milestones::create($validatedData);
        session()->flash('Add', 'Registration successful');
            return redirect('/milestones');

    }

    /**
     * Display the specified resource.
     */
    public function show(Milestones $milestones)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //

        $projects = Projects::all();
        $milestones=Milestones::find($id);
        
        return view('dashboard.Milestones.edit', compact('milestones', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $milestones=Milestones::find($id);
         $validatedData = $request->validate([
                'milestone' => 'required|max:255',
                'planned_com' => 'nullable',
                'actual_com' => 'nullable',
                'status' => 'required',
                'comments' => 'nullable|string',
                'pr_number'=>"required|exists:projects,id"
            ]);
    
       

    $milestones->update([
         'pr_number'=>$request->pr_number,
        'milestone'=>$request->milestone,
        'planned_com'=>$request->planned_com,
        'actual_com'=>$request->actual_com,
        'status'=>$request->status,
        'comments'=>$request->comments
        ]);
        session()->flash('edit', 'The section has been successfully modified');
        return redirect('/milestones'); // إعادة التوجيه إلى صفحة الأقسام
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        
        
             $id=$request->id;
            
            Milestones::find($id)->delete();
     
        session()->flash('delete', 'Deleted successfully');

        return redirect('/milestones');

    }
}
