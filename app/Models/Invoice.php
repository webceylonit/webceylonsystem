<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_number',
        'project_id',
        'type',                  // add type: commercial or tax
        'client_vat_no',         // new
        'discount_percentage',   // new
        'discount_amount',       // new
        'after_discount_total',  // new
        'sscl',                  // already exists
        'after_sscl_total',      // new
        'vat',                   // already exists
        'total_amount',          // rename to final total for clarity (optional)
        'final_total',           // if you keep both, include this (optional)
        'added_by',
    ];

    // Relationships
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }

    public function addedBy()
    {
        return $this->belongsTo(Employee::class, 'added_by');
    }
}
