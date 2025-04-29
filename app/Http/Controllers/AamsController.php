<?php

namespace App\Http\Controllers;

use App\Models\aams;
use Illuminate\Http\Request;

class AamsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $aams=aams::all();
        return view('dashboard.AMs.index',compact('aams'));
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
        // التحقق من وجود الحقول المطلوبة في الطلب
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:15',
        ]);
    
        // التحقق إذا كان الاسم موجودًا مسبقًا
        $b_exists = aams::where('name', $validatedData['name'])->exists();
    
        if ($b_exists) {
            session()->flash('Error', 'The name already exists');
            return redirect('/am');
        } else {
            // إنشاء السجل الجديد
            aams::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'phone' => $validatedData['phone'],
            ]);
    
            session()->flash('Add', 'Registration successful');
            return redirect('/am');
        }
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
    
        // التحقق من صحة البيانات
        $this->validate($request, [
            'name' => 'required|max:255|unique:aams,name,' . $id, // التحقق من اسم القسم بناءً على الحقل "name"
            'email' => 'required|email|unique:aams,email,' . $id, // التحقق من البريد الإلكتروني
            'phone' => 'required|unique:aams,phone,' . $id, // التحقق من رقم الهاتف
        ]);
    
        // العثور على العنصر وتحديث
        $aams = aams::findOrFail($id); // نستخدم findOrFail للتأكد من وجود العنصر
        $aams->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
        ]);
    
        // رسالة تأكيد وإعادة توجيه
        session()->flash('edit', 'The section has been successfully modified');
        return redirect('/am'); // إعادة التوجيه إلى صفحة الأقسام
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request )
    {
$id=$request->id;

   aams::find($id)->delete();

   session()->flash('delete', 'Deleted successfully');

        return redirect('/am');
    }

}
