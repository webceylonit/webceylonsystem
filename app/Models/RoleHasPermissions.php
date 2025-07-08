<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleHasPermissions extends Model
{
    use HasFactory;

    protected $fillable = [
        'role_id','permission_id',
    ];

    public function permissions() {
        return $this->belongsTo(Permissions::class, 'permission_id');
    }
}
