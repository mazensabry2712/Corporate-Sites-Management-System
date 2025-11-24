<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Progress Report - {{ $project->name }}</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: white;
            color: #333;
            line-height: 1.6;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
        }

        .system-header {
            text-align: center;
            margin-bottom: 25px;
            padding: 20px;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            border-radius: 10px;
            border-left: 5px solid #007bff;
        }

        .system-header h1 {
            color: #2c3e50;
            font-size: 24px;
            margin-bottom: 8px;
            font-weight: 700;
        }

        .system-header .report-date {
            color: #6c757d;
            font-size: 14px;
            font-weight: 500;
        }

        .project-header {
            background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);
            padding: 25px 30px;
            border-radius: 12px;
            margin-bottom: 25px;
            box-shadow: 0 4px 15px rgba(0, 123, 255, 0.3);
        }

        .project-header h2 {
            color: white;
            font-size: 24px;
            margin-bottom: 10px;
        }

        .project-header .pr-badge {
            display: inline-block;
            background: white;
            color: #007bff;
            padding: 8px 16px;
            border-radius: 6px;
            font-weight: 700;
            font-size: 14px;
        }

        .details-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }

        .detail-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            border-left: 4px solid;
        }

        .detail-card.customer { border-left-color: #007bff; }
        .detail-card.pm { border-left-color: #28a745; }
        .detail-card.value { border-left-color: #ffc107; }
        .detail-card.po-date { border-left-color: #dc3545; }

        .detail-label {
            font-size: 12px;
            color: #6c757d;
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .detail-value {
            font-size: 16px;
            color: #2c3e50;
            font-weight: 700;
        }

        .progress-section {
            background: #f8f9fa;
            padding: 30px;
            border-radius: 12px;
            margin-bottom: 30px;
        }

        .progress-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .progress-title {
            font-size: 20px;
            color: #2c3e50;
            font-weight: 700;
        }

        .progress-badge {
            background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
            color: white;
            font-size: 32px;
            font-weight: 700;
            padding: 15px 30px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.4);
        }

        .progress-bar-wrapper {
            background: #e9ecef;
            height: 40px;
            border-radius: 20px;
            overflow: hidden;
            margin-bottom: 25px;
            box-shadow: inset 0 2px 5px rgba(0,0,0,0.1);
        }

        .progress-bar {
            background: linear-gradient(90deg, #28a745 0%, #34ce57 100%);
            height: 100%;
            border-radius: 20px;
            width: {{ $progress }}%;
            box-shadow: 0 2px 10px rgba(40, 167, 69, 0.5);
        }

        .stats-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .stat-card {
            padding: 25px;
            border-radius: 12px;
            border-left: 5px solid;
            box-shadow: 0 3px 12px rgba(0,0,0,0.12);
        }

        .stat-card.pending {
            background: linear-gradient(135deg, #fff3cd 0%, #ffeeba 100%);
            border-left-color: #ffc107;
        }

        .stat-card.completed {
            background: linear-gradient(135deg, #d4edda 0%, #c3e6cb 100%);
            border-left-color: #28a745;
        }

        .stat-card.total {
            background: linear-gradient(135deg, #e2e3e5 0%, #d6d8db 100%);
            border-left-color: #6c757d;
        }

        .stat-label {
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 10px;
            text-transform: uppercase;
        }

        .stat-card.pending .stat-label { color: #856404; }
        .stat-card.completed .stat-label { color: #155724; }
        .stat-card.total .stat-label { color: #495057; }

        .stat-number {
            font-size: 42px;
            font-weight: 700;
        }

        .stat-card.pending .stat-number { color: #ffc107; }
        .stat-card.completed .stat-number { color: #28a745; }
        .stat-card.total .stat-number { color: #495057; }

        .additional-stats {
            margin-bottom: 30px;
            page-break-before: always;
            padding-top: 20px;
        }

        .stats-title {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 15px 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 18px;
            font-weight: 700;
        }

        .additional-stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .stat-box {
            color: white;
            padding: 25px 20px;
            border-radius: 12px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .stat-box-header {
            font-size: 13px;
            opacity: 0.95;
            margin-bottom: 12px;
            font-weight: 600;
            text-transform: uppercase;
        }

        .stat-box-content {
            font-size: 16px;
            line-height: 1.8;
            max-height: 120px;
            overflow-y: auto;
            margin: 10px 0;
        }

        .stat-box-footer {
            font-size: 12px;
            opacity: 0.9;
            margin-top: 10px;
        }

        .tasks-box { background: linear-gradient(135deg, #28a745 0%, #20c997 100%); }
        .risks-box { background: linear-gradient(135deg, #dc3545 0%, #c82333 100%); }
        .milestones-box { background: linear-gradient(135deg, #ffc107 0%, #e0a800 100%); }
        .invoices-box { background: linear-gradient(135deg, #17a2b8 0%, #138496 100%); }

        .footer {
            margin-top: 40px;
            padding-top: 20px;
            border-top: 2px solid #dee2e6;
            text-align: center;
        }

        .footer-text {
            color: #6c757d;
            font-size: 12px;
            margin-bottom: 8px;
        }

        .footer-timestamp {
            color: #495057;
            font-size: 11px;
            font-style: italic;
        }

        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="system-header">
            <h1><i class="fas fa-building"></i> MDSJEDPR - Corporate Sites Management System</h1>
            <div class="report-date">
                <i class="fas fa-calendar-alt"></i> Report generated on {{ date('F d, Y') }} at {{ date('h:i A') }}
            </div>
        </div>

        <div class="project-header">
            <h2>{{ $project->name }}</h2>
            <span class="pr-badge">PR# {{ $project->pr_number }}</span>
        </div>

        <div class="details-grid">
            <div class="detail-card customer">
                <div class="detail-label"><i class="fas fa-building"></i> Customer</div>
                <div class="detail-value">{{ $project->cust->name ?? 'N/A' }}</div>
            </div>
            <div class="detail-card pm">
                <div class="detail-label"><i class="fas fa-user-tie"></i> Project Manager</div>
                <div class="detail-value">{{ $project->ppms->name ?? 'N/A' }}</div>
            </div>
            <div class="detail-card value">
                <div class="detail-label"><i class="fas fa-dollar-sign"></i> Project Value</div>
                <div class="detail-value">{{ number_format($project->value ?? 0, 2) }} SAR</div>
            </div>
            <div class="detail-card po-date">
                <div class="detail-label"><i class="fas fa-calendar-alt"></i> PO Date</div>
                <div class="detail-value">{{ $project->customer_po_date ?? 'N/A' }}</div>
            </div>
        </div>

        <div class="progress-section">
            <div class="progress-header">
                <div class="progress-title">
                    <i class="fas fa-chart-line" style="color: #28a745;"></i> Project Progress
                </div>
                <div class="progress-badge">{{ $progress }}%</div>
            </div>

            <div class="progress-bar-wrapper">
                <div class="progress-bar"></div>
            </div>

            <div class="stats-grid">
                <div class="stat-card pending">
                    <div class="stat-label">
                        <i class="fas fa-clock"></i> Pending Tasks
                    </div>
                    <div class="stat-number">{{ $pendingTasks }}</div>
                </div>
                <div class="stat-card total">
                    <div class="stat-label">
                        <i class="fas fa-list"></i> Total Tasks
                    </div>
                    <div class="stat-number">{{ $totalTasks }}</div>
                </div>
            </div>
        </div>

        <div class="additional-stats">
            <div class="stats-title">
                <i class="fas fa-chart-bar"></i> Project Statistics
            </div>

            <div class="additional-stats-grid">
                <div class="stat-box tasks-box">
                    <div class="stat-box-header">Tasks Assigned To</div>
                    <div class="stat-box-content">
                        @if($assignedNames->count() > 0)
                            @foreach($assignedNames as $name)
                                • {{ $name }}<br>
                            @endforeach
                        @else
                            No assignments
                        @endif
                    </div>
                    <div class="stat-box-footer">{{ $pendingTasks }}/{{ $totalTasks }} Pending</div>
                </div>

                <div class="stat-box risks-box">
                    <div class="stat-box-header">Risks/Issues</div>
                    <div class="stat-box-content">
                        @if($riskNames->count() > 0)
                            @foreach($riskNames as $risk)
                                • {{ $risk }}<br>
                            @endforeach
                        @else
                            No risks
                        @endif
                    </div>
                    <div class="stat-box-footer">{{ $closedRisks }}/{{ $totalRisks }} Closed</div>
                </div>

                <div class="stat-box milestones-box">
                    <div class="stat-box-header">Milestones</div>
                    <div class="stat-box-content">
                        @if($milestoneNames->count() > 0)
                            @foreach($milestoneNames as $milestone)
                                • {{ $milestone }}<br>
                            @endforeach
                        @else
                            No milestones
                        @endif
                    </div>
                    <div class="stat-box-footer">{{ $milestonesDone }}/{{ $totalMilestones }} Done</div>
                </div>

                <div class="stat-box invoices-box">
                    <div class="stat-box-header">Invoice Numbers</div>
                    <div class="stat-box-content">
                        @if($invoiceNumbers->count() > 0)
                            @foreach($invoiceNumbers as $invoice)
                                • {{ $invoice }}<br>
                            @endforeach
                        @else
                            No invoices
                        @endif
                    </div>
                    <div class="stat-box-footer">{{ $invoicesPaid }}/{{ $totalInvoices }} Paid</div>
                </div>
            </div>
        </div>

        <div class="footer">
            <div class="footer-text"><strong>MDSJEDPR</strong> - Corporate Sites Management System</div>
            <div class="footer-timestamp">Report generated on {{ now()->format('F d, Y') }} at {{ now()->format('h:i A') }}</div>
        </div>
    </div>

    <script>
        // Auto print when opened from Print button
        if (window.location.href.includes('/print/')) {
            window.onload = function() {
                setTimeout(function() {
                    window.print();
                }, 500);
            }
        }
    </script>
</body>
</html>
