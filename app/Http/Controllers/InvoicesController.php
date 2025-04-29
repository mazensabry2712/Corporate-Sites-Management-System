<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use App\Models\projects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InvoicesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = invoices::all();
        return view('dashboard.invoice.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // $invoices = invoices::all();
        $pr_number_idd = projects::all();
        return view('dashboard.invoice.create', compact('pr_number_idd'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'invoice_number' => 'required',//|unique:invoices,invoice_number',
            'value' => 'nullable|numeric',
            'pr_number' => "nullable|exists:projects,id",
            'invoice_copy_path' => 'nullable|mimes:pdf',
            'status' => 'required|string',
            'pr_invoices_total_value' => 'nullable|numeric'
        ]);

        if($request->has('invoice_copy_path')) {
            $data['invoice_copy_path'] = $request->file("invoice_copy_path")->store("uploads",[
                "disk"=>"public",
            ]);
        }

        // Create a new invoice
        Invoices::create($data);

        session()->flash('Add', 'Registration successful');

        return redirect('/invoices');
    }

    /**
     * Display the specified resource.
     */
    public function show(invoices $invoices)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $invoices = invoices::find($id);
        $pr_number_idd = projects::all();
        return view('dashboard.invoice.edit', compact('invoices', 'pr_number_idd'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $invoices = invoices::find($id);

        $data = $request->validate([
            'invoice_number' => 'required|unique:invoices',//.$invoices->invoice_number,
            'value' => 'nullable|numeric',
            'invoice_copy_path' => 'nullable|mimes:pdf',
            'status' => 'required|string',
            'pr_invoices_total_value' => 'nullable|numeric',
            'pr_number' => "nullable|exists:projects,id"
        ]);

        $invoices->update([
            'invoice_number' => $request->invoice_number,
            'value' => $request->value,
            'invoice_copy_path' => $request->invoice_copy_path,
            'status' => $request->status,
            'pr_invoices_total_value' => $request->pr_invoices_total_value,
            'pr_number' => $request->pr_number
        ]);

        if($request->has('invoice_copy_path')) {
            $data['invoice_copy_path'] = $request->file("invoice_copy_path")->store("uploads",[
                "disk"=>"public",
            ]);
        }

        session()->flash('edit', 'The section has been successfully modified');
        
        return redirect('/invoices'); // إعادة التوجيه إل
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $id = $request->id;
        invoices::find($id)->delete();
        session()->flash('delete', 'Deleted successfully');

        return redirect('/invoices');

    }
}
