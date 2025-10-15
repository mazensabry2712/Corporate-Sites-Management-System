<?php

namespace App\Http\Controllers;

use App\Models\Ppos;
use App\Models\Project;
use App\Models\Pepo;
use App\Models\Ds;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Cache;

class PposController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // استخدام Cache + Eager Loading للسرعة الفائقة
        $ppos = Cache::remember('ppos_list', 3600, function () {
            return Ppos::with(['project:id,pr_number,name', 'pepo:id,category', 'ds:id,dsname'])
                ->latest()
                ->get();
        });

        return view('dashboard.PPOs.index', compact('ppos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    $projects = Project::all();
        $pepos = Pepo::all();
        $dses = Ds::all();

        return view('dashboard.PPOs.create', compact('projects', 'pepos', 'dses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pr_number' => 'required|exists:projects,id',
            'category' => 'required|exists:pepos,id',
            'dsname' => 'required|exists:ds,id',
            'po_number' => 'required|string|max:255|unique:ppos,po_number',
            'value' => 'nullable|numeric|min:0',
            'date' => 'nullable|date',
            'status' => 'nullable|string',
            'updates' => 'nullable|string',
            'notes' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            Ppos::create($request->all());

            // مسح الـ Cache بعد الإضافة
            Cache::forget('ppos_list');

            return redirect()->route('ppos.index')
                ->with('Add', 'PPO has been added successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('Error', 'Failed to create PPO: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $ppo = Ppos::with(['project', 'pepo', 'ds'])->findOrFail($id);
        return view('dashboard.PPOs.show', compact('ppo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ppos $ppo)
    {
    $projects = Project::all();
        $pepos = Pepo::all();
        $dses = Ds::all();

        return view('dashboard.PPOs.edit', compact('ppo', 'projects', 'pepos', 'dses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ppos $ppo)
    {
        $validator = Validator::make($request->all(), [
            'pr_number' => 'required|exists:projects,id',
            'category' => 'required|exists:pepos,id',
            'dsname' => 'required|exists:ds,id',
            'po_number' => 'required|string|max:255|unique:ppos,po_number,' . $ppo->id,
            'value' => 'nullable|numeric|min:0',
            'date' => 'nullable|date',
            'status' => 'nullable|string',
            'updates' => 'nullable|string',
            'notes' => 'nullable|string'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        try {
            $ppo->update($request->all());

            // مسح الـ Cache بعد التحديث
            Cache::forget('ppos_list');

            return redirect()->route('ppos.index')
                ->with('Edit', 'PPO has been updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('Error', 'Failed to update PPO: ' . $e->getMessage())
                ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        try {
            $ppo = Ppos::findOrFail($request->id);
            $ppo->delete();

            // مسح الـ Cache بعد الحذف
            Cache::forget('ppos_list');

            return redirect()->route('ppos.index')
                ->with('delete', 'PPO "' . $request->name . '" has been deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('Error', 'Failed to delete PPO: ' . $e->getMessage());
        }
    }

    /**
     * Get categories for a specific project (AJAX)
     */
    public function getCategoriesByProject($pr_number)
    {
        try {
            $categories = Pepo::where('pr_number', $pr_number)
                ->select('id', 'category')
                ->get();

            return response()->json([
                'success' => true,
                'categories' => $categories
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
