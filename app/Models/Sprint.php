<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sprint extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'name', 'start_date', 'end_date', 'status','board_order',];
    

    protected $casts = [
        'task_order' => 'array',   // <-- add this
        'board_order' => 'array',
        'start_date'  => 'date',
        'end_date'    => 'date',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function notes()
    {
        return $this->hasMany(SprintNote::class);
    }


    /**
     * Remove tokens from board_order that no longer exist.
     * Call this after hard deletes of tasks/notes (or periodically).
     */
    public function pruneBoardOrder(): void
    {
        $order = $this->board_order ?? [];

        if (empty($order)) return;

        $taskIds = $this->tasks()->pluck('id')->map(fn($i)=>(int)$i)->all();
        $noteIds = $this->notes()->pluck('id')->map(fn($i)=>(int)$i)->all();

        $order = array_values(array_filter($order, function ($tok) use ($taskIds, $noteIds) {
            if (str_starts_with($tok, 't:')) return in_array((int)substr($tok, 2), $taskIds, true);
            if (str_starts_with($tok, 'n:')) return in_array((int)substr($tok, 2), $noteIds, true);
            return false;
        }));

        $this->board_order = $order;
        $this->save();
    }
}

