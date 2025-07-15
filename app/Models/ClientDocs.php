<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClientDocs extends Model
{
    protected $fillable = [
        'client_id',
        'project_name',
        'document_name',
        'description_1',
        'description_2',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
