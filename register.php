<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container auth-form">
        <h2>Register</h2>
        <form action="proses.php" method="post">
            <input type="hidden" name="action" value="register">

            <label for="username">Username:</label>
            <input type="text" name="username" required>

            <label for="email">Email:</label>
            <input type="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" name="password" required>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" name="confirm_password" required>

            <label for="full_name">Full Name:</label>
            <input type="text" name="full_name" required>

            <label for="phone_number">Phone Number:</label>
            <input type="tel" name="phone_number" required>

            <label for="department">Department:</label>
            <select name="department" required>
                <option value="">Select Department</option>
                <option value="Emergency">Emergency</option>
                <option value="Surgery">Surgery</option>
                <option value="Radiology">Radiology</option>
                <option value="Laboratory">Laboratory</option>
                <option value="ICU">ICU</option>
                <option value="General">General</option>
            </select>

            <label for="role">Role:</label>
            <select name="role" required>
                <option value="staff">Staff</option>
                <option value="technician">Technician</option>
                <option value="admin">Admin</option>
            </select>

            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login</a></p>
    </div>
</body>

</html>