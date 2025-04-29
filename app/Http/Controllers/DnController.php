<?php

namespace App\Http\Controllers;

use App\Models\Dn;
use App\Models\projects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DnController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dn = Dn::all();
        return view('dashboard.DN.index', compact('dn'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
      
        $projects=projects::all();
        return view('dashboard.DN.create',compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'dn_number' => 'nullable|string',
            'pr_number' => 'nullable|exists:projects,id',
            'dn_copy' => 'nullable|mimes:pdf,jpg,png,jpeg|max:2048',
            'status' => 'nullable|string',
        ]);
        
        if ($request->hasFile('dn_copy')) {
            
            $file = $request->file('dn_copy');
            
            $path = $file->store('uploads', ['disk' => 'public']);
            
            $validatedData['dn_copy'] = $path;
        }
    
        Dn::create($validatedData);
    
        return redirect()->route('dn.index');
    }
    

    /**
     * Display the specified resource.
     */
    public function show(Dn $dn)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request,$id)
    {
        //
        $dn=DN::find($id);
        $projects=projects::all();
        return view('dashboard.DN.edit',compact('projects','dn'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dn $dn)
    {
        //
        $validatedData = $request->validate([
            'dn_number' => 'nullable|string',
            'pr_number' => 'nullable|exists:projects,id',
            'dn_copy' => 'nullable|mimes:pdf,jpg,png,jpeg|max:2048',
            'status' => 'nullable|string',
        ]);
        if ($request->hasFile('dn_copy')) {
            $file = $request->file('dn_copy');
            $path = $file->store('uploads', ['disk' => 'public']);
            $validatedData['dn_copy'] = $path;
        }
        $old_dn_copy=$dn->dn_copy;
        if($old_dn_copy && isset($data['dn_copy'])){
            Storage::disk('public')->delete($old_dn_copy);
        }
    
        $dn->update($validatedData);
        session()->flash('edit', 'The section has been successfully modified');
        return redirect('/dn'); 
    
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
        $id=$request->id;
        Dn::find($id)->delete();
        session()->flash('delete', 'Deleted successfully');

        return redirect('/dn');

    }
}
