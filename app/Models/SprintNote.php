<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SprintNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'sprint_id',
        'title',
        'body',
        'role',      // PM, Dev, QA, Design, Ops, Note
        'color',     // e.g. #ffeb3b or a class name
        'note_date',
        'created_by' // FK -> employees.id (adjust to your auth if needed)
    ];

    protected $casts = [
        'note_date' => 'date',
    ];

    /* Relationships */
    public function sprint()
    {
        return $this->belongsTo(Sprint::class);
    }

    public function creator()
    {
        return $this->belongsTo(Employee::class, 'created_by');
    }
}
