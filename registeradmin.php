<?php
// Include the database connection file
include 'db.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data and sanitize it
    $userUsername = htmlspecialchars($_POST['username']);
    $userEmail = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $userPassword = password_hash($_POST['password'], PASSWORD_DEFAULT); // Securely hash the password
    $userType = htmlspecialchars($_POST['type']);

    // Validate email
    if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format');</script>";
    } else {
        // Prepare an SQL query to insert user data into the database
        $sql = "INSERT INTO user (Username, Email, Password, Type) VALUES (?, ?, ?, ?)";
        $stmt = $pdo->prepare($sql);

        // Execute the query and check if the user is successfully registered
        try {
            $stmt->execute([$userUsername, $userEmail, $userPassword, $userType]);
            echo "<script>alert('Registered successfully!'); window.location.href='login.php';</script>";
        } catch (PDOException $e) {
            echo "<script>alert('Registration failed: " . $e->getMessage() . "');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="stylesregister.css">
</head>
<body>
    <form action="registeradmin.php" method="post">
        <div class="company-name">C&O BURGER</div>
        <h2>Register</h2>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>

        <label for="type">Type:</label>
        <select name="type" id="type">
           <!-- <option value="user">User</option>-->
            <option value="admin">Admin</option>
        </select>
        
        <button type="submit">Register</button>
        <br>
        <p>Already have an account? <a href="login.php">Log In here</a>.</p>
    </form>
</body>
</html>
