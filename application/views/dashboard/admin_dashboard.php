<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="<?= base_url('assets/js/jquery.min.js'); ?>"></script>

    <style>
        /* CSS for Modal Overlay */
        #taskModal {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            padding: 20px;
            border: 1px solid #ccc;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }
        /* Overlay background */
        #modalOverlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 900;
        }
    </style>
</head>
<body><a href="<?php echo site_url('auth/logout'); ?>" class="btn btn-danger">Logout</a>
    <h1>Admin Dashboard</h1>
    <button id="addTaskBtn">Add Task</button>
    <div id="taskList">
        <h2>Tasks</h2>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Priority</th>
                    <th>Due Date</th>
                    <th>Category</th>
                    <th>Assigned To</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tasks as $task): ?>

                    <tr data-task-id="<?= $task['id']; ?>">
                        <td><?=$task['title']; ?></td>
                        <td><?= $task['description']; ?></td>
                        <td><?= $task['priority']; ?></td>
                        <td><?= date('Y-m-d', strtotime($task['due_date'])); ?></td>
                        <td><?= $task['category']; ?></td>
                        <td><?= $task['assigned_to']; ?></td>
                        <td>
    <?php if (!empty($task['file_path'])): ?>
        <a href="<?= base_url($task['file_path']); ?>" target="_blank">Download File</a>
    <?php endif; ?>
</td>
                        <td>
                <!-- Edit Button -->
                <a href="<?php echo site_url('tasks/edit/' . $task['id']); ?>" class="btn btn-warning">Edit</a>
                <!-- Delete Button -->
                <form method="post" action="<?php echo site_url('tasks/delete/' . $task['id']); ?>" style="display:inline;">
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this task?');">Delete</button>
                </form>
            </td>                        
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

<!-- Modal Overlay Background -->
<div id="modalOverlay"></div>

<!-- Task Modal Form -->
<div id="taskModal">
    <form id="taskForm" enctype="multipart/form-data">
        <input type="hidden" name="task_id" id="task_id" value="">
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" required>
        <label for="description">Description:</label>
        <textarea name="description" id="description" required></textarea>
        <label for="priority">Priority:</label>
        <select name="priority" id="priority">
            <option value="High">High</option>
            <option value="Medium">Medium</option>
            <option value="Low">Low</option>
        </select>
        <label for="due_date">Due Date:</label>
        <input type="date" name="due_date" id="due_date" required>
        <label for="category">Category:</label>
        <input type="text" name="category" id="category" required>
        <label for="assigned_to">Assign To:</label>
        <input type="text" name="assigned_to" id="assigned_to" required>
        <label for="file">Attach File:</label>
        <input type="file" name="file" id="file" accept=".pdf, .docx, .jpg, .jpeg, .png">
        <button type="submit">Save Task</button>
        <button type="button" id="closeModal">Close</button>
    </form>
</div>

<script>
    $(document).ready(function() {
        // Open modal and overlay for adding/editing tasks
        $('#addTaskBtn').click(function() {
            $('#taskModal').css('display', 'block');
            $('#modalOverlay').css('display', 'block');
            $('#taskForm')[0].reset();
            $('#task_id').val('');
        });

        // Close modal and overlay
        $('#closeModal, #modalOverlay').click(function() {
            $('#taskModal').css('display', 'none');
            $('#modalOverlay').css('display', 'none');
        });

        // Handle form submission
        $('#taskForm').submit(function(e) {
    e.preventDefault();
    var formData = new FormData(this); // Create FormData object with form data

    $.ajax({
        url: '<?= site_url('tasks/save'); ?>',
        type: 'POST',
        data: formData,
        contentType: false, // Required for FormData
        processData: false, // Required for FormData
        success: function(response) {
            console.log('AJAX request successful:', response);
            location.reload(); // Reload page after successful save
        },
        error: function(xhr, status, error) {
            console.error('AJAX request failed:', xhr.status, status, error);
            alert('Error saving task: ' + xhr.responseText);
        }
    });
});

    });
</script>
</body>
</html>
