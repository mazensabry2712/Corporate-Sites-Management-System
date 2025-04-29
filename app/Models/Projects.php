<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class projects extends Model
{
    protected $fillable = [
        'pr_number', 'name', 'technologies', 'vendors_id', 'ds_id', 'aams_id', 'ppms_id',
        'value', 'customer_name', 'customer_po', 'ac_manager', 'project_manager',
        'customer_contact_details', 'po_attachment', 'epo_attachment',
        'customer_po_date', 'customer_po_duration', 'customer_po_deadline',
        'description', 'Created_by' ,'vendors_id',
        'cust_id',

    ];

    public function vendor()
    {
        return $this->belongsTo(vendors::class, 'vendors_id');
    }

    public function cust()
    {
        return $this->belongsTo(Cust::class, 'cust_id')
            ->withDefault(['name' => 'nothing']);
    }
    public function ds()
    {
        return $this->belongsTo(Ds::class, 'ds_id')
                ->withDefault(['name' => 'nothing']);

    }

    public function aams()
    {
        return $this->belongsTo(aams::class, 'aams_id')
        ->withDefault(['name' => 'nothing']);

    }

    public function ppms()
    {
        return $this->belongsTo(ppms::class, 'ppms_id')
        ->withDefault(['name' => 'nothing']);

    }


}
