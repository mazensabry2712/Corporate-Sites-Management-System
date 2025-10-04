<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Project;
use App\Models\ppms;
use App\Models\aams;
use App\Models\vendors;
use App\Models\ds;
use App\Models\Cust;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource with filters.
     */
    public function index(Request $request)
    {
        // Get data from actual database tables
    $prNumbers = Project::distinct()
            ->whereNotNull('pr_number')
            ->pluck('pr_number')
            ->filter()
            ->sort()
            ->values();

    $projectNames = Project::distinct()
            ->whereNotNull('name')
            ->pluck('name')
            ->filter()
            ->sort()
            ->values();

        $projectManagers = ppms::distinct()
            ->whereNotNull('name')
            ->pluck('name')
            ->filter()
            ->sort()
            ->values();

    $technologies = Project::distinct()
            ->whereNotNull('technologies')
            ->pluck('technologies')
            ->filter()
            ->sort()
            ->values();

        $customerNames = Cust::distinct()
            ->whereNotNull('name')
            ->pluck('name')
            ->filter()
            ->sort()
            ->values();

    $customerPos = Project::distinct()
            ->whereNotNull('customer_po')
            ->pluck('customer_po')
            ->filter()
            ->sort()
            ->values();

        $vendorsList = vendors::distinct()
            ->whereNotNull('vendors')
            ->pluck('vendors')
            ->filter()
            ->sort()
            ->values();

        $suppliers = ds::distinct()
            ->whereNotNull('dsname')
            ->pluck('dsname')
            ->filter()
            ->sort()
            ->values();

        $ams = aams::distinct()
            ->whereNotNull('name')
            ->pluck('name')
            ->filter()
            ->sort()
            ->values();

        // Build query on projects table with relationships
    $reports = QueryBuilder::for(Project::class)
            ->with(['vendor', 'cust', 'ds', 'aams', 'ppms'])
            ->allowedFilters([
                AllowedFilter::callback('pr_number', function ($query, $value) {
                    $query->where('pr_number', '=', $value);
                }),
                AllowedFilter::callback('name', function ($query, $value) {
                    $query->where('name', '=', $value);
                }),
                AllowedFilter::partial('technologies'),
                AllowedFilter::callback('customer_po', function ($query, $value) {
                    $query->where('customer_po', '=', $value);
                }),
                AllowedFilter::callback('project_manager', function ($query, $value) {
                    $query->whereHas('ppms', function ($q) use ($value) {
                        $q->where('name', $value);
                    });
                }),
                AllowedFilter::callback('customer_name', function ($query, $value) {
                    $query->whereHas('cust', function ($q) use ($value) {
                        $q->where('name', $value);
                    });
                }),
                AllowedFilter::callback('vendors', function ($query, $value) {
                    $query->whereHas('vendor', function ($q) use ($value) {
                        $q->where('vendors', $value);
                    });
                }),
                AllowedFilter::callback('suppliers', function ($query, $value) {
                    $query->whereHas('ds', function ($q) use ($value) {
                        $q->where('dsname', $value);
                    });
                }),
                AllowedFilter::callback('am', function ($query, $value) {
                    $query->whereHas('aams', function ($q) use ($value) {
                        $q->where('name', $value);
                    });
                }),
                AllowedFilter::callback('value_min', function ($query, $value) {
                    $query->where('value', '>=', $value);
                }),
                AllowedFilter::callback('value_max', function ($query, $value) {
                    $query->where('value', '<=', $value);
                }),
                AllowedFilter::callback('deadline_from', function ($query, $value) {
                    $query->where('customer_po_deadline', '>=', $value);
                }),
                AllowedFilter::callback('deadline_to', function ($query, $value) {
                    $query->where('customer_po_deadline', '<=', $value);
                }),
                // TODO: Add completion_min and completion_max filters after adding completion_percentage column to projects table
                // AllowedFilter::callback('completion_min', function ($query, $value) {
                //     $query->where('completion_percentage', '>=', $value);
                // }),
                // AllowedFilter::callback('completion_max', function ($query, $value) {
                //     $query->where('completion_percentage', '<=', $value);
                // }),
            ])
            ->defaultSort('-created_at')
            ->get();

        return view('dashboard.reports.index', compact(
            'reports',
            'prNumbers',
            'projectNames',
            'projectManagers',
            'technologies',
            'customerNames',
            'customerPos',
            'vendorsList',
            'suppliers',
            'ams'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'pr_number' => 'nullable|string|max:255',
            'project_name' => 'nullable|string|max:255',
            'project_manager' => 'nullable|string|max:255',
            'technologies' => 'nullable|string',
            'customer_name' => 'nullable|string|max:255',
            'customer_po' => 'nullable|string|max:255',
            'value' => 'nullable|numeric|min:0',
            'invoice_total' => 'nullable|numeric|min:0',
            'customer_po_deadline' => 'nullable|date',
            'actual_completion_percentage' => 'nullable|numeric|min:0|max:100',
            'vendors' => 'nullable|string|max:255',
            'suppliers' => 'nullable|string|max:255',
            'am' => 'nullable|string|max:255',
        ]);

        Report::create($validatedData);

        session()->flash('Add', 'Report created successfully');
        return redirect()->route('reports.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Report $report)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Report $report)
    {
        $validatedData = $request->validate([
            'pr_number' => 'nullable|string|max:255',
            'project_name' => 'nullable|string|max:255',
            'project_manager' => 'nullable|string|max:255',
            'technologies' => 'nullable|string',
            'customer_name' => 'nullable|string|max:255',
            'customer_po' => 'nullable|string|max:255',
            'value' => 'nullable|numeric|min:0',
            'invoice_total' => 'nullable|numeric|min:0',
            'customer_po_deadline' => 'nullable|date',
            'actual_completion_percentage' => 'nullable|numeric|min:0|max:100',
            'vendors' => 'nullable|string|max:255',
            'suppliers' => 'nullable|string|max:255',
            'am' => 'nullable|string|max:255',
        ]);

        $report->update($validatedData);

        session()->flash('edit', 'Report updated successfully');
        return redirect()->route('reports.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Report $report)
    {
        $report->delete();
        session()->flash('delete', 'Report deleted successfully');
        return redirect()->route('reports.index');
    }
}
