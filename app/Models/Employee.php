<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Employee extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'start_date',
        'status',
        'role_id',
        'nic',
        'mobile_number',
        'mobile_number_2',
        'gender',
        'dob',
        'employee_number',
        'rm_id',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function rm()
    {
        return $this->belongsTo(Employee::class);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_employee');
    }

    public function tasks()
    {
        return $this->hasMany(Task::class, 'assigned_to');
    }


}
