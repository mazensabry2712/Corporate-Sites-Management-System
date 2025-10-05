<?php

namespace App\Http\Controllers;

use App\Models\Pepo;
use App\Models\Ppos;
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
        // استخدام Cache + Eager Loading للسرعة الفائقة
        $pepo = Cache::remember('pepo_list', 3600, function () {
            return Pepo::with('project:id,pr_number')->latest()->get();
        });

        return view('dashboard.PEPO.index', compact('pepo'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    $projects=Project::all();
        return view('dashboard.PEPO.create',compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'pr_number' => 'required|exists:projects,id',
            'category' => 'nullable|string|max:255',
            'planned_cost' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
        ]);

        Pepo::create($data);

        // مسح الـ Cache بعد الإضافة
        Cache::forget('pepo_list');

        session()->flash('Add', 'PEPO added successfully');
        return redirect('/epo');
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
        //
        $Pepo=Pepo::find($id);
    $projects=Project::all();
        return view('dashboard.PEPO.edit',compact('projects','Pepo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pepo $pepo)
    {
        $data = $request->validate([
            'pr_number' => 'required|exists:projects,id',
            'category' => 'nullable|string|max:255',
            'planned_cost' => 'required|numeric|min:0',
            'selling_price' => 'required|numeric|min:0',
        ]);

        $pepo->update($data);

        // مسح الـ Cache بعد التعديل
        Cache::forget('pepo_list');

        session()->flash('edit', 'PEPO updated successfully');
        return redirect('/epo');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        Pepo::findOrFail($id)->delete();

        // مسح الـ Cache بعد الحذف
        Cache::forget('pepo_list');

        session()->flash('delete', 'PEPO deleted successfully');
        return redirect('/epo');
    }
}
