<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskUpdate extends Model
{
    use HasFactory;


    protected $fillable = ['task_id', 'employee_id', 'update_text', 'type', 'is_solved'];

    public function markAsSolved()
    {
        $this->update(['is_solved' => true]);
    }


    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }
}
