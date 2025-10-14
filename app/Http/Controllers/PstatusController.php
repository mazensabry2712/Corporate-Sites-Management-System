<?php

namespace App\Http\Controllers;

use App\Models\ppms;
use App\Models\Project;
use App\Models\Pstatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PstatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pstatus = Cache::remember('pstatus_list', 3600, function () {
            return Pstatus::with(['project:id,pr_number,name', 'ppm:id,name'])
                ->latest()
                ->get();
        });

        return view('dashboard.PStatus.index', compact('pstatus'));
    }

    /**
     * Show the form for creating a new resource.
     */
     public function create()
    {
        // يجب جلب علاقة ppms مع المشاريع لكي تتمكن من الوصول لاسم مدير المشروع
        $projects = Project::with('ppms')->get(); // ⬅️ تم التعديل هنا
        $ppms = ppms::all();
        return view('dashboard.PStatus.create', compact('projects', 'ppms'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pr_number' => 'nullable|exists:projects,id',
            'date_time' => 'nullable|date',
            'pm_name' => 'nullable|exists:ppms,id',
            'status' => 'nullable|string',
            'actual_completion' => 'nullable|numeric|min:0|max:100',
            'expected_completion' => 'nullable|date',
            'date_pending_cost_orders' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        Pstatus::create($validated);
        Cache::forget('pstatus_list');

        session()->flash('Add', 'Project Status added successfully');
        return redirect()->route('pstatus.index');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $pstatus = Pstatus::with(['project', 'ppm'])->findOrFail($id);
        return view('dashboard.PStatus.show', compact('pstatus'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
    $projects=Project::all();
        $pstatus=Pstatus::find($id);
        $ppms=ppms::all();
        return view('dashboard.PStatus.edit',compact('projects','pstatus','ppms'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $pstatus = Pstatus::findOrFail($id);

        $validated = $request->validate([
            'pr_number' => 'required|exists:projects,id',
            'date_time' => 'nullable|date',
            'pm_name' => 'required|exists:ppms,id',
            'status' => 'nullable|string',
            'actual_completion' => 'nullable|numeric|min:0|max:100',
            'expected_completion' => 'nullable|date',
            'date_pending_cost_orders' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $pstatus->update($validated);
        Cache::forget('pstatus_list');

        session()->flash('edit', 'Project Status updated successfully');
        return redirect()->route('pstatus.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        Pstatus::findOrFail($id)->delete();
        Cache::forget('pstatus_list');

        session()->flash('delete', 'Project Status deleted successfully');
        return redirect()->route('pstatus.index');
    }
}
