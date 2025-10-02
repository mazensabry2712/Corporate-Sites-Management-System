<?php

namespace App\Http\Controllers;

use App\Models\ppms;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PpmsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ppms = Cache::remember('ppms_list', 3600, function () {
            return ppms::select('id', 'name', 'email', 'phone')->get();
        });

        return view('dashboard.PMs.index', compact('ppms'));
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
            'name' => 'required|string|max:255|unique:ppms,name',
            'email' => 'required|email|max:255|unique:ppms,email',
            'phone' => 'required|string|max:15',
        ]);

        ppms::create($validatedData);

        Cache::forget('ppms_list');

        return redirect()->route('pm.index')
            ->with('Add', 'PM added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(ppms $ppms)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ppms $ppms)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $id = $request->id;

        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:ppms,name,' . $id,
            'email' => 'required|email|max:255|unique:ppms,email,' . $id,
            'phone' => 'required|string|max:15',
        ]);

        $ppms = ppms::findOrFail($id);
        $ppms->update($validatedData);

        Cache::forget('ppms_list');

        return redirect()->route('pm.index')
            ->with('edit', 'PM updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;

        $ppms = ppms::findOrFail($id);
        $ppms->delete();

        Cache::forget('ppms_list');

        return redirect()->route('pm.index')
            ->with('delete', 'PM deleted successfully');
    }
}
