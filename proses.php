<?php
session_start();
include 'koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action'])) {
        // Registration process
        if ($_POST['action'] === 'register') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';
            $full_name = $_POST['full_name'] ?? '';
            $phone_number = $_POST['phone_number'] ?? '';
            $department = $_POST['department'] ?? '';
            $role = $_POST['role'] ?? 'staff';

            // Input validation
            if (empty($username) || empty($email) || empty($password) || empty($confirm_password) ||
                empty($full_name) || empty($phone_number) || empty($department)) {
                echo "All fields must be filled.";
                exit;
            }

            if ($password !== $confirm_password) {
                echo "Password and Confirm Password do not match.";
                exit;
            }

            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert data into database
            try {
                $conn = new Koneksi();
                $query = $conn->db->prepare("INSERT INTO users (username, email, password, full_name, phone_number, department, role, join_date) VALUES (?, ?, ?, ?, ?, ?, ?, CURDATE())");
                $query->execute([$username, $email, $hashed_password, $full_name, $phone_number, $department, $role]);

                header("Location: login.php");
                exit;
            } catch (Exception $e) {
                echo "Error occurred: " . $e->getMessage();
            }
        }

        // Login process
        if ($_POST['action'] === 'login') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($username) || empty($password)) {
                echo "Username or password cannot be empty.";
                exit;
            }

            $conn = new Koneksi();
            $query = $conn->db->prepare("SELECT id, username, password, role FROM users WHERE username = ?");
            $query->execute([$username]);
            $user = $query->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($password, $user['password'])) {
                // Set session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'];

                header("Location: cms.php");
                exit;
            } else {
                echo "Login failed! Invalid username or password.";
            }
        }
    }
}
?>