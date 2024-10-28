<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<h2>Edit Task</h2>

<form method="post" action="<?php echo site_url('tasks/save'); ?>">
    <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>" />
    <div>
        <label for="title">Title:</label>
        <input type="text" name="title" id="title" value="<?php echo $task['title']; ?>" required />
    </div>
    <div>
        <label for="description">Description:</label>
        <textarea name="description" id="description" required><?php echo $task['description']; ?></textarea>
    </div>
    <div>
        <label for="priority">Priority:</label>
        <select name="priority" id="priority">
            <option value="High" <?php echo ($task['priority'] === 'High') ? 'selected' : ''; ?>>High</option>
            <option value="Medium" <?php echo ($task['priority'] === 'Medium') ? 'selected' : ''; ?>>Medium</option>
            <option value="Low" <?php echo ($task['priority'] === 'Low') ? 'selected' : ''; ?>>Low</option>
        </select>
    </div>
    <div>
        <label for="due_date">Due Date:</label>
        <input type="date" name="due_date" id="due_date" value="<?php echo $task['due_date']; ?>" required />
    </div>
    <div>
        <label for="category">Category:</label>
        <input type="text" name="category" id="category" value="<?php echo $task['category']; ?>" required />
    </div>
    <div>
        <label for="assigned_to">Assigned To:</label>
        <input type="text" name="assigned_to" id="assigned_to" value="<?php echo $task['assigned_to']; ?>" required />
    </div>
    <div>
        <input type="submit" value="Update Task" />
    </div>
</form>
