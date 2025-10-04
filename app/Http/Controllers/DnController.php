<?php

namespace App\Http\Controllers;

use App\Models\Dn;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DnController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dn = Dn::with('project')->latest()->get();
        return view('dashboard.DN.index', compact('dn'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    $projects = Project::orderBy('pr_number')->get();
        return view('dashboard.DN.create', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Check if DN number already exists manually
        $existingDn = Dn::where('dn_number', $request->dn_number)->first();
        if ($existingDn) {
            return back()->withErrors(['dn_number' => 'This DN Number already exists!'])->withInput();
        }

        $validatedData = $request->validate([
            'dn_number' => 'required|string|max:255',
            'pr_number' => 'required|exists:projects,id',
            'dn_copy' => 'nullable|mimes:pdf,jpg,png,jpeg|max:2048',
            'status' => 'required|string|max:500',
        ], [
            'dn_number.required' => 'DN Number is required',
            'pr_number.required' => 'PR Number is required',
            'pr_number.exists' => 'Selected PR Number does not exist',
            'dn_copy.mimes' => 'File must be PDF, JPG, PNG, or JPEG format',
            'dn_copy.max' => 'File size must not exceed 2MB',
            'status.required' => 'Status is required',
        ]);

        if ($request->hasFile('dn_copy')) {
            $file = $request->file('dn_copy');
            $fileName = time() . '_' . $file->getClientOriginalName();

            // حفظ في مجلد storge الأصلي
            $destinationPath = base_path('storge');
            $file->move($destinationPath, $fileName);

            // نسخ إلى مجلد public للعرض
            $publicPath = public_path('storge');
            copy(base_path('storge/' . $fileName), $publicPath . '/' . $fileName);

            $validatedData['dn_copy'] = 'storge/' . $fileName;
        }

        Dn::create($validatedData);

        return redirect()->route('dn.index');
    }


    /**
     * Display the specified resource.
     */
    public function show(Dn $dn)
    {
        return view('dashboard.DN.show', compact('dn'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $dn = Dn::findOrFail($id);
    $projects = Project::orderBy('pr_number')->get();
        return view('dashboard.DN.edit', compact('projects', 'dn'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dn $dn)
    {
        // Check if DN number already exists (excluding current record)
        $existingDn = Dn::where('dn_number', $request->dn_number)
                        ->where('id', '!=', $dn->id)
                        ->first();
        if ($existingDn) {
            return back()->withErrors(['dn_number' => 'This DN Number already exists!'])->withInput();
        }

        $validatedData = $request->validate([
            'dn_number' => 'required|string|max:255',
            'pr_number' => 'required|exists:projects,id',
            'dn_copy' => 'nullable|mimes:pdf,jpg,png,jpeg|max:2048',
            'status' => 'required|string|max:500',
        ], [
            'dn_number.required' => 'DN Number is required',
            'pr_number.required' => 'PR Number is required',
            'pr_number.exists' => 'Selected PR Number does not exist',
            'dn_copy.mimes' => 'File must be PDF, JPG, PNG, or JPEG format',
            'dn_copy.max' => 'File size must not exceed 2MB',
            'status.required' => 'Status is required',
        ]);

        if ($request->hasFile('dn_copy')) {
            // Delete old file if exists from both locations
            $old_dn_copy = $dn->dn_copy;
            if($old_dn_copy && file_exists(base_path($old_dn_copy))) {
                unlink(base_path($old_dn_copy));
            }
            if($old_dn_copy && file_exists(public_path($old_dn_copy))) {
                unlink(public_path($old_dn_copy));
            }

            $file = $request->file('dn_copy');
            $fileName = time() . '_' . $file->getClientOriginalName();

            // حفظ في مجلد storge الأصلي
            $destinationPath = base_path('storge');
            $file->move($destinationPath, $fileName);

            // نسخ إلى مجلد public للعرض
            $publicPath = public_path('storge');
            copy(base_path('storge/' . $fileName), $publicPath . '/' . $fileName);

            $validatedData['dn_copy'] = 'storge/' . $fileName;
        }

        $dn->update($validatedData);

        return redirect()->route('dn.index');
    }    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        $dn = Dn::find($id);

        // Delete associated file if exists from both locations
        if ($dn && $dn->dn_copy) {
            if(file_exists(base_path($dn->dn_copy))) {
                unlink(base_path($dn->dn_copy));
            }
            if(file_exists(public_path($dn->dn_copy))) {
                unlink(public_path($dn->dn_copy));
            }
        }

        $dn->delete();

        session()->flash('delete', 'Delivery Note has been deleted successfully!');
        return redirect()->route('dn.index');
    }
}
