<?php
include 'db.php'; // Include the database connection

// Fetch all menu items
$sql = "SELECT * FROM MenuItem";
$stmt = $pdo->query($sql);
$menu_items = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order - C&O Burger</title>
    <link rel="stylesheet" href="stylesorder.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container">
        <div class="menu-filter">
            <nav class="menu-categories">
                <button onclick="filterMenu('Burger')">Burger</button>
                <button onclick="filterMenu('Ala Carte')">Ala Carte</button>
                <button onclick="filterMenu('Side Dish')">Side Dish</button>
                <button onclick="filterMenu('Beverage')">Beverage</button>
                <button onclick="filterMenu('Desserts')">Desserts</button>
                <button onclick="filterMenu('All')">All</button>
            </nav>
        </div>

        <div class="content">
            <div class="menu-items" id="menuItems">
                <?php foreach ($menu_items as $item): ?>
                    <div class="menu-item" data-category="<?php echo htmlspecialchars($item['Category']); ?>" onclick="displayMenuItem(<?php echo $item['Menu_ID']; ?>)">
                        <?php if ($item['ImagePath']): ?>
                            <img src="<?php echo htmlspecialchars($item['ImagePath']); ?>" alt="Menu Image">
                        <?php endif; ?>
                        <h2><?php echo htmlspecialchars($item['Name']); ?></h2>
                        <p>RM <?php echo htmlspecialchars($item['Price']); ?></p>
                        <button class="order-now" onclick="event.stopPropagation(); displayMenuItem(<?php echo $item['Menu_ID']; ?>)">Order now</button>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="menu-details" id="menuDetails">
                <!-- JavaScript will populate this area with menu details -->
            </div>
        </div>
    </div>

    <script>
        function displayMenuItem(menuId) {
            // Fetch and display menu details using JavaScript
            fetch('get_menu_item.php?id=' + menuId)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('menuDetails').innerHTML = `
                        <img src="${data.ImagePath}" alt="Menu Image">
                        <h2>${data.Name}</h2>
                        <p>RM ${data.Price}</p>
                        <p>${data.Description}</p>
                        <label for="request">Request:</label>
                        <input type="text" id="request" name="request">
                        <div class="quantity-selector">
                            <button type="button" onclick="changeQuantity(-1)">-</button>
                            <input type="number" id="quantity" name="quantity" value="1" min="1">
                            <button type="button" onclick="changeQuantity(1)">+</button>
                        </div>
                        <button type="button" onclick="addToCart(${menuId})">Add to Cart</button>
                    `;
                });
        }

        function changeQuantity(amount) {
            const quantityInput = document.getElementById('quantity');
            let quantity = parseInt(quantityInput.value);
            quantity += amount;
            if (quantity < 1) quantity = 1;
            quantityInput.value = quantity;
        }

        function addToCart(menuId) {
            const quantity = document.getElementById('quantity').value;
            const request = document.getElementById('request').value;

            fetch('add_to_cart.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    menuId: menuId,
                    quantity: quantity,
                    request: request
                }),
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert('Item added to cart!');
                    window.location.href = 'cart.php';
                } else {
                    alert('Failed to add item to cart.');
                }
            });
        }

        function filterMenu(category) {
            const items = document.querySelectorAll('.menu-item');
            items.forEach(item => {
                if (category === 'All' || item.getAttribute('data-category') === category) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        }
    </script>
</body>
</html>
