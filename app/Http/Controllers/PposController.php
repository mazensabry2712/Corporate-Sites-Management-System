<?php

namespace App\Http\Controllers;

use App\Models\Ppos;
use App\Models\Project;
use App\Models\Pepo;
use App\Models\Ds;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PposController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ppos = Ppos::with(['project', 'pepo', 'ds'])->orderBy('created_at', 'desc')->get();
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
            'status' => 'required|in:Active,Pending,Completed,Cancelled',
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

            return redirect()->route('ppos.index')
                ->with('Add', 'PPO has been added successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('Error', 'Failed to create PPO: ' . $e->getMessage())
                ->withInput();
        }
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
            'status' => 'required|in:Active,Pending,Completed,Cancelled',
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

            return redirect()->route('ppos.index')
                ->with('edit', 'PPO has been updated successfully');
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

            return redirect()->route('ppos.index')
                ->with('delete', 'PPO "' . $request->name . '" has been deleted successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('Error', 'Failed to delete PPO: ' . $e->getMessage());
        }
    }
}
