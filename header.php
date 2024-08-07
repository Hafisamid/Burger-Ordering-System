<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>C&O Burger Restaurant</title>
    <link rel="stylesheet" href="styleshome.css">

<script>
        function confirmLogout(event) {
            if (!confirm("Are you sure you want to log out?")) {
                event.preventDefault();
            }
        }
    </script>

</head>
<body>
    <header>
        <div class="navbar">
            <div class="logot">C&O BURGER</div>
            <nav>
                <ul>
                    <li><a href="homepage.php">HOME</a></li>
                    <li><a href="about.php">ABOUT US</a></li>
                    <li><a href="order.php">ORDER</a></li>
                    <li><a href="reservation.php">RESERVATION</a></li>
                    <li><a href="logout.php" onclick="confirmLogout(event)">LOG OUT</a></li>
                </ul>
            </nav>
        </div>
    </header>
