<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'start_date',  // Added start_date
        'deadline',
        'status',
        'priority',
        'attachment',  // Added attachment for file uploads
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


    
}
