<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\ds;
use App\Models\aams;
use App\Models\Cust;
use App\Models\ppms;
use App\Models\vendors;
use App\Models\projects;
use Illuminate\Http\Request;


class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects=projects::all();
       return view('dashboard.projects.index',compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $ds=ds::all();
        $custs=Cust::all();
        $aams=aams::all();
        $ppms=ppms::all();
        $vendors=vendors::all();
        return view('dashboard.projects.addpro',compact('ds','custs','aams','ppms', 'vendors'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pr_number'              => 'required|unique:projects,pr_number',
            'name'                   => 'required|string|max:255',
            'technologies'           => 'nullable|string',
            'vendors_id'             => 'nullable|exists:vendors,id',
            'ds_id'                  => 'nullable|exists:ds,id',
            'aams_id'                => 'nullable|exists:aams,id',
            'ppms_id'                => 'nullable|exists:ppms,id',
            'value'                  => 'nullable|numeric',
            'customer_name'          => 'nullable|string|max:255',
            'customer_po'            => 'nullable|string',

            'customer_contact_details'=> 'nullable|string',
            'customer_po_date'       => 'nullable|date',
            'customer_po_duration'   => 'nullable|integer',
            'customer_po_deadline'   => 'nullable|date',
            'description'            => 'nullable|string',
            'po_attachment'          => 'nullable|file|mimes:jpg,jpeg,png',
            'epo_attachment'         => 'nullable|file|mimes:jpg,jpeg,png'
        ]);

        $data = $validated;
        $data = $request->except(['po_attachment','epo_attachment']);
        if($request->file('po_attachment')){
            $file = $request->file('po_attachment');
            $path = $file->store('uploads',[
                'disk' => 'public'
            ]);

            $data['po_attachment'] = $path;
        }
      if($request->file('epo_attachment')){
        $file = $request->file('epo_attachment');
            $path = $file->store('uploads',[
                'disk' => 'public'
            ]);
            $data['epo_attachment'] = $path;
        }

     $project = projects::create(  $data);
        session()->flash('Add', 'Registration successful.');
        return redirect('/project');
   }





    /**
     * Display the specified resource.
     */
    public function show(Request $request ,projects $projects)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        try{
            $project = projects::findOrFail($id);
        }catch(Exception $e){
            return redirect('/project')->with('error', 'Record not found!');
        }

        $ds=ds::all();
        $custs=Cust::all();
        $aams=aams::all();
        $ppms=ppms::all();
        $vendors=vendors::all();
       return view('dashboard.projects.edit',compact('project','ds','custs','aams','ppms', 'vendors'));


    }

    /**
     * Update the specified resource in storage.
     */


    public function update(Request $request, $id)
{
    $project = projects::findOrFail($id);
    $validated = $request->validate([
        'pr_number'              => 'required|unique:projects,pr_number,'.$project->id,
        'name'                   => 'required|string|max:255',
        'technologies'           => 'nullable|string',
        'vendors_id'             => 'nullable|exists:vendors,id',
        'ds_id'                  => 'nullable|exists:ds,id',
        'aams_id'                => 'nullable|exists:aams,id',
        'ppms_id'                => 'nullable|exists:ppms,id',
        'value'                  => 'nullable|numeric',
        'customer_name'          => 'nullable|string|max:255',
        'customer_po'            => 'nullable|string',
        'ac_manager'             => 'nullable|string|max:255',
        'project_manager'        => 'nullable|string|max:255',
        'customer_contact_details'=> 'nullable|string',
        'customer_po_date'       => 'nullable|date',
        'customer_po_duration'   => 'required|integer',
        'customer_po_deadline'   => 'nullable|date',
        'description'            => 'nullable|string',
        'po_attachment'          => 'nullable|file|mimes:jpg,jpeg,png',
        'epo_attachment'         => 'nullable|file|mimes:jpg,jpeg,png'
    ]);

    $data = $validated;


    $project = projects::find($id);

       $old_po_attachment = $project->po_attachment;
      $old_epo_attachment = $project->epo_attachment;
    $data = $request->except(['po_attachment','epo_attachment']);


    if($request->file('po_attachment')){
        $file = $request->file('po_attachment');
        $path = $file->store('uploads',[
            'disk' => 'public'
        ]);

        $data['po_attachment'] = $path;
    }

  if($request->file('epo_attachment')){
    $file = $request->file('epo_attachment');
        $path = $file->store('uploads',[
            'disk' => 'public'
        ]);
        $data['epo_attachment'] = $path;
    }

    $project->update($data);

    session()->flash('Add', 'Registration successful.');
    return redirect('/project');
}



    public function destroy(Request $request)
    {
        $id=$request->id;
        projects::find($id)->delete();
        session()->flash('delete', 'Deleted successfully!');
             return redirect('/project');
    }

}
