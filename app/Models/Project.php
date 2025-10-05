<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'pr_number', 'name', 'technologies', 'vendors_id', 'ds_id', 'aams_id', 'ppms_id',
        'value', 'customer_po', 'customer_contact_details', 'po_attachment', 'epo_attachment',
        'customer_po_date', 'customer_po_duration', 'customer_po_deadline',
        'description', 'Created_by', 'cust_id',
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

    public function statuses()
    {
        return $this->hasMany(Pstatus::class, 'pr_number', 'id');
    }

    public function latestStatus()
    {
        return $this->hasOne(Pstatus::class, 'pr_number', 'id')->latestOfMany();
    }

    public function tasks()
    {
        return $this->hasMany(Ptasks::class, 'pr_number', 'id');
    }

    public function milestones()
    {
        return $this->hasMany(Milestones::class, 'pr_number', 'id');
    }

    public function invoices()
    {
        return $this->hasMany(invoices::class, 'pr_number', 'id');
    }

    public function risks()
    {
        return $this->hasMany(Risks::class, 'pr_number', 'id');
    }

    // Many-to-many relationships for multiple assignments
    public function customers()
    {
        return $this->belongsToMany(Cust::class, 'project_customers', 'project_id', 'customer_id')
                    ->withPivot('is_primary', 'role', 'notes')
                    ->withTimestamps();
    }

    public function vendors()
    {
        return $this->belongsToMany(vendors::class, 'project_vendors', 'project_id', 'vendor_id')
                    ->withPivot('is_primary', 'service_type', 'contract_value', 'start_date', 'end_date', 'notes')
                    ->withTimestamps();
    }

    public function deliverySpecialists()
    {
        return $this->belongsToMany(Ds::class, 'project_delivery_specialists', 'project_id', 'ds_id')
                    ->withPivot('is_lead', 'responsibility', 'allocation_percentage', 'assigned_date', 'notes')
                    ->withTimestamps();
    }

    // Helper methods to get primary/lead relationships
    public function primaryCustomer()
    {
        return $this->customers()->wherePivot('is_primary', true)->first();
    }

    public function primaryVendor()
    {
        return $this->vendors()->wherePivot('is_primary', true)->first();
    }

    public function leadDeliverySpecialist()
    {
        return $this->deliverySpecialists()->wherePivot('is_lead', true)->first();
    }

}
