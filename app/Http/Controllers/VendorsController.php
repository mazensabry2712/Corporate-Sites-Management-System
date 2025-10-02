<?php

namespace App\Http\Controllers;

use App\Models\vendors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class VendorsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vendors = Cache::remember('vendors_list', 3600, function () {
            return vendors::select('id', 'vendors', 'vendor_am_details', 'created_at', 'updated_at')->get();
        });

        return view('dashboard.vendors.index', compact('vendors'));
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
            'vendors' => 'required|string|max:255',
            'vendor_am_details' => 'required|string|max:2000',
        ]);

        vendors::create([
            'vendors' => $validatedData['vendors'],
            'vendor_am_details' => $validatedData['vendor_am_details'],
        ]);

        Cache::forget('vendors_list');
        session()->flash('Add', 'Vendor registration successful');
        return redirect('/vendors');
    }

    /**
     * Display the specified resource.
     */
    public function show(vendors $vendors)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(vendors $vendors)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */



    public function update(Request $request)
    {
        $id = $request->id;

        $this->validate(
            $request,
            [
                'vendors' => 'required|max:255',
                'vendor_am_details' => 'required|max:2000',
            ]
        );

        $vendor = vendors::findOrFail($id);
        $vendor->update([
            'vendors' => $request->vendors,
            'vendor_am_details' => $request->vendor_am_details,
        ]);

        Cache::forget('vendors_list');
        session()->flash('success', 'Vendor updated successfully!');
        return redirect('/vendors');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $vendor = vendors::findOrFail($id);
        $vendor->delete();

        Cache::forget('vendors_list');
        session()->flash('delete', 'Vendor deleted successfully!');
        return redirect('/vendors');
    }
}
