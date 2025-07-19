<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\Ds;
use App\Models\aams;
use App\Models\Cust;
use App\Models\ppms;
use App\Models\vendors;
use App\Models\projects;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = projects::with(['vendor', 'cust', 'ds', 'aams', 'ppms'])->get();
        return view('dashboard.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ds = Ds::all();
        $custs = Cust::all();
        $aams = aams::all();
        $ppms = ppms::all();
        $vendors = vendors::all();

        return view('dashboard.projects.addpro', compact('ds', 'custs', 'aams', 'ppms', 'vendors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pr_number' => 'required|unique:projects,pr_number',
            'name' => 'required|string|max:255',
            'technologies' => 'nullable|string',
            'vendors_id' => 'nullable|exists:vendors,id',
            'cust_id' => 'nullable|exists:custs,id',
            'ds_id' => 'nullable|exists:ds,id',
            'aams_id' => 'nullable|exists:aams,id',
            'ppms_id' => 'nullable|exists:ppms,id',
            'value' => 'nullable|numeric',
            'customer_name' => 'nullable|string|max:255',
            'customer_po' => 'nullable|string',
            'ac_manager' => 'nullable|string|max:255',
            'project_manager' => 'nullable|string|max:255',
            'customer_contact_details' => 'nullable|string',
            'customer_po_date' => 'nullable|date',
            'customer_po_duration' => 'nullable|integer',
            'customer_po_deadline' => 'nullable|date',
            'description' => 'nullable|string',
            'po_attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
            'epo_attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
        ]);

        $data = $validated;

        // Handle file uploads
        if ($request->hasFile('po_attachment')) {
            $data['po_attachment'] = $request->file('po_attachment')->store('uploads/po_attachments', 'public');
        }

        if ($request->hasFile('epo_attachment')) {
            $data['epo_attachment'] = $request->file('epo_attachment')->store('uploads/epo_attachments', 'public');
        }

        // Set created by current user
        // $data['Created_by'] = auth()->id();

        projects::create($data);

        return redirect()->route('projects.index')->with('success', 'Project created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $project = projects::with(['vendor', 'cust', 'ds', 'aams', 'ppms'])->findOrFail($id);
            return view('dashboard.projects.show', compact('project'));
        } catch (Exception $e) {
            return redirect()->route('projects.index')->with('error', 'Project not found!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $project = projects::findOrFail($id);
            $ds = Ds::all();
            $custs = Cust::all();
            $aams = aams::all();
            $ppms = ppms::all();
            $vendors = vendors::all();

            return view('dashboard.projects.edit', compact('project', 'ds', 'custs', 'aams', 'ppms', 'vendors'));
        } catch (Exception $e) {
            return redirect()->route('projects.index')->with('error', 'Project not found!');
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $project = projects::findOrFail($id);

            $validated = $request->validate([
                'pr_number' => 'required|unique:projects,pr_number,' . $project->id,
                'name' => 'required|string|max:255',
                'technologies' => 'nullable|string',
                'vendors_id' => 'nullable|exists:vendors,id',
                'cust_id' => 'nullable|exists:custs,id',
                'ds_id' => 'nullable|exists:ds,id',
                'aams_id' => 'nullable|exists:aams,id',
                'ppms_id' => 'nullable|exists:ppms,id',
                'value' => 'nullable|numeric',
                'customer_name' => 'nullable|string|max:255',
                'customer_po' => 'nullable|string',
                'ac_manager' => 'nullable|string|max:255',
                'project_manager' => 'nullable|string|max:255',
                'customer_contact_details' => 'nullable|string',
                'customer_po_date' => 'nullable|date',
                'customer_po_duration' => 'nullable|integer',
                'customer_po_deadline' => 'nullable|date',
                'description' => 'nullable|string',
                'po_attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
                'epo_attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
            ]);

            $data = $validated;

            // Handle file uploads
            if ($request->hasFile('po_attachment')) {
                $data['po_attachment'] = $request->file('po_attachment')->store('uploads/po_attachments', 'public');
            }

            if ($request->hasFile('epo_attachment')) {
                $data['epo_attachment'] = $request->file('epo_attachment')->store('uploads/epo_attachments', 'public');
            }

            $project->update($data);

            return redirect()->route('projects.index')->with('success', 'Project updated successfully!');
        } catch (Exception $e) {
            return redirect()->route('projects.index')->with('error', 'Error updating project!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $project = projects::findOrFail($id);
            $project->delete();

            return redirect()->route('projects.index')->with('success', 'Project deleted successfully!');
        } catch (Exception $e) {
            return redirect()->route('projects.index')->with('error', 'Error deleting project!');
        }
    }
}
