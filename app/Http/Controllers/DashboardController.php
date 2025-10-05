<?php

namespace App\Http\Controllers;

use App\Models\aams;
use App\Models\Coc;
use App\Models\Cust;
use App\Models\Dn;
use App\Models\ds;
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
        $dsCount = ds::count();
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
        $filteredTasks = collect();
        $filteredMilestones = collect();
        $filteredInvoices = collect();
        $filteredRisks = collect();
        $hasFilters = false;

        // Check if any filters are applied
        if ($request->has('filter') && !empty(array_filter($request->filter))) {
            $hasFilters = true;

            // Start with base query
            $query = Project::query()->with(['ppms', 'aams', 'cust', 'latestStatus']);

            // Apply manual filters
            $filters = $request->filter;

            // Filter by project name
            if (!empty($filters['project']) && $filters['project'] !== 'all') {
                $query->where('name', 'LIKE', "%{$filters['project']}%");
            }

            // Filter by status
            if (!empty($filters['status']) && $filters['status'] !== 'all') {
                $query->whereHas('latestStatus', function ($q) use ($filters) {
                    $q->where('status', 'LIKE', "%{$filters['status']}%");
                });
            }

            // Filter by PM
            if (!empty($filters['pm']) && $filters['pm'] !== 'all') {
                $query->whereHas('ppms', function ($q) use ($filters) {
                    $q->where('name', 'LIKE', "%{$filters['pm']}%");
                });
            }

            // Filter by AM
            if (!empty($filters['am']) && $filters['am'] !== 'all') {
                $query->whereHas('aams', function ($q) use ($filters) {
                    $q->where('name', 'LIKE', "%{$filters['am']}%");
                });
            }

            // Filter by Customer
            if (!empty($filters['customer']) && $filters['customer'] !== 'all') {
                $query->whereHas('cust', function ($q) use ($filters) {
                    $q->where('name', 'LIKE', "%{$filters['customer']}%");
                });
            }

            $filteredProjects = $query->get();

            // Filter Tasks based on project filters
            // Use pr_number field to match with project IDs
            $projectIds = $filteredProjects->pluck('id')->toArray();

            // Tasks Query
            $tasksQuery = Ptasks::query();

            if (!empty($projectIds)) {
                $tasksQuery->whereIn('pr_number', $projectIds);
            }

            if (!empty($filters['task_status'])) {
                $tasksQuery->where('status', $filters['task_status']);
            }

            $filteredTasks = $tasksQuery->get();

            // Milestones Query
            $milestonesQuery = Milestones::query();

            if (!empty($projectIds)) {
                $milestonesQuery->whereIn('pr_number', $projectIds);
            }

            if (!empty($filters['milestone'])) {
                $milestonesQuery->where('status', $filters['milestone']);
            }

            $filteredMilestones = $milestonesQuery->get();

            // Invoices Query
            $invoicesQuery = invoices::query();

            if (!empty($projectIds)) {
                $invoicesQuery->whereIn('pr_number', $projectIds);
            }

            if (!empty($filters['invoice_status']) && $filters['invoice_status'] !== 'all') {
                $invoicesQuery->where('status', 'LIKE', "%{$filters['invoice_status']}%");
            }

            $filteredInvoices = $invoicesQuery->get();

            // Risks Query
            $risksQuery = Risks::query();

            if (!empty($projectIds)) {
                $risksQuery->whereIn('pr_number', $projectIds);
            }

            if (!empty($filters['risk_level'])) {
                $risksQuery->where('impact', $filters['risk_level']);
            }

            if (!empty($filters['risk_status'])) {
                $risksQuery->where('status', $filters['risk_status']);
            }

            $filteredRisks = $risksQuery->get();
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
            'filteredTasks',
            'filteredMilestones',
            'filteredInvoices',
            'filteredRisks',
            'hasFilters'
        ));
    }


}
