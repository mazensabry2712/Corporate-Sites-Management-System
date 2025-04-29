<?php

namespace App\Http\Controllers;

use App\Models\projects;
use App\Models\Risks;
use Illuminate\Http\Request;


class RisksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $risks = Risks::all();
        return view('dashboard.Risks.index', compact('risks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $projects=projects::all();
        return view('dashboard.Risks.create',compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $validatedData = $request->validate([
            'risk' => 'required|max:255',
            'impact' => 'required',
            'mitigation' => 'nullable|string',
            'owner' => 'nullable|string',
            'status' => 'required',
            'pr_number'=>"required|exists:projects,id"
        ]);

        Risks::create($validatedData);
        session()->flash('Add', 'Registration successful');
            return redirect('/risks');


    }

    /**
     * Display the specified resource.
     */
    public function show(Risks $risks)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // جلب جميع المشاريع من قاعدة البيانات
        $projects = Projects::all();
    
        $risks=Risks::find($id);
        return view('dashboard.Risks.edit', compact('risks', 'projects'));
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        $risks=Risks::find($id);
        $validatedData = $request->validate([
            'risk' => 'required|max:255',
            'impact' => 'required',
            'mitigation' => 'nullable|string',
            'owner' => 'nullable|string',
            'status' => 'required',
            'pr_number'=>"required|exists:projects,id"
        ]);

        $risks->update([
         'pr_number'=>$request->pr_number,
        'risk'=>$request->risk,
        'impact'=>$request->impact,
        'mitigation'=>$request->mitigation,
        'owner'=>$request->owner,
        'status'=>$request->status,
        ]);
        session()->flash('edit', 'The section has been successfully modified');
        return redirect('/risks'); // إعادة التوجيه إلى صفحة الأقسام
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $id=$request->id;
        Risks::find($id)->delete();
        session()->flash('delete', 'Deleted successfully');

        return redirect('/risks');

    }
}
