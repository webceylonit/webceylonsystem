@extends('AdminDashboard.master')

@section('title', 'Kanban Board for Project: ' . $project->name)

@section('content')
<div class="container-fluid pt-2">
  <div class="page-title">
    <div class="row">
      <div class="col-6">
        <h4>Kanban Board for {{ $project->name }}</h4>
      </div>
      <div class="col-6 text-end">
        <a href="{{ route('projects.index') }}" class="btn btn-secondary">← Back to Projects</a>
      </div>
    </div>
  </div>
</div>

<!-- Kanban Board -->
<div class="container-fluid">
  <div class="row d-flex justify-content-center">
    @foreach (['Pending', 'In Progress', 'Done'] as $status)
      <div class="col-md-4">
        <h5 class="text-center">{{ $status }}</h5>
        <div class="kanban-column bg-light p-3 rounded" data-status="{{ $status }}">
          @foreach ($tasks->where('status', $status) as $task)
            <div class="kanban-item card mb-2 p-3" draggable="true" id="task-{{ $task->id }}">
              <p class="text-uppercase fw-bold text-{{ $task->priority == 'High' ? 'danger' : ($task->priority == 'Medium' ? 'warning' : 'success') }}">{{ $task->priority }} Priority</p>
              <h6 class="fw-bold">{{ $task->name }}</h6>
              <p><small>Start: {{ $task->start_date }} | End: {{ $task->due_date }}</small></p>
              <p><small>Assigned to: {{ $task->assignedTo->name }}</small></p>
            </div>
          @endforeach
        </div>
      </div>
    @endforeach
  </div>
</div>

<!-- Kanban Drag and Drop Script with AJAX -->
<script>
  document.addEventListener("DOMContentLoaded", function() {
    let items = document.querySelectorAll(".kanban-item");
    let columns = document.querySelectorAll(".kanban-column");

    items.forEach(item => {
      item.addEventListener("dragstart", function(e) {
        e.dataTransfer.setData("text", e.target.id);
      });

      item.addEventListener("dragover", function(e) {
        e.preventDefault();
      });

      item.addEventListener("drop", function(e) {
        e.preventDefault();
        let draggedTaskId = e.dataTransfer.getData("text").replace("task-", "");
        let targetTaskId = e.target.id.replace("task-", "");

        let draggedTaskElement = document.getElementById("task-" + draggedTaskId);
        let targetTaskElement = document.getElementById("task-" + targetTaskId);
        let newStatus = targetTaskElement.closest(".kanban-column").getAttribute("data-status");

        targetTaskElement.parentNode.insertBefore(draggedTaskElement, targetTaskElement.nextSibling);

        // AJAX request to update status
        fetch("{{ route('kanban.updateTaskStatus') }}", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
          },
          body: JSON.stringify({ task_id: draggedTaskId, status: newStatus })
        }).then(response => response.json()).then(data => {
          if (!data.success) {
            alert("Error updating task status.");
          }
        });
      });
    });

    columns.forEach(column => {
      column.addEventListener("dragover", function(e) {
        e.preventDefault();
      });

      column.addEventListener("drop", function(e) {
        e.preventDefault();
        let taskId = e.dataTransfer.getData("text").replace("task-", "");
        let newStatus = column.getAttribute("data-status");

        let taskElement = document.getElementById("task-" + taskId);
        column.appendChild(taskElement);

        // AJAX request to update status
        fetch("{{ route('kanban.updateTaskStatus') }}", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
          },
          body: JSON.stringify({ task_id: taskId, status: newStatus })
        }).then(response => response.json()).then(data => {
          if (!data.success) {
            alert("Error updating task status.");
          }
        });
      });
    });
  });
</script>
@endsection
