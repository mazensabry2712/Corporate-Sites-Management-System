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

    /**
     * Generate PDF report for a specific project using TCPDF
     */
    public function exportProjectPDF($prNumber)
    {
        // Load project with all relationships
        $project = Project::where('pr_number', $prNumber)
            ->with(['ppms', 'aams', 'cust', 'tasks', 'risks', 'milestones', 'invoices'])
            ->firstOrFail();

        // Calculate statistics
        $totalTasks = $project->tasks->count();
        $completedTasks = $project->tasks->whereIn('status', ['Completed', 'completed'])->count();
        $progress = $totalTasks > 0 ? round(($completedTasks / $totalTasks) * 100, 1) : 0;

        $totalRisks = $project->risks->count();
        $highRisks = $project->risks->whereIn('impact', ['High', 'high'])->count();

        $totalMilestones = $project->milestones->count();
        $milestonesDone = $project->milestones->whereIn('status', ['Completed', 'completed', 'on track'])->count();

        $totalInvoices = $project->invoices->count();
        $invoicesPaid = $project->invoices->whereIn('status', ['paid', 'Paid'])->count();

        // Get assigned names
        $assignedNames = $project->tasks->pluck('assigned')->filter()->unique();
        $assignedNamesHtml = '';
        if ($assignedNames->count() > 0) {
            foreach ($assignedNames as $name) {
                $assignedNamesHtml .= '• ' . htmlspecialchars($name) . '<br>';
            }
        } else {
            $assignedNamesHtml = 'No assignments';
        }

        // Get risk names
        $riskNames = $project->risks->pluck('risk')->filter()->unique();
        $riskNamesHtml = '';
        if ($riskNames->count() > 0) {
            foreach ($riskNames as $risk) {
                $riskNamesHtml .= '• ' . htmlspecialchars($risk) . '<br>';
            }
        } else {
            $riskNamesHtml = 'No risks';
        }
        $closedRisks = $project->risks->whereIn('status', ['closed'])->count();

        // Get milestone names
        $milestoneNames = $project->milestones->pluck('milestone')->filter()->unique();
        $milestoneNamesHtml = '';
        if ($milestoneNames->count() > 0) {
            foreach ($milestoneNames as $milestone) {
                $milestoneNamesHtml .= '• ' . htmlspecialchars($milestone) . '<br>';
            }
        } else {
            $milestoneNamesHtml = 'No milestones';
        }

        // Get invoice numbers
        $invoiceNumbers = $project->invoices->pluck('invoice_number')->filter()->unique();
        $invoiceNumbersHtml = '';
        if ($invoiceNumbers->count() > 0) {
            foreach ($invoiceNumbers as $invoice) {
                $invoiceNumbersHtml .= '• ' . htmlspecialchars($invoice) . '<br>';
            }
        } else {
            $invoiceNumbersHtml = 'No invoices';
        }

        // Create new PDF document
        $pdf = new \TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        // Set document information
        $pdf->SetCreator('MDSJEDPR');
        $pdf->SetAuthor('Corporate Sites Management System');
        $pdf->SetTitle('Project Progress Report - ' . $project->name);
        $pdf->SetSubject('Project Report');

        // Set margins
        $pdf->SetMargins(15, 15, 15);
        $pdf->SetHeaderMargin(5);
        $pdf->SetFooterMargin(10);

        // Set auto page breaks
        $pdf->SetAutoPageBreak(TRUE, 15);

        // Remove default header/footer
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        // Add a page
        $pdf->AddPage();

        // Set font
        $pdf->SetFont('helvetica', '', 10);

        // Get current date and time
        $dateStr = date('F d, Y');
        $timeStr = date('h:i A');

        // Build HTML content - Matching website design exactly
        $html = '
        <style>
            .header-title { font-size: 22px; font-weight: bold; color: #2c3e50; text-align: center; margin-bottom: 8px; }
            .header-subtitle { font-size: 12px; color: #6c757d; text-align: center; margin-bottom: 15px; }
            .project-name { font-size: 18px; font-weight: bold; color: white; background-color: #007bff; padding: 15px 20px; border-radius: 10px; margin-bottom: 15px; }
            .pr-badge { background-color: white; color: #007bff; padding: 4px 12px; border-radius: 5px; font-size: 12px; font-weight: bold; }
            .info-grid { margin-bottom: 15px; }
            .info-box { background-color: white; padding: 12px 15px; margin-bottom: 0px; text-align: center; }
            .info-box.customer { border-left: 5px solid #007bff; }
            .info-box.pm { border-left: 5px solid #28a745; }
            .info-box.value { border-left: 5px solid #ffc107; }
            .info-box.po-date { border-left: 5px solid #dc3545; }
            .info-label { font-size: 10px; color: #6c757d; text-transform: uppercase; font-weight: bold; margin-bottom: 5px; }
            .info-value { font-size: 13px; color: #2c3e50; font-weight: bold; }
            .progress-section { background-color: #ffffff; padding: 0; margin-bottom: 15px; }
            .progress-header { font-size: 16px; color: #2c3e50; font-weight: bold; margin-bottom: 15px; }
            .progress-bar-bg { background-color: #e9ecef; height: 35px; border-radius: 20px; margin-bottom: 15px; }
            .progress-bar-fill { background-color: #28a745; height: 35px; border-radius: 20px; }
            .stat-box-progress { padding: 20px; border-radius: 12px; border-left: 5px solid; margin-bottom: 10px; }
            .stat-box-progress.completed { background-color: #d4edda; border-left-color: #28a745; }
            .stat-box-progress.total { background-color: #e2e3e5; border-left-color: #6c757d; }
            .stat-label-progress { font-size: 11px; color: #155724; font-weight: bold; text-transform: uppercase; margin-bottom: 8px; }
            .stat-label-progress.total-text { color: #495057; }
            .stat-value-progress { font-size: 36px; color: #28a745; font-weight: bold; }
            .stat-value-progress.total-value { color: #495057; }
            .stat-box { background-color: white; padding: 20px 15px; text-align: center; margin-bottom: 8px; border-radius: 12px; }
            .stat-box.tasks { background-color: #28a745; color: white; }
            .stat-box.risks { background-color: #dc3545; color: white; }
            .stat-box.milestones { background-color: #ffc107; color: white; }
            .stat-box.invoices { background-color: #17a2b8; color: white; }
            .stat-label { font-size: 11px; font-weight: bold; text-transform: uppercase; margin-bottom: 8px; }
            .stat-value { font-size: 32px; font-weight: bold; margin: 5px 0; }
            .stat-detail { font-size: 10px; margin-top: 5px; }
            .footer-text { font-size: 9px; color: #6c757d; text-align: center; margin-top: 15px; border-top: 1px solid #dee2e6; padding-top: 10px; }
        </style>

        <div class="header-title">📊 Project Progress Report</div>
        <div class="header-subtitle">Task Completion Analysis</div>

        <div class="project-name">
            ' . htmlspecialchars($project->name) . '
            <span class="pr-badge">PR# ' . htmlspecialchars($project->pr_number) . '</span>
        </div>

        <table cellpadding="5" cellspacing="8" width="100%" class="info-grid">
            <tr>
                <td width="25%" class="info-box customer">
                    <div class="info-label">🏢 CUSTOMER</div>
                    <div class="info-value">' . htmlspecialchars($project->cust->name ?? 'N/A') . '</div>
                </td>
                <td width="25%" class="info-box pm">
                    <div class="info-label">👔 PROJECT MANAGER</div>
                    <div class="info-value">' . htmlspecialchars($project->ppms->name ?? 'N/A') . '</div>
                </td>
                <td width="25%" class="info-box value">
                    <div class="info-label">💰 PROJECT VALUE</div>
                    <div class="info-value">' . number_format($project->value ?? 0, 2) . ' SAR</div>
                </td>
                <td width="25%" class="info-box po-date">
                    <div class="info-label">📅 PO DATE</div>
                    <div class="info-value">' . htmlspecialchars($project->customer_po_date ?? 'N/A') . '</div>
                </td>
            </tr>
        </table>

        <div class="progress-section">
            <table width="100%">
                <tr>
                    <td width="70%">
                        <div class="progress-header">📊 Project Progress</div>
                    </td>
                    <td width="30%" align="right">
                        <div style="background-color: #28a745; color: white; font-size: 28px; font-weight: bold; padding: 10px 25px; border-radius: 12px; display: inline-block; min-width: 100px; text-align: center;">' . $progress . '%</div>
                    </td>
                </tr>
            </table>

            <div class="progress-bar-bg">
                <div class="progress-bar-fill" style="width: ' . $progress . '%;"></div>
            </div>

            <table width="100%" cellpadding="5" cellspacing="10">
                <tr>
                    <td width="50%" class="stat-box-progress completed">
                        <div class="stat-label-progress">✅ COMPLETED</div>
                        <div class="stat-value-progress">' . $completedTasks . '</div>
                    </td>
                    <td width="50%" class="stat-box-progress total">
                        <div class="stat-label-progress total-text">📝 TOTAL TASKS</div>
                        <div class="stat-value-progress total-value">' . $totalTasks . '</div>
                    </td>
                </tr>
            </table>
        </div>

        <table width="100%" cellpadding="5" cellspacing="10">
            <tr>
                <td width="25%" class="stat-box tasks">
                    <div class="stat-label">Assigned To</div>
                    <div style="font-size: 12px; line-height: 1.6; max-height: 80px; overflow: hidden;">' . $assignedNamesHtml . '</div>
                    <div class="stat-detail">' . $completedTasks . '/' . $totalTasks . ' Completed</div>
                </td>
                <td width="25%" class="stat-box risks">
                    <div class="stat-label">Risk/Issue</div>
                    <div style="font-size: 12px; line-height: 1.6; max-height: 80px; overflow: hidden;">' . $riskNamesHtml . '</div>
                    <div class="stat-detail">' . $closedRisks . '/' . $totalRisks . ' Closed</div>
                </td>
                <td width="25%" class="stat-box milestones">
                    <div class="stat-label">Milestone</div>
                    <div style="font-size: 12px; line-height: 1.6; max-height: 80px; overflow: hidden;">' . $milestoneNamesHtml . '</div>
                    <div class="stat-detail">' . $milestonesDone . '/' . $totalMilestones . ' Done</div>
                </td>
                <td width="25%" class="stat-box invoices">
                    <div class="stat-label">Invoice Number</div>
                    <div style="font-size: 12px; line-height: 1.6; max-height: 80px; overflow: hidden;">' . $invoiceNumbersHtml . '</div>
                    <div class="stat-detail">' . $invoicesPaid . '/' . $totalInvoices . ' Paid</div>
                </td>
            </tr>
        </table>

        <div class="footer-text">
            <strong>MDSJEDPR</strong> - Corporate Sites Management System<br>
            Report generated on ' . $dateStr . ' at ' . $timeStr . '
        </div>
        ';

        // Write HTML content
        $pdf->writeHTML($html, true, false, true, false, '');

        // Output PDF
        $filename = 'Project_PR' . $project->pr_number . '_' . str_replace(' ', '_', $project->name) . '.pdf';
        return $pdf->Output($filename, 'D'); // D = force download
    }


}
