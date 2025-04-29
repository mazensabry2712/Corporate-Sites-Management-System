<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dn extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $fillable = [
        'dn_number',
        'pr_number',
        'dn_copy',
        'status',
    ];

public function project()
{
    return $this->belongsTo(projects::class, 'pr_number');
}
}