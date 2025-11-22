<?php

namespace App\Http\Controllers;

use App\Models\aams;
use App\Models\Coc;
use App\Models\Cust;
use App\Models\Dn;
use App\Models\Ds;
use App\Models\invoices;
use App\Models\Milestones;
use App\Models\Pepo;
use App\Models\ppms;
use App\Models\Ppos;
use App\Models\Project;
use App\Models\Pstatus;
use App\Models\Ptasks;
use App\Models\Risks;
use App\Models\User;
use App\Models\vendors;
use Flowframe\Trend\Trend;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource with advanced filtering.
     */
    public function index(Request $request)
    {
        // Base counts (always show total)
        $userCount = User::count();
        $projectcount = Project::count();
        $custCount = Cust::count();
        $pmCount = ppms::count();
        $amCount = aams::count();
        $VendorsCount = vendors::count();
        $dsCount = Ds::count();
        $invoiceCount = invoices::count();
        $dnCount = Dn::count();
        $cocCount = Coc::count();
        $posCount = Ppos::count();
        $statusCount = Pstatus::count();
        $tasksCount = Ptasks::count();
        $epoCount = Pepo::count();
        $reskCount = Risks::count();
        $milestonesCount = Milestones::count();

        // Get filter data for dropdowns
        $projects = Project::with(['ppms', 'aams', 'cust'])->get();
        $projectNames = Project::pluck('name')->unique()->sort()->values();
        $projectManagers = ppms::pluck('name')->unique()->sort()->values();
        $accountManagers = aams::pluck('name')->unique()->sort()->values();
        $customers = Cust::pluck('name')->unique()->sort()->values();

        // Initialize filtered data as empty collections
        $filteredProjects = collect();
        $hasFilters = false;

        // Check if any filters are applied
        if ($request->has('filter') && !empty(array_filter($request->filter))) {
            $hasFilters = true;

            // Start with base query - Load all relationships
            $query = Project::query()->with([
                'ppms',
                'aams',
                'cust',
                'latestStatus',
                'tasks',
                'risks',
                'milestones',
                'invoices'
            ]);

            // Apply manual filters
            $filters = $request->filter;

            // Filter by PR Number
            if (!empty($filters['pr_number']) && $filters['pr_number'] !== 'all') {
                $query->where('pr_number', $filters['pr_number']);
            }

            // Filter by Project Name
            if (!empty($filters['project_name']) && $filters['project_name'] !== 'all') {
                $query->where('name', $filters['project_name']);
            }

            $filteredProjects = $query->get();
        }

        return view("admin.dashboard", compact(
            'projectcount',
            'tasksCount',
            'milestonesCount',
            'reskCount',
            'epoCount',
            'userCount',
            'statusCount',
            'posCount',
            'cocCount',
            'dnCount',
            'invoiceCount',
            'custCount',
            'pmCount',
            'amCount',
            'VendorsCount',
            'dsCount',
            // Filter dropdown data
            'projectNames',
            'projectManagers',
            'accountManagers',
            'customers',
            'projects',
            // Filtered results
            'filteredProjects',
            'hasFilters'
        ));
    }


}
