<?php

namespace App\Http\Controllers;

use App\Models\Coc;
use App\Models\projects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CocController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $coc = Coc::all();
        return view('dashboard.CoC.index', compact('coc'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $projects=projects::all();
        return view('dashboard.CoC.create', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            
            'coc_copy' => 'required|mimes:pdf,docx,doc',
            'pr_number'=>"required|exists:projects,id"
        ]);

        if($request->hasFile('coc_copy')){ 
            $file = $request->file('coc_copy');
            $path = $file->store('uploads',[
                'disk' => 'public'
            ]);
            // $path=Storage::putfile("uploads",$request->coc_copy);
            $validatedData['coc_copy'] = $path;
        }
        Coc::create($validatedData);
       
        session()->flash('Add', 'Registration successful');
            return redirect('/coc');

    }

    /**
     * Display the specified resource.
     */
    public function show(Coc $coc)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $projects = Projects::all();
        $coc=Coc::find($id);
        
        return view('dashboard.CoC.edit', compact('coc', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $coc=Coc::find($id);
        $path=$coc['coc_copy'];
        $validatedData = $request->validate([
            
            'coc_copy' => 'image|mimes:png,jpg,jpeg',
            'pr_number'=>"required|exists:projects,id"
        ]);

        if($request->hasFile('coc_copy')){ 
            // if ($coc->coc_copy && Storage::exists($coc->coc_copy)) {
            //     Storage::delete($coc->coc_copy);
            // }
            Storage::delete($path);
            $file = $request->file('coc_copy');
            $path = $file->store('uploads',[
                'disk' => 'public'
            ]);
            // $path=Storage::putfile("uploads",$request->coc_copy);
            $validatedData['coc_copy'] = $path;
        }
        

      
        $coc->update($validatedData);
   
        session()->flash('edit', 'The section has been successfully modified');
            return redirect('/coc');

        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        //
      
        $id=$request->id;
        $user=Coc::find($id);
        Storage::delete($user->coc_copy); 
        $user->delete();
        session()->flash('delete', 'Deleted successfully');

        return redirect('/coc');
    }
}
