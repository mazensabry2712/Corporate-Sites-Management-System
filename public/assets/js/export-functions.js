/**
 * Unified Export & Print Functions
 * MDSJEDPR - Corporate Sites Management System
 * Version: 2.0 - Matching Project Status Style
 *
 * Simple functions matching the exact style used in PStatus
 */

// Export to PDF
function exportToPDF() {
    const button = event.target;
    const originalHTML = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
    button.disabled = true;

    // Check if jsPDF is loaded
    if (typeof window.jspdf === 'undefined') {
        loadScript('https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js', () => {
            loadScript('https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.31/jspdf.plugin.autotable.min.js', () => {
                generatePDF(button, originalHTML);
            });
        });
    } else {
        generatePDF(button, originalHTML);
    }
}

function generatePDF(button, originalHTML) {
    try {
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF('l', 'mm', 'a4');

        // Get page title
        const pageTitle = document.querySelector('.card-title')?.textContent || 'Report';

        // Add header
        doc.setFontSize(18);
        doc.text(pageTitle, 14, 15);
        doc.setFontSize(10);
        doc.text('Generated: ' + new Date().toLocaleString(), 14, 22);

        // Get table
        const table = document.querySelector('table');
        if (!table) {
            throw new Error('Table not found');
        }

        // Extract headers
        const headers = [];
        table.querySelectorAll('thead th').forEach((th, index) => {
            const text = th.textContent.trim();
            // Skip Operations column (usually index 1)
            if (index === 0 || index > 1 || text.toLowerCase() !== 'operations') {
                headers.push(text);
            }
        });

        // Extract data
        const data = [];
        table.querySelectorAll('tbody tr').forEach(tr => {
            const row = [];
            tr.querySelectorAll('td').forEach((td, index) => {
                // Skip Operations column (usually index 1)
                if (index === 0 || index > 1) {
                    row.push(td.textContent.trim().replace(/\s+/g, ' '));
                }
            });
            if (row.some(cell => cell !== '')) {
                data.push(row);
            }
        });

        // Generate table
        doc.autoTable({
            head: [headers],
            body: data,
            startY: 28,
            theme: 'grid',
            headStyles: { fillColor: [0, 123, 255], textColor: 255 },
            styles: { fontSize: 8, cellPadding: 2, overflow: 'linebreak' }
        });

        // Save
        doc.save(pageTitle.replace(/\s+/g, '_') + '_' + new Date().getTime() + '.pdf');

        button.innerHTML = originalHTML;
        button.disabled = false;
        showToast('PDF exported successfully!', 'success');
    } catch (error) {
        console.error('PDF Export Error:', error);
        button.innerHTML = originalHTML;
        button.disabled = false;
        showToast('Error exporting PDF: ' + error.message, 'error');
    }
}

// Export to Excel
function exportToExcel() {
    const button = event.target;
    const originalHTML = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
    button.disabled = true;

    // Check if XLSX is loaded
    if (typeof XLSX === 'undefined') {
        loadScript('https://cdn.sheetjs.com/xlsx-0.20.1/package/dist/xlsx.full.min.js', () => {
            generateExcel(button, originalHTML);
        });
    } else {
        generateExcel(button, originalHTML);
    }
}

function generateExcel(button, originalHTML) {
    try {
        const data = [];
        const table = document.querySelector('table');

        if (!table) {
            throw new Error('Table not found');
        }

        // Get headers
        const headerRow = [];
        table.querySelectorAll('thead th').forEach((th, index) => {
            const text = th.textContent.trim();
            // Skip Operations column
            if (index === 0 || index > 1 || text.toLowerCase() !== 'operations') {
                headerRow.push(text);
            }
        });
        data.push(headerRow);

        // Get data
        table.querySelectorAll('tbody tr').forEach(tr => {
            const row = [];
            tr.querySelectorAll('td').forEach((td, index) => {
                // Skip Operations column
                if (index === 0 || index > 1) {
                    row.push(td.textContent.trim().replace(/\s+/g, ' '));
                }
            });
            if (row.some(cell => cell !== '')) {
                data.push(row);
            }
        });

        // Create workbook
        const ws = XLSX.utils.aoa_to_sheet(data);
        const wb = XLSX.utils.book_new();

        const pageTitle = document.querySelector('.card-title')?.textContent || 'Sheet1';
        XLSX.utils.book_append_sheet(wb, ws, pageTitle.substring(0, 31));

        // Save
        XLSX.writeFile(wb, pageTitle.replace(/\s+/g, '_') + '_' + new Date().getTime() + '.xlsx');

        button.innerHTML = originalHTML;
        button.disabled = false;
        showToast('Excel exported successfully!', 'success');
    } catch (error) {
        console.error('Excel Export Error:', error);
        button.innerHTML = originalHTML;
        button.disabled = false;
        showToast('Error exporting Excel: ' + error.message, 'error');
    }
}

// Export to CSV
function exportToCSV() {
    const button = event.target;
    const originalHTML = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
    button.disabled = true;

    try {
        const table = document.querySelector('table');

        if (!table) {
            throw new Error('Table not found');
        }

        let csvContent = '\uFEFF'; // UTF-8 BOM

        // Get headers
        const headers = [];
        table.querySelectorAll('thead th').forEach((th, index) => {
            const text = th.textContent.trim();
            // Skip Operations column
            if (index === 0 || index > 1 || text.toLowerCase() !== 'operations') {
                headers.push('"' + text + '"');
            }
        });
        csvContent += headers.join(',') + '\n';

        // Get data
        table.querySelectorAll('tbody tr').forEach(tr => {
            const row = [];
            tr.querySelectorAll('td').forEach((td, index) => {
                // Skip Operations column
                if (index === 0 || index > 1) {
                    row.push('"' + td.textContent.trim().replace(/\s+/g, ' ') + '"');
                }
            });
            if (row.some(cell => cell !== '""')) {
                csvContent += row.join(',') + '\n';
            }
        });

        // Download
        const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
        const link = document.createElement('a');
        const url = URL.createObjectURL(blob);

        const pageTitle = document.querySelector('.card-title')?.textContent || 'data';
        link.setAttribute('href', url);
        link.setAttribute('download', pageTitle.replace(/\s+/g, '_') + '_' + new Date().getTime() + '.csv');
        link.style.visibility = 'hidden';
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);

        button.innerHTML = originalHTML;
        button.disabled = false;
        showToast('CSV exported successfully!', 'success');
    } catch (error) {
        console.error('CSV Export Error:', error);
        button.innerHTML = originalHTML;
        button.disabled = false;
        showToast('Error exporting CSV: ' + error.message, 'error');
    }
}

// Print Table
function printTable() {
    const button = event.target;
    const originalHTML = button.innerHTML;
    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Loading...';
    button.disabled = true;

    try {
        const table = document.querySelector('table');

        if (!table) {
            throw new Error('Table not found');
        }

        const pageTitle = document.querySelector('.card-title')?.textContent || 'Report';
        const printWindow = window.open('', '_blank');

        printWindow.document.write(`
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="UTF-8">
                <title>${pageTitle}</title>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        padding: 20px;
                    }
                    h1 {
                        color: #333;
                        text-align: center;
                    }
                    .meta {
                        text-align: center;
                        color: #666;
                        margin-bottom: 20px;
                    }
                    table {
                        width: 100%;
                        border-collapse: collapse;
                        margin-top: 20px;
                    }
                    th, td {
                        border: 1px solid #ddd;
                        padding: 8px;
                        text-align: center;
                    }
                    th {
                        background-color: #007bff;
                        color: white;
                        font-weight: bold;
                    }
                    tr:nth-child(even) {
                        background-color: #f2f2f2;
                    }
                    @media print {
                        body { padding: 10px; }
                        table { page-break-inside: auto; }
                        tr { page-break-inside: avoid; }
                    }
                </style>
            </head>
            <body>
                <h1>${pageTitle}</h1>
                <div class="meta">Generated: ${new Date().toLocaleString()}</div>
                ${table.outerHTML}
            </body>
            </html>
        `);

        printWindow.document.close();
        printWindow.onload = function() {
            printWindow.focus();
            setTimeout(() => {
                printWindow.print();
                printWindow.close();
            }, 250);
        };

        button.innerHTML = originalHTML;
        button.disabled = false;
    } catch (error) {
        console.error('Print Error:', error);
        button.innerHTML = originalHTML;
        button.disabled = false;
        showToast('Error printing: ' + error.message, 'error');
    }
}

// Helper function to load external scripts
function loadScript(url, callback) {
    const script = document.createElement('script');
    script.src = url;
    script.onload = callback;
    script.onerror = () => {
        console.error('Failed to load script:', url);
        showToast('Failed to load required library', 'error');
    };
    document.head.appendChild(script);
}

// Helper function to show toast messages
function showToast(message, type = 'success') {
    if (typeof toastr !== 'undefined') {
        toastr.options = {
            closeButton: true,
            progressBar: true,
            positionClass: 'toast-top-right',
            timeOut: 3000
        };
        toastr[type](message);
    } else {
        console.log(message);
    }
}
