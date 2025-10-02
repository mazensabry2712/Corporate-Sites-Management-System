<?php

namespace App\Http\Controllers;

use App\Models\aams;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class AamsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $aams = Cache::remember('aams_list', 3600, function () {
            return aams::select('id', 'name', 'email', 'phone')->get();
        });

        return view('dashboard.AMs.index', compact('aams'));
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
            'name' => 'required|string|max:255|unique:aams,name',
            'email' => 'required|email|max:255|unique:aams,email',
            'phone' => 'required|string|max:15',
        ]);

        aams::create($validatedData);

        Cache::forget('aams_list');

        return redirect()->route('am.index')
            ->with('Add', 'AM added successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(aams $aams)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(aams $aams)
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
            'name' => 'required|string|max:255|unique:aams,name,' . $id,
            'email' => 'required|email|max:255|unique:aams,email,' . $id,
            'phone' => 'required|string|max:15',
        ]);

        $aams = aams::findOrFail($id);
        $aams->update($validatedData);

        Cache::forget('aams_list');

        return redirect()->route('am.index')
            ->with('edit', 'AM updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;

        $aams = aams::findOrFail($id);
        $aams->delete();

        Cache::forget('aams_list');

        return redirect()->route('am.index')
            ->with('delete', 'AM deleted successfully');
    }
}
