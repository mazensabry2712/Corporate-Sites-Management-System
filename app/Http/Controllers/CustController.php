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
        ]);

         $b_exists = Cust::where('name', $validatedData['name'])->exists();

        $data = $request->except(['logo']);

      if($request->file('logo')){
        $file = $request->file('logo');
            $path = $file->store('uploads',[
                'disk' => 'public'
            ]);
            $data['logo'] = $path;
        }


if ($b_exists) {
    session()->flash('Error', 'The name already exists');
    return redirect('/customer');
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
    public function show(Cust $cust)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        try{
            $cust = Cust::findOrFail($id);
        }catch(Exception $e){
            return redirect('/customer')->with('error', 'Record not found!');
        }



       return view('dashboard.customer.edit',compact('cust'));
    }

    /**
     * Update the specified resource in storage.
     */

     public function update(Request $request, $id)
     {
         $cust = Cust::findOrFail($id);
         $validated = $request->validate([
                     'name' => 'required|string|max:255'.$cust->id,
            'abb' => 'nullable|string|max:255',
            'tybe' => 'nullable|in:GOV,PRIVATE',
             'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'customercontactname' => 'nullable|string|max:255',
            'customercontactposition' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:15',
         ]);

         $data = $validated;


         $cust = Cust::find($id);

            $old_logo = $cust->logo;
         $data = $request->except(['logo']);


         if($request->file('logo')){
             $file = $request->file('logo');
             $path = $file->store('uploads',[
                 'disk' => 'public'
             ]);

             $data['logo'] = $path;
         }

         $cust->update($data);
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
    public function destroy(Request $request)
    {
        $id=$request->id;
        Cust::find($id)->delete();
        session()->flash('delete', 'Deleted successfully');
             return redirect('/customer');
    }
}
