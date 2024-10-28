<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css'); ?>">
    <script src="<?= base_url('assets/js/jquery.min.js'); ?>"></script>
</head>
<body><a href="<?php echo site_url('auth/logout'); ?>" class="btn btn-danger">Logout</a>
    <h1>User Dashboard</h1>
    <div id="taskList">
        <h2>Your Tasks</h2>
        <table>
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Priority</th>
                    <th>Due Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tasks as $task): ?>
                    <tr data-task-id="<?= $task['id']; ?>">
                        <td><?= $task['title']; ?></td>
                        <td><?= $task['description']; ?></td>
                        <td><?= $task['priority']; ?></td>
                        <td><?= date('Y-m-d', strtotime($task['due_date'])); ?></td>
                        <td><?= $task['status']; ?></td>
                        <td>
                        <form method="post" action="<?php echo site_url('tasks/update_status'); ?>">
    <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
    <input type="hidden" name="role" value="<?php echo $this->session->userdata('role'); ?>"> <!-- User's role -->

    <select name="status">
        <option value="Pending">Pending</option>
        <option value="In Progress">In Progress</option>
        <option value="Completed">Completed</option>
    </select>
    <button type="submit" class="btn btn-primary">Update Status</button>
</form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div id="statusModal" style="display:none;">
        <form id="statusForm">
            <input type="hidden" name="task_id" id="task_id" value="">
            <label for="status">Status:</label>
            <select name="status" id="status">
                <option value="In Progress">In Progress</option>
                <option value="Completed">Completed</option>
                <option value="Pending">Pending</option>
            </select>
            <button type="submit">Update Status</button>
            <button type="button" id="closeStatusModal">Close</button>
        </form>
    </div>

    <script>
        $(document).ready(function() {
            // Open modal for updating status
            $('.updateStatusBtn').click(function() {
                const taskId = $(this).closest('tr').data('task-id');
                $('#task_id').val(taskId);
                $('#statusModal').show();
            });

            // Close status modal
            $('#closeStatusModal').click(function() {
                $('#statusModal').hide();
            });

            // Handle status form submission
            $('#statusForm').submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: '<?= base_url('tasks/update_status'); ?>', // Modify the URL according to your task controller
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        location.reload(); // Reload page after status update
                    },
                    error: function() {
                        alert('Error updating status');
                    }
                });
            });
        });
    </script>
</body>
</html>
