<?php

namespace App\Http\Controllers;

use App\Models\Cust;
use Exception;
use Illuminate\Http\Request;
class CustController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $custs=cust::all() ;
        return view("dashboard.customer.index",compact("custs"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.customer.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'abb' => 'nullable|string|max:255'??null,
            'tybe' => 'nullable|in:GOV,PRIVATE'??null,
            'logo' => 'nullable|file|mimes:jpeg,jpg,png,gif,webp|max:2048',
            'customercontactname' => 'nullable|string|max:255'??null,
            'customercontactposition' => 'nullable|string|max:255'??null,
            'email' => 'nullable|email|max:255'??null,
            'phone' => 'nullable|string|max:15'??null,
        ], [
            'name.required' => 'Customer name is required',
            'email.email' => 'Please enter a valid email address',
            'logo.mimes' => 'Logo must be an image file (jpeg, jpg, png, gif, webp)',
            'logo.max' => 'Logo file size cannot exceed 2MB',
        ]);

        $data = $request->except(['logo']);

      if($request->file('logo')){
        $file = $request->file('logo');
        $fileName = time() . '_' . $file->getClientOriginalName();

        // حفظ في مجلد storge الأصلي
        $destinationPath = base_path('storge');
        $file->move($destinationPath, $fileName);

        // نسخ إلى مجلد public للعرض
        $publicPath = public_path('storge');
        copy(base_path('storge/' . $fileName), $publicPath . '/' . $fileName);

        $data['logo'] = 'storge/' . $fileName;
        }

// إذا كانت البيانات سليمة، يتم حفظها
Cust::create($data);

// إضافة رسالة النجاح
session()->flash('Add', 'Customer registration successful');

//return back(); // أو
return redirect('/customer'); //حسب الحاجة


    }

    /**
     * Display the specified resource.
     */
    public function show(Cust $customer)
    {
        // Get customer order/position number
        $customers = Cust::orderBy('id')->get();
        $loop_index = $customers->search(function($item) use ($customer) {
            return $item->id === $customer->id;
        }) + 1;

        return view('dashboard.customer.show', compact('customer', 'loop_index'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cust $customer)
    {
        return view('dashboard.customer.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */

     public function update(Request $request, Cust $customer)
     {
         $validated = $request->validate([
            'name' => 'required|string|max:255',
            'abb' => 'nullable|string|max:255',
            'tybe' => 'nullable|in:GOV,PRIVATE',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'customercontactname' => 'nullable|string|max:255',
            'customercontactposition' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:15',
         ], [
            'name.required' => 'Customer name is required',
            'email.email' => 'Please enter a valid email address',
            'logo.image' => 'Logo must be an image file',
            'logo.mimes' => 'Logo must be an image file (jpeg, jpg, png, gif, webp)',
            'logo.max' => 'Logo file size cannot exceed 2MB',
         ]);

         $old_logo = $customer->logo;
         $data = $request->except(['logo']);

         if($request->file('logo')){
             // حذف الصورة القديمة إذا كانت موجودة من كلا المكانين
             if($old_logo && file_exists(base_path($old_logo))) {
                 unlink(base_path($old_logo));
             }
             if($old_logo && file_exists(public_path($old_logo))) {
                 unlink(public_path($old_logo));
             }

             $file = $request->file('logo');
             $fileName = time() . '_' . $file->getClientOriginalName();

             // حفظ في مجلد storge الأصلي
             $destinationPath = base_path('storge');
             $file->move($destinationPath, $fileName);

             // نسخ إلى مجلد public للعرض
             $publicPath = public_path('storge');
             copy(base_path('storge/' . $fileName), $publicPath . '/' . $fileName);

             $data['logo'] = 'storge/' . $fileName;
         }

         $customer->update($data);
         session()->flash('Add', 'Registration successful.');
         return redirect('/customer');
     }














    // public function update(Request $request)
    // {



    //     $id = $request->id;

    //     // التحقق من صحة البيانات
    //     $this->validate($request, [
    //         'name' => 'required|string|max:255'.$id,
    //         'abb' => 'nullable|string|max:255',
    //         'tybe' => 'nullable|in:GOV,PRIVATE',
    //          'logo' => 'nullable|file|mimetypes:image/jpeg,image/png,image/gif,image/webp,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document,image/svg+xml|max:2048',
    //         'customercontactname' => 'nullable|string|max:255',
    //         'customercontactposition' => 'nullable|string|max:255',
    //         'email' => 'nullable|email|max:255',
    //         'phone' => 'nullable|string|max:15',
    //     ]);

    //     // العثور على العنصر وتحديث
    //     $aams = Cust::findOrFail($id); // نستخدم findOrFail للتأكد من وجود العنصر
    //     $aams->update([
    //         'name' => $request->name,
    //         'abb' => $request->abb,
    //         'tybe' => $request->tybe,
    //         'logo' => $request->logo,
    //         'customercontactname' => $request->customercontactname,
    //         'customercontactposition' => $request->customercontactposition,
    //         'email' => $request->email,
    //         'phone' => $request->phone,
    //     ]);

    //     // رسالة تأكيد وإعادة توجيه
    //     session()->flash('edit', 'The section has been successfully modified');
    //     return redirect('/customer'); // إعادة التوجيه إلى صفحة الأقسام











    // }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cust $customer)
    {
        // حذف الصورة إذا كانت موجودة من كلا المكانين
        if($customer->logo) {
            if(file_exists(base_path($customer->logo))) {
                unlink(base_path($customer->logo));
            }
            if(file_exists(public_path($customer->logo))) {
                unlink(public_path($customer->logo));
            }
        }

        $customer->delete();
        session()->flash('delete', 'Deleted successfully');
        return redirect('/customer');
    }
}
