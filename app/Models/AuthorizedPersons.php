<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuthorizedPersons extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'name',
        'designation',
        'contact',
        'email',
    ];

    // Relationship: An authorized person belongs to a project
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}