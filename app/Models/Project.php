<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_code',
        'name',
        'description',
        'client_id',
        'category_id',
        'added_by',
        'start_date',
        'deadline',
        'status',
        'priority',
        'estimate_budget',
        'attachment',
        'additional_note',
    ];

    protected $casts = [
    'start_date' => 'date',
    'deadline' => 'date',
];


    public function employees()
    {
        return $this->belongsToMany(Employee::class, 'project_employee');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }


    public function category()
    {
        return $this->belongsTo(ProjectCategory::class, 'category_id');
    }


    public function addedBy()
    {
        return $this->belongsTo(Employee::class, 'added_by');
    }

    public function authorizedPersons()
    {
        return $this->hasMany(AuthorizedPersons::class);
    }
}
