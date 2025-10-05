<?php

namespace App\Http\Controllers;

use App\Models\Coc;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Cache;

class CocController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // استخدام Cache + Eager Loading للسرعة الفائقة
        $coc = Cache::remember('coc_list', 3600, function () {
            return Coc::with('project:id,name,pr_number')->latest()->get();
        });

        return view('dashboard.CoC.index', compact('coc'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    $projects=Project::all();
        return view('dashboard.CoC.create', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'coc_copy' => 'required|mimes:pdf,docx,doc,jpg,jpeg,png,gif|max:10240',
            'pr_number' => "required|exists:projects,id"
        ]);

        if($request->hasFile('coc_copy')){
            $file = $request->file('coc_copy');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('../storge'), $filename);
            $validatedData['coc_copy'] = $filename;
        }

        Coc::create($validatedData);

        // مسح الـ Cache بعد الإضافة
        Cache::forget('coc_list');

        session()->flash('Add', 'Certificate of Compliance added successfully');
        return redirect('/coc');

    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $coc = Coc::with('project:id,pr_number,name')->findOrFail($id);
        return view('dashboard.CoC.show', compact('coc'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
    $projects = Project::all();
        $coc=Coc::find($id);

        return view('dashboard.CoC.edit', compact('coc', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $coc = Coc::findOrFail($id);

        $validatedData = $request->validate([
            'coc_copy' => 'nullable|mimes:pdf,docx,doc,jpg,jpeg,png,gif|max:10240',
            'pr_number' => "required|exists:projects,id"
        ]);

        if($request->hasFile('coc_copy')){
            // حذف الملف القديم
            $oldFile = public_path('../storge/' . $coc->coc_copy);
            if(file_exists($oldFile)){
                unlink($oldFile);
            }

            // رفع الملف الجديد
            $file = $request->file('coc_copy');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('../storge'), $filename);
            $validatedData['coc_copy'] = $filename;
        }

        $coc->update($validatedData);

        // مسح الـ Cache بعد التعديل
        Cache::forget('coc_list');

        session()->flash('edit', 'Certificate of Compliance updated successfully');
        return redirect('/coc');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id=$request->id;
        $coc=Coc::find($id);

        // حذف الملف من مجلد storge
        $filePath = public_path('../storge/' . $coc->coc_copy);
        if(file_exists($filePath)){
            unlink($filePath);
        }

        $coc->delete();

        // مسح الـ Cache بعد الحذف
        Cache::forget('coc_list');

        session()->flash('delete', 'Deleted successfully');

        return redirect('/coc');
    }
}
