<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
    'name',
    'designation',
    'email',
    'client_contact',
    'company',
    'phone',
    'company_email',
    'address',
    'notes',
    'status',
    'added_by',
];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }

    public function addedBy()
    {
        return $this->belongsTo(Employee::class, 'added_by');
    }
}
