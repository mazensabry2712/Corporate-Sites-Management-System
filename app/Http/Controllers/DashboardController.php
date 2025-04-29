<?php

namespace App\Http\Controllers;

use App\Models\aams;
use App\Models\Coc;
use App\Models\Cust;
use App\Models\Dn;
use App\Models\ds;
use App\Models\invoices;
use App\Models\Milestones;
use App\Models\Pepo;
use App\Models\ppms;
use App\Models\Ppos;
use App\Models\projects;
use App\Models\Pstatus;
use App\Models\Ptasks;
use App\Models\Risks;
use App\Models\User;
use App\Models\vendors;
use Flowframe\Trend\Trend;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */



    public function index()
    {
        $userCount = User::count();
         $projectcount = projects::count();
         $custCount = Cust::count();
         $pmCount = ppms::count();
         $amCount = aams::count();
         $VendorsCount = vendors::count();
         $dsCount = ds::count();
         $invoiceCount = invoices::count();
         $dnCount = Dn::count();
         $cocCount = Coc::count();
         $posCount = Ppos::count();
         $statusCount = Pstatus::count();
         $tasksCount  = Ptasks::count();
         $epoCount  = Pepo::count();
         $reskCount  = Risks::count();
         $milestonesCount  = Milestones::count();

        return view("admin.dashboard",
        compact('projectcount',
        'tasksCount','milestonesCount'
        ,'reskCount',
        'epoCount','userCount',
        'statusCount','posCount','cocCount','dnCount','invoiceCount' ,
        'custCount', 'pmCount', 'amCount', 'VendorsCount', 'dsCount'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
