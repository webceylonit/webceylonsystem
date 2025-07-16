<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectDocs extends Model
{
    protected $fillable = [
        'project_id',
        'document_name',
        'description',
        'added_by'
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function addedBy()
    {
        return $this->belongsTo(Employee::class, 'added_by');
    }
}
