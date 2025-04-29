<?php

namespace App\Http\Controllers;

use App\Models\projects;
use App\Models\Ptasks;
use Illuminate\Http\Request;

class PtasksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ptasks = Ptasks::all();
        return view('dashboard.PTasks.index', compact('ptasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $projects=projects::all();
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
        session()->flash('Add', 'Registration successful');
           return redirect('/ptasks');

      
    }

    /**
     * Display the specified resource.
     */
    public function show(Ptasks $ptasks)
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

        $ptasks->update([
         'pr_number'=>$request->pr_number,
        'expected_com_date'=>$request->expected_com_date,
        'task_date'=>$request->task_date,
        'details'=>$request->details,
        'assigned'=>$request->assigned,
        'status'=>$request->status,
        ]);
        session()->flash('edit', 'The section has been successfully modified');
        return redirect('/ptasks'); // إعادة التوجيه إلى صفحة الأقسام
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
       $id=$request->id;
       Ptasks::find($id)->delete();
        session()->flash('delete', 'Deleted successfully');

        return redirect('/ptasks');

    }
}
