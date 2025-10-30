<?php

namespace App\Http\Controllers;

use App\Models\Sprint;
use App\Models\SprintNote;
use App\Models\Task;
use Illuminate\Http\Request;

class SprintNoteController extends Controller
{
    /**
     * Create a note and insert it at a specific position in board_order.
     * Expects optional 'insert_after' token: "t:12" | "n:3" | "__END__".
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'sprint_id'    => ['required','exists:sprints,id'],
            'title'        => ['nullable','string','max:255'],
            'body'         => ['nullable','string'],
            'role'         => ['nullable','string','max:20'],
            'color'        => ['nullable','string','max:20'],
            'note_date'    => ['nullable','date'],
            'insert_after' => ['nullable','string'],
        ]);

        $sprint = Sprint::findOrFail($data['sprint_id']);

        $note = SprintNote::create($data + [
            'created_by' => auth()->user()?->employee_id, // adjust to your auth
        ]);

        // Build clean order
        $order = $sprint->board_order ?? [];

        $taskIds = Task::where('sprint_id',$sprint->id)->pluck('id')->map(fn($i)=>(int)$i)->all();
        $noteIds = SprintNote::where('sprint_id',$sprint->id)->pluck('id')->map(fn($i)=>(int)$i)->all();

        // prune stale tokens
        $order = array_values(array_filter($order, function ($tok) use ($taskIds, $noteIds) {
            if (str_starts_with($tok, 't:')) return in_array((int)substr($tok,2), $taskIds, true);
            if (str_starts_with($tok, 'n:')) return in_array((int)substr($tok,2), $noteIds, true);
            return false;
        }));

        $newToken = "n:{$note->id}";
        $anchor   = $data['insert_after'] ?? '__END__';

        if ($anchor === '__END__' || empty($order)) {
            $order[] = $newToken;
        } else {
            $idx = array_search($anchor, $order, true);
            if ($idx === false) {
                $order[] = $newToken; // anchor missing → append safely
            } else {
                array_splice($order, $idx + 1, 0, [$newToken]); // insert right after anchor
            }
        }

        $sprint->board_order = $order;
        $sprint->save();

        return back()->with('success','Note added.');
    }

    /**
     * Update note fields (title/body/color/role/date).
     */
    public function update(Request $request, SprintNote $note)
    {
        $data = $request->validate([
            'title'     => ['nullable','string','max:255'],
            'body'      => ['nullable','string'],
            'role'      => ['nullable','string','max:20'],
            'color'     => ['nullable','string','max:20'],
            'note_date' => ['nullable','date'],
        ]);

        $note->update($data);

        return back()->with('success','Note updated.');
    }

    /**
     * Delete a note and remove its token from board_order.
     */
    public function destroy(SprintNote $note)
    {
        $sprint = $note->sprint;
        $token  = "n:{$note->id}";
        $note->delete();

        if ($sprint) {
            $order = collect($sprint->board_order ?? [])->reject(fn($t) => $t === $token)->values()->all();
            $sprint->board_order = $order;
            $sprint->save();
        }

        return back()->with('success','Note deleted.');
    }
}
