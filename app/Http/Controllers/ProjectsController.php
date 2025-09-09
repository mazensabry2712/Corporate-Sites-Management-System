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
use Illuminate\Support\Facades\Log;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $projects = projects::with([
                'vendor', 'cust', 'ds', 'aams', 'ppms',
                'customers', 'vendors', 'deliverySpecialists'
            ])->get();
            return view('dashboard.projects.index', compact('projects'));
        } catch (Exception $e) {
            Log::error('Projects index error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error loading projects list!');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        try {
            $ds = Ds::all();
            $custs = Cust::all();
            $aams = aams::all();
            $ppms = ppms::all();
            $vendors = vendors::all();

            return view('dashboard.projects.addpro', compact('ds', 'custs', 'aams', 'ppms', 'vendors'));
        } catch (Exception $e) {
            Log::error('Projects create form error: ' . $e->getMessage());
            return redirect()->route('projects.index')->with('error', 'Error loading create form!');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $this->validateProjectData($request);
            $data = $validated;

            // Handle file uploads
            $data = $this->handleFileUploads($request, $data);

            // Set created by current user
            // $data['Created_by'] = auth()->id();

            // Create the project
            $project = projects::create($data);

            // Handle multiple relationships
            $this->handleMultipleRelationships($project, $request);

            Log::info('Project created successfully', ['project_number' => $data['pr_number']]);
            return redirect()->route('projects.index')->with('success', 'Project created successfully!');
        } catch (Exception $e) {
            Log::error('Project creation error: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Error creating project: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $project = projects::with([
                'vendor', 'cust', 'ds', 'aams', 'ppms',
                'customers', 'vendors', 'deliverySpecialists'
            ])->findOrFail($id);
            return view('dashboard.projects.show', compact('project'));
        } catch (Exception $e) {
            Log::error('Project show error: ' . $e->getMessage(), ['project_id' => $id]);
            return redirect()->route('projects.index')->with('error', 'Project not found!');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try {
            $project = projects::with(['customers', 'vendors', 'deliverySpecialists'])->findOrFail($id);
            $ds = Ds::all();
            $custs = Cust::all();
            $aams = aams::all();
            $ppms = ppms::all();
            $vendors = vendors::all();

            return view('dashboard.projects.edit', compact('project', 'ds', 'custs', 'aams', 'ppms', 'vendors'));
        } catch (Exception $e) {
            Log::error('Project edit form error: ' . $e->getMessage(), ['project_id' => $id]);
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

            $validated = $this->validateProjectData($request, $project->id);
            $data = $validated;

            // Handle file uploads
            $data = $this->handleFileUploads($request, $data, $project);

            $project->update($data);

            // Clear existing relationships
            $project->customers()->detach();
            $project->vendors()->detach();
            $project->deliverySpecialists()->detach();

            // Handle multiple relationships
            $this->handleMultipleRelationships($project, $request);

            Log::info('Project updated successfully', ['project_id' => $id]);
            return redirect()->route('projects.index')->with('success', 'Project updated successfully!');
        } catch (Exception $e) {
            Log::error('Project update error: ' . $e->getMessage(), ['project_id' => $id]);
            return redirect()->back()->withInput()->with('error', 'Error updating project: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $project = projects::findOrFail($id);

            // Delete associated files
            $this->deleteProjectFiles($project);

            $project->delete();

            Log::info('Project deleted successfully', ['project_id' => $id]);
            return redirect()->route('projects.index')->with('success', 'Project deleted successfully!');
        } catch (Exception $e) {
            Log::error('Project deletion error: ' . $e->getMessage(), ['project_id' => $id]);
            return redirect()->route('projects.index')->with('error', 'Error deleting project!');
        }
    }

    /**
     * Validate project data
     */
    private function validateProjectData(Request $request, $projectId = null)
    {
        $uniqueRule = $projectId ? 'required|unique:projects,pr_number,' . $projectId : 'required|unique:projects,pr_number';

        return $request->validate([
            'pr_number' => $uniqueRule,
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
    }

    /**
     * Handle file uploads
     */
    private function handleFileUploads(Request $request, array $data, $project = null)
    {
        if ($request->hasFile('po_attachment')) {
            // Delete old file if updating
            if ($project && $project->po_attachment) {
                $oldFilePath = base_path($project->po_attachment);
                $oldPublicPath = public_path($project->po_attachment);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
                if (file_exists($oldPublicPath)) {
                    unlink($oldPublicPath);
                }
            }

            $file = $request->file('po_attachment');
            $fileName = time() . '_' . $file->getClientOriginalName();

            // حفظ في مجلد storge الأصلي
            $destinationPath = base_path('storge');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $fileName);

            // نسخ إلى مجلد public للعرض
            $publicPath = public_path('storge');
            if (!file_exists($publicPath)) {
                mkdir($publicPath, 0755, true);
            }
            copy(base_path('storge/' . $fileName), $publicPath . '/' . $fileName);

            $data['po_attachment'] = 'storge/' . $fileName;
        }

        if ($request->hasFile('epo_attachment')) {
            // Delete old file if updating
            if ($project && $project->epo_attachment) {
                $oldFilePath = base_path($project->epo_attachment);
                $oldPublicPath = public_path($project->epo_attachment);
                if (file_exists($oldFilePath)) {
                    unlink($oldFilePath);
                }
                if (file_exists($oldPublicPath)) {
                    unlink($oldPublicPath);
                }
            }

            $file = $request->file('epo_attachment');
            $fileName = time() . '_' . $file->getClientOriginalName();

            // حفظ في مجلد storge الأصلي
            $destinationPath = base_path('storge');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            $file->move($destinationPath, $fileName);

            // نسخ إلى مجلد public للعرض
            $publicPath = public_path('storge');
            if (!file_exists($publicPath)) {
                mkdir($publicPath, 0755, true);
            }
            copy(base_path('storge/' . $fileName), $publicPath . '/' . $fileName);

            $data['epo_attachment'] = 'storge/' . $fileName;
        }

        return $data;
    }

    /**
     * Delete project files
     */
    private function deleteProjectFiles($project)
    {
        if ($project->po_attachment) {
            $filePath = base_path($project->po_attachment);
            $publicPath = public_path($project->po_attachment);

            if (file_exists($filePath)) {
                unlink($filePath);
            }
            if (file_exists($publicPath)) {
                unlink($publicPath);
            }
        }

        if ($project->epo_attachment) {
            $filePath = base_path($project->epo_attachment);
            $publicPath = public_path($project->epo_attachment);

            if (file_exists($filePath)) {
                unlink($filePath);
            }
            if (file_exists($publicPath)) {
                unlink($publicPath);
            }
        }
    }

    /**
     * Handle multiple relationships for projects
     */
    private function handleMultipleRelationships($project, Request $request)
    {
        // Handle multiple customers
        if ($request->has('customers') && $request->customers) {
            foreach ($request->customers as $index => $customerId) {
                $isPrimary = ($index === 0); // First selected is primary
                $project->customers()->attach($customerId, [
                    'is_primary' => $isPrimary,
                    'role' => $isPrimary ? 'Primary Customer' : 'Partner Customer',
                    'notes' => null
                ]);
            }
        }

        // Handle multiple vendors
        if ($request->has('vendors') && $request->vendors) {
            foreach ($request->vendors as $index => $vendorId) {
                $isPrimary = ($index === 0); // First selected is primary
                $project->vendors()->attach($vendorId, [
                    'is_primary' => $isPrimary,
                    'service_type' => $isPrimary ? 'Primary Service' : 'Additional Service',
                    'contract_value' => $isPrimary ? $project->value : null,
                    'start_date' => $isPrimary ? $project->customer_po_date : null,
                    'end_date' => $isPrimary ? $project->customer_po_deadline : null,
                    'notes' => null
                ]);
            }
        }

        // Handle multiple delivery specialists
        if ($request->has('delivery_specialists') && $request->delivery_specialists) {
            foreach ($request->delivery_specialists as $index => $dsId) {
                $isLead = ($index === 0); // First selected is lead
                $allocationPercentage = count($request->delivery_specialists) > 1 ?
                    ($isLead ? 60.00 : (40.00 / (count($request->delivery_specialists) - 1))) : 100.00;

                $project->deliverySpecialists()->attach($dsId, [
                    'is_lead' => $isLead,
                    'responsibility' => $isLead ? 'Lead Delivery Specialist' : 'Support Specialist',
                    'allocation_percentage' => $allocationPercentage,
                    'assigned_date' => $project->customer_po_date ?? now(),
                    'notes' => null
                ]);
            }
        }

        // Backward compatibility: handle old field names if new ones are empty
        if ((!$request->has('customers') || empty($request->customers)) && $project->cust_id) {
            $project->customers()->attach($project->cust_id, [
                'is_primary' => true,
                'role' => 'Primary Customer',
                'notes' => null
            ]);
        }

        if ((!$request->has('vendors') || empty($request->vendors)) && $project->vendors_id) {
            $project->vendors()->attach($project->vendors_id, [
                'is_primary' => true,
                'service_type' => 'Primary Service',
                'contract_value' => $project->value,
                'start_date' => $project->customer_po_date,
                'end_date' => $project->customer_po_deadline,
                'notes' => null
            ]);
        }

        if ((!$request->has('delivery_specialists') || empty($request->delivery_specialists)) && $project->ds_id) {
            $project->deliverySpecialists()->attach($project->ds_id, [
                'is_lead' => true,
                'responsibility' => 'Lead Delivery Specialist',
                'allocation_percentage' => 100.00,
                'assigned_date' => $project->customer_po_date ?? now(),
                'notes' => null
            ]);
        }
    }
}
