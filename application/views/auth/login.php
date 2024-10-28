<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>

    <!-- Display validation errors or flash messages -->
    <?php if ($this->session->flashdata('error')): ?>
        <p style="color:red;"><?php echo $this->session->flashdata('error'); ?></p>
    <?php endif; ?>

    <?php echo form_open('auth/login'); ?>

    <label>Email:</label>
    <input type="text" name="email" value="<?php echo set_value('email'); ?>">
    <?php echo form_error('email'); ?>

    <label>Password:</label>
    <input type="password" name="password">
    <?php echo form_error('password'); ?>

    <button type="submit">Login</button>

    <?php echo form_close(); ?>
</body>
</html>
