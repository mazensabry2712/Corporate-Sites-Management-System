<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ppos extends Model
{
    use HasFactory;
    protected $fillable = [
        'pr_number',
        'category',
        'supplier_name',
        'po_number',
        'value',
        'date',
        'status',
        'updates',
        'notes',
    ];
    public function project()
    {
        return $this->belongsTo(Projects::class, 'pr_number');
    }

   
    public function pepo()
    {
        return $this->belongsTo(Pepo::class, 'category');
    }

    
    public function supplier()
    {
        return $this->belongsTo(Ds::class, 'supplier_name');
    }
}
