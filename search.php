<?php
session_start();
require_once "cnx.php";

if (!isset($_GET['query']) || empty(trim($_GET['query']))) {
    header("Location: home.php");
    exit();
}

$searchQuery = '%' . trim($_GET['query']) . '%';

// Fetch products matching the search query
$sql = "
    SELECT id_produit, nom_produit, description, prix, image
    FROM produits
    WHERE nom_produit LIKE ? OR description LIKE ?
";
$stm = $db->prepare($sql);
$stm->execute([$searchQuery, $searchQuery]);

$products = $stm->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Search Results</h2>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Product Name</th>
                    <th>Description</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($products) > 0): ?>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><img src="<?php echo $product->image; ?>" alt="Product Image" width="50"></td>
                            <td><?php echo $product->nom_produit; ?></td>
                            <td><?php echo $product->description; ?></td>
                            <td><?php echo $product->prix; ?> DH</td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">No products found matching your search.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="text-center">
            <a href="home.php" class="btn btn-secondary">Back to Home</a>
        </div>
    </div>
</body>
</html>
