<?php
session_start();
include 'db.php'; // Include the database connection file

$error = ''; // Initialize the error message variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password']; // The password user entered in the form

    $sql = "SELECT User_ID, Username, Password, Type FROM User WHERE Username = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user) {
        if (password_verify($password, $user['Password'])) {
            $_SESSION['user_id'] = $user['User_ID'];
            $_SESSION['username'] = $user['Username'];
            $_SESSION['user_type'] = $user['Type'];

            if ($user['Type'] === 'admin') {
                header("Location: report.php"); // Redirect to the Admin Dashboard
                exit();
            } else {
                header("Location: homepage.php"); // Redirect to the User Homepage
                exit();
            }
        } else {
            $error = "Invalid username or password.";
        }
    } else {
        $error = "Invalid username or password.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styleslogin.css">
</head>
<body>
    <form action="login.php" method="post">
        <div class="company-name">C&O BURGER</div>
        <h2>Login</h2>
        <?php if (!empty($error)): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        
        <button type="submit">Login</button>
        <br>
        <p>Don't have an account? <a href="register.php">Register here</a>.</p>
    </form>
</body>
</html>
