<?php

namespace App\Http\Controllers;

use App\Models\Pepo;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PepoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // استخدام Eager Loading للسرعة
        $pepo = Pepo::with(['project:id,pr_number,name'])->latest()->get();

        return view('dashboard.PEPO.index', compact('pepo'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = Project::select('id', 'pr_number', 'name')
            ->orderBy('pr_number')
            ->get();

        return view('dashboard.PEPO.create', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pr_number' => 'required|exists:projects,id',
            'category' => 'nullable|string|max:255',
            'planned_cost' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
        ]);

        Pepo::create($validated);

        session()->flash('Add', 'PEPO added successfully');
        return redirect()->route('epo.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pepo = Pepo::with('project')->findOrFail($id);
        return view('dashboard.PEPO.show', compact('pepo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $pepo = Pepo::with('project')->findOrFail($id);
        $projects = Project::select('id', 'pr_number', 'name')
            ->orderBy('pr_number')
            ->get();

        return view('dashboard.PEPO.edit', compact('pepo', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $pepo = Pepo::findOrFail($id);

        $validated = $request->validate([
            'pr_number' => 'required|exists:projects,id',
            'category' => 'nullable|string|max:255',
            'planned_cost' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
        ]);

        $pepo->update($validated);

        session()->flash('edit', 'PEPO updated successfully');
        return redirect()->route('epo.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $pepo = Pepo::findOrFail($request->id);
        $pepo->delete();

        session()->flash('delete', 'PEPO deleted successfully');
        return redirect()->route('epo.index');
    }
}
