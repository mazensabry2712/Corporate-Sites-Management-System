<?php

namespace App\Http\Controllers;

use App\Models\ds;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class DsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ds = Cache::remember('ds_list', 3600, function () {
            return ds::select('id', 'dsname', 'ds_contact', 'created_at', 'updated_at')->get();
        });

        return view('dashboard.ds.index', compact('ds'));
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
            'dsname' => 'required|string|max:255|unique:ds,dsname',
            'ds_contact' => 'required|string|max:2000',
        ]);

        ds::create([
            'dsname' => $validatedData['dsname'],
            'ds_contact' => $validatedData['ds_contact'],
        ]);

        Cache::forget('ds_list');
        session()->flash('Add', 'Delivery Specialist registration successful');
        return redirect('/ds');
    }

    /**
     * Display the specified resource.
     */
    public function show(ds $ds)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ds $ds)
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
                'dsname' => 'required|max:255|unique:ds,dsname,' . $id,
                'ds_contact' => 'required|max:2000',
            ]
        );

        $ds = ds::findOrFail($id);
        $ds->update([
            'dsname' => $request->dsname,
            'ds_contact' => $request->ds_contact,
        ]);

        Cache::forget('ds_list');
        session()->flash('edit', 'Delivery Specialist updated successfully!');
        return redirect('/ds');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $ds = ds::findOrFail($id);
        $ds->delete();

        Cache::forget('ds_list');
        session()->flash('delete', 'Delivery Specialist deleted successfully');
        return redirect('/ds');
    }
}
