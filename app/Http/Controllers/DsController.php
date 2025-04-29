<?php

namespace App\Http\Controllers;

use App\Models\ds;
use Illuminate\Http\Request;

class DsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ds=ds::all();
        return view('dashboard.ds.index',compact('ds'));
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
            'dsname' => 'required|string|max:255',
            'ds_contact' => 'nullable|string|max:1000', 
        ]);
    
        $exists = ds::where('dsname', $validatedData['dsname'])->exists();
    
        if ($exists) {
            session()->flash('Error', 'The dsname already exists');
            return redirect('ds');
        } else {
            ds::create([
                'dsname' => $validatedData['dsname'], 
                'ds_contact' => $validatedData['ds_contact'],
            ]);
    
            session()->flash('Add', 'dsname registration successful');
            return redirect('/ds');
        }
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

        $this->validate($request, [

            'dsname' => 'required|max:255|unique:ds,dsname,'.$id,
            'ds_contact' => 'nullable',
        ]
                  );
        $ds = ds::find($id);
        $ds->update([
            'dsname' => $request->dsname,
            'ds_contact' => $request->ds_contact,
        ]);
        session()->flash('edit', 'DS updated successfully!');
               return redirect('/ds');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request )
    {
   $id=$request->id;
   ds::find($id)->delete();
   session()->flash('delete', 'Deleted successfully');
        return redirect('/ds');
    }
}
