<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['sprint_id', 'project_id', 'assigned_to', 'name', 'description', 'status', 'priority', 'dependent_task_id', 'start_date', 'due_date'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function sprint()
    {
        return $this->belongsTo(Sprint::class);
    }

    // Rename this method from 'employee()' to 'assignedTo()'
    public function assignedTo()
    {
        return $this->belongsTo(Employee::class, 'assigned_to');
    }

    public function dependentTask()
    {
        return $this->belongsTo(Task::class, 'dependent_task_id');
    }

    public function updates()
    {
        return $this->hasMany(TaskUpdate::class);
    }

}
