<?php

namespace App\Http\Controllers;

use App\Models\ppms;
use Illuminate\Http\Request;

class PpmsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ppms=ppms::all();
        return view('dashboard.PMs.index',compact('ppms'));
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
     // التحقق من صحة البيانات الواردة في الطلب
$validatedData = $request->validate([
    'name' => 'required|string|max:255',
    'email' => 'required|email|max:255',
    'phone' => 'required|string|max:15',
]);

// التحقق من وجود سجل بالاسم المطلوب مسبقًا
if (ppms::where('name', $validatedData['name'])->exists()) {
    session()->flash('Error', 'The name already exists');
    return redirect('/pm');  // إعادة التوجيه إلى الصفحة المناسبة مع رسالة خطأ
}

// إنشاء السجل الجديد في قاعدة البيانات
ppms::create($validatedData);

// إعداد رسالة النجاح وإعادة التوجيه
session()->flash('Add', 'Registration successful');
return redirect('/pm'); // إعادة التوجيه إلى صفحة السجلات
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

        $this->validate($request, [

            'name' => 'required|max:255|unique:ppms,name,'.$id,
            'email' => 'required',
            'phone' => 'required',
        ]
                  );

        $ppms = ppms::find($id);
        $ppms->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);

        session()->flash('success', 'Pm updated successfully!');
               return redirect('/pm');
         
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request )
    {
    $id=$request->id;
    ppms::find($id)->delete();
    session()->flash('delete', 'Deleted successfully');
        return redirect('/pm');
    }

}
