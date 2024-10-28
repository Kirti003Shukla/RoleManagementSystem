<!-- application/views/auth/register.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <link rel="stylesheet" href="path/to/your/styles.css"> <!-- Add any custom styles if needed -->
</head>
<body>
    <h2>Register</h2>
    
    <!-- Display validation errors or any other error messages -->
    <?php if(validation_errors() || $this->session->flashdata('error')): ?>
        <div class="error-messages">
            <?php echo validation_errors(); ?>
            <?php echo $this->session->flashdata('error'); ?>
        </div>
    <?php endif; ?>

    <!-- Registration Form -->
    <form action="<?php form_open('auth/register'); ?>" method="post">
        <!-- Username -->
        <div>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo set_value('username'); ?>" required>
        </div>

        <!-- Email -->
        <div>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo set_value('email'); ?>" required>
        </div>

        <!-- Password -->
        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>

        <!-- Confirm Password -->
        <div>
            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
        </div>

        <!-- Role Selection (Admin, Manager, User) -->
        <div>
            <label for="role">Role:</label>
            <select id="role" name="role" required>
                <option value="User">User</option>
                <option value="Manager">Manager</option>
                <option value="Admin">Admin</option>
            </select>
        </div>

        <!-- Submit Button -->
        <button type="submit">Register</button>
    </form>

    <p>Already have an account? <a href="<?php echo base_url('auth/login'); ?>">Login here</a>.</p>
</body>
</html>
