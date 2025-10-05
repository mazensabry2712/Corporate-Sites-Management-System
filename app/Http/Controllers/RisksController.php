<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Risks;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;


class RisksController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $risks = Cache::remember('risks_list', 3600, function () {
            return Risks::with(['project:id,pr_number,name'])->latest()->get();
        });
        return view('dashboard.Risks.index', compact('risks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    $projects=Project::all();
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
        Cache::forget('risks_list');
        session()->flash('Add', 'Registration successful');
        return redirect()->route('risks.index');


    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $risks = Risks::with(['project'])->findOrFail($id);
        return view('dashboard.Risks.show', compact('risks'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // جلب جميع المشاريع من قاعدة البيانات
    $projects = Project::all();

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

        $risks->update($validatedData);
        Cache::forget('risks_list');
        session()->flash('edit', 'The section has been successfully modified');
        return redirect()->route('risks.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        Risks::findOrFail($id)->delete();
        Cache::forget('risks_list');
        session()->flash('delete', 'Deleted successfully');
        return redirect()->route('risks.index');
    }
}
