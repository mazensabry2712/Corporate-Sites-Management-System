<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers Print View</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        @page {
            size: A4 portrait;
            margin: 10mm;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 9px;
            line-height: 1.3;
            color: #000;
            background: #fff;
        }

        .page {
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            background: white;
            page-break-after: always;
            position: relative;
            padding: 10mm;
        }

        .page-header {
            text-align: center;
            margin-bottom: 5mm;
        }

        .page-header h1 {
            color: #677eea;
            font-size: 14px;
            margin-bottom: 3px;
        }

        .page-header .date {
            color: #787878;
            font-size: 8px;
        }

        .page-footer {
            position: absolute;
            bottom: 5mm;
            left: 0;
            right: 0;
            text-align: center;
            color: #677eea;
            font-weight: bold;
            font-size: 9px;
        }

        .card {
            width: 190mm;
            height: 52mm;
            border: 1.5px solid #677eea;
            border-radius: 3px;
            margin-bottom: 1.5mm;
            page-break-inside: avoid;
            background: white;
            position: relative;
        }

        .card-header {
            background: #677eea;
            color: white;
            padding: 1.5mm 3mm;
            border-radius: 3px 3px 0 0;
            height: 8mm;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-header .customer-name {
            font-weight: bold;
            font-size: 9px;
        }

        .card-header .customer-index {
            font-size: 7px;
        }

        .card-body {
            padding: 2mm 5mm;
        }

        .columns {
            display: flex;
            gap: 2mm;
        }

        .column {
            flex: 1;
        }

        .field {
            margin-bottom: 1mm;
            font-size: 6px;
        }

        .field-label {
            font-weight: bold;
            color: #505050;
            display: inline-block;
            min-width: 32mm;
        }

        .field-value {
            color: #000;
            display: inline-block;
        }

        @media print {
            body {
                margin: 0;
                padding: 0;
            }

            .page {
                margin: 0;
                width: 210mm;
                height: 297mm;
                padding: 10mm;
            }

            .card {
                page-break-inside: avoid;
            }

            .page:last-child {
                page-break-after: avoid;
            }

            @page {
                size: A4 portrait;
                margin: 0;
            }

            * {
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
        }

        @media screen {
            body {
                background: #f5f5f5;
                padding: 20px;
            }

            .page {
                box-shadow: 0 2px 8px rgba(0,0,0,0.1);
                margin-bottom: 20px;
            }
        }
    </style>
</head>
<body>

<script>
    // Auto-trigger print when page loads
    window.addEventListener('load', function() {
        // Small delay to ensure page is fully rendered
        setTimeout(function() {
            window.print();
        }, 500);
    });

    // Close window after printing or canceling
    window.addEventListener('afterprint', function() {
        window.close();
    });

    // Fallback: if window can't close (opened directly), show message
    setTimeout(function() {
        if (!window.opener && document.visibilityState === 'visible') {
            // Window is still open after 5 seconds, probably can't auto-close
            console.log('Print dialog closed. You can close this tab manually.');
        }
    }, 5000);
</script>

@php
    $chunked = $customers->chunk(5);
@endphp

@foreach($chunked as $pageIndex => $pageCustomers)
<div class="page">
    <!-- Page Header -->
    <div class="page-header">
        <h1>Customers Report</h1>
        <div class="date">Generated: {{ date('d/m/Y g:i A') }}</div>
    </div>

    <!-- Cards -->
    @foreach($pageCustomers as $index => $customer)
    @php
        $globalIndex = ($pageIndex * 5) + $loop->iteration;
    @endphp

    <div class="card">
        <!-- Card Header -->
        <div class="card-header">
            <span class="customer-name">{{ $customer->name ?? 'N/A' }}</span>
            <span class="customer-index">Customer #{{ $globalIndex }}</span>
        </div>

        <!-- Card Body -->
        <div class="card-body">
            <div class="columns">
                <!-- Left Column -->
                <div class="column">
                    <div class="field">
                        <span class="field-label">Abbreviation:</span>
                        <span class="field-value">{{ $customer->abb ?? 'N/A' }}</span>
                    </div>
                    <div class="field">
                        <span class="field-label">Type:</span>
                        <span class="field-value">{{ $customer->tybe ?? 'N/A' }}</span>
                    </div>
                    <div class="field">
                        <span class="field-label">Contact Name:</span>
                        <span class="field-value">{{ $customer->customercontactname ?? 'N/A' }}</span>
                    </div>
                </div>

                <!-- Middle Column -->
                <div class="column">
                    <div class="field">
                        <span class="field-label">Position:</span>
                        <span class="field-value">{{ $customer->customercontactposition ?? 'N/A' }}</span>
                    </div>
                    <div class="field">
                        <span class="field-label">Email:</span>
                        <span class="field-value">{{ $customer->email ?? 'N/A' }}</span>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="column">
                    <div class="field">
                        <span class="field-label">Phone:</span>
                        <span class="field-value">{{ $customer->phone ?? 'N/A' }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach

    <!-- Page Footer -->
    <div class="page-footer">
        MDSJEDPR
    </div>
</div>
@endforeach

</body>
</html>
