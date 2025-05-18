<?php
require 'db.php';
session_start();

$search = trim($_GET['search_keyword'] ?? '');
$price_order = $_GET['price_order'] ?? '';
$brand = $_GET['brand'] ?? '';
$gender = $_GET['gender'] ?? '';


$query = "SELECT * FROM products WHERE 1=1";
$params = [];

if (!empty($search)) {
    $query .= " AND (name LIKE ? OR category LIKE ? OR description LIKE ?)";
    $searchTerm = "%$search%";
    array_push($params, $searchTerm, $searchTerm, $searchTerm);
}

if (!empty($brand)) {
    $query .= " AND brand = ?";
    $params[] = $brand;
}

if (!empty($gender)) {
    $query .= " AND gender = ?";
    $params[] = $gender;
}

if (!empty($price_order) && in_array($price_order, ['asc', 'desc'])) {
    $query .= " ORDER BY price $price_order";
} else {
    $query .= " LIMIT 10"; 
}

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$products = $stmt->fetchAll();


$brands_stmt = $pdo->query("SELECT DISTINCT brand FROM products");
$brands = $brands_stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MyFragrance - Home</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <style>
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            padding: 20px;
        }

        .product {
            border: 1px solid #ddd;
            border-radius: 10px;
            background: #fff;
            text-align: center;
            padding: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .product:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
        }

        .product img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
            object-fit: cover;
            max-height: 200px;
            margin-bottom: 10px;
        }

        .product h3 {
            font-size: 18px;
            margin: 10px 0;
            color: #333;
        }

        .product p {
            font-size: 16px;
            color: #555;
        }

        .product .price {
            font-size: 18px;
            font-weight: bold;
            color: #333;
        }

        .product button {
            margin-top: 10px;
            padding: 10px 15px;
            border: none;
            background-color: #333;
            color: #fff;
            cursor: pointer;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        .product button:hover {
            background-color: #555;
        }

        .container h2 {
            text-align: center;
            margin: 20px 0;
            color: #333;
        }

        .search-form, .filter-form {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 10px;
            margin: 20px;
        }

        .search-form input[type="text"], .filter-form select {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            min-width: 200px;
        }

        .search-form button, .filter-form button {
            padding: 10px 15px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .search-form button:hover, .filter-form button:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
<?php include 'includes/header.php'; ?>

<div class="container">
    <h2>Browse Our Collection</h2>

    
    <form method="GET" action="index.php" class="search-form">
        <input type="text" name="search_keyword" placeholder="Search..." value="<?php echo htmlspecialchars($search); ?>">
        <button type="submit">Search</button>
    </form>


    <form method="GET" action="index.php" class="filter-form">
        
        <input type="hidden" name="search_keyword" value="<?php echo htmlspecialchars($search); ?>">

        <select name="brand">
            <option value="">All Brands</option>
            <?php foreach ($brands as $b): ?>
                <option value="<?php echo htmlspecialchars($b['brand']); ?>" <?php echo $brand === $b['brand'] ? 'selected' : ''; ?>>
                    <?php echo htmlspecialchars($b['brand']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <select name="gender">
            <option value="">All Genders</option>
            <option value="male" <?php echo $gender === 'male' ? 'selected' : ''; ?>>Male</option>
            <option value="female" <?php echo $gender === 'female' ? 'selected' : ''; ?>>Female</option>
            <option value="unisex" <?php echo $gender === 'unisex' ? 'selected' : ''; ?>>Unisex</option>
        </select>

        <select name="price_order">
            <option value="">Sort by Price</option>
            <option value="asc" <?php echo $price_order === 'asc' ? 'selected' : ''; ?>>Low to High</option>
            <option value="desc" <?php echo $price_order === 'desc' ? 'selected' : ''; ?>>High to Low</option>
        </select>

        <button type="submit">Apply Filters</button>
    </form>

    <div class="products-grid">
        <?php if (count($products) > 0): ?>
            <?php foreach ($products as $product): ?>
                <div class="product">
                    <img src="assets/images/<?php echo htmlspecialchars($product['image']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                    <h3><?php echo htmlspecialchars($product['name']); ?></h3>
                    <p>Stock: <?php echo htmlspecialchars($product['quantity']); ?> pcs</p>
                    <p>Brand: <?php echo htmlspecialchars($product['brand']); ?></p>
                    <p>Gender: <?php echo htmlspecialchars(ucfirst($product['gender'])); ?></p>
                    <p class="price">$<?php echo number_format($product['price'], 2); ?></p>
                    <form action="add_to_cart.php" method="POST">
                        <input type="hidden" name="product_id" value="<?php echo htmlspecialchars($product['id']); ?>">
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit">Add to Cart</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="text-align:center;">No products found.</p>
        <?php endif; ?>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
</body>
</html>
