<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Project;
use App\Models\ppms;
use App\Models\aams;
use App\Models\vendors;
use App\Models\Ds;
use App\Models\Cust;
use App\Http\Requests\ReportFilterRequest;
use App\Services\ReportService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class ReportController extends Controller
{
    /**
     * Report Service Instance
     */
    protected $reportService;

    /**
     * Constructor - Inject ReportService
     */
    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    /**
     * Display a listing of the resource with filters.
     */
    public function index(ReportFilterRequest $request)
    {
        try {
            // Get filter options (cached) - always needed for dropdowns
            $filterOptions = $this->reportService->getFilterOptions();

            // Check if filters are applied
            $hasFilters = $request->hasActiveFilters();

            // Initialize empty collections
            $reports = collect();
            $tablesData = [
                'allVendors' => collect(),
                'allCustomers' => collect(),
                'allProjectManagers' => collect(),
                'allAccountManagers' => collect(),
                'allDeliverySpecialists' => collect(),
                'projectCustomers' => collect(),
                'projectVendors' => collect(),
                'projectDS' => collect(),
            ];
            $statistics = null;

            // Only load data if filters are applied (Performance optimization)
            if ($hasFilters) {
                $filters = $request->input('filter', []);
                $reports = $this->reportService->getFilteredReports($filters);

                // Get all additional tables data (cached)
                $tablesData = $this->reportService->getAllTablesData();

                // Get statistics
                $statistics = $this->reportService->getReportsStatistics();

                // Log filter usage for analytics
                Log::info('Reports filtered', [
                    'filters_count' => $request->getActiveFiltersCount(),
                    'active_filters' => array_keys($request->getActiveFilters()),
                    'results_count' => $reports->count()
                ]);
            }

            return view('dashboard.reports.index', array_merge(
                [
                    'reports' => $reports,
                    'prNumbers' => $filterOptions['prNumbers'],
                    'projectNames' => $filterOptions['projectNames'],
                    'projectManagers' => $filterOptions['projectManagers'],
                    'technologies' => $filterOptions['technologies'],
                    'customerNames' => $filterOptions['customerNames'],
                    'customerPos' => $filterOptions['customerPos'],
                    'vendorsList' => $filterOptions['vendorsList'],
                    'suppliers' => $filterOptions['suppliers'],
                    'ams' => $filterOptions['ams'],
                    'statistics' => $statistics,
                ],
                $tablesData
            ));
        } catch (\Exception $e) {
            Log::error('Error in ReportController@index: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);

            return back()
                ->with('error', 'An error occurred while loading reports. Please try again.')
                ->withInput();
        }
    }

    /**
     * Clear reports cache
     */
    public function clearCache()
    {
        try {
            $this->reportService->clearCache();

            return back()->with('success', 'Reports cache cleared successfully');
        } catch (\Exception $e) {
            Log::error('Error clearing cache: ' . $e->getMessage());
            return back()->with('error', 'Failed to clear cache');
        }
    }

    /**
     * Export filtered reports to CSV
     */
    public function export(ReportFilterRequest $request)
    {
        try {
            $filters = $request->input('filter', []);
            $data = $this->reportService->exportFilteredData($filters);

            $filename = 'reports_export_' . date('Y-m-d_His') . '.csv';

            $headers = [
                'Content-Type' => 'text/csv; charset=utf-8',
                'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            ];

            $callback = function() use ($data) {
                $file = fopen('php://output', 'w');

                // Add BOM for UTF-8
                fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

                // Add headers
                if (!empty($data)) {
                    fputcsv($file, array_keys($data[0]));
                }

                // Add data
                foreach ($data as $row) {
                    fputcsv($file, $row);
                }

                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        } catch (\Exception $e) {
            Log::error('Error exporting reports: ' . $e->getMessage());
            return back()->with('error', 'Failed to export reports');
        }
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
