<?php
session_start();
require_once "cnx.php";

if (!isset($_SESSION['id_client'])) {
    header("Location: login.php"); 
    exit();
}

$client_id = $_SESSION['id_client'];

$sql = "
    SELECT produits.id_produit, produits.nom_produit, produits.description, produits.prix, produits.image
    FROM favorites
    JOIN produits ON favorites.product_id = produits.id_produit
    WHERE favorites.client_id = ?
";

$stm = $db->prepare($sql);
$stm->execute([$client_id]);

$favorites = $stm->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Favorite Products</title>
    <link rel="stylesheet" href="favorite.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body>

    <div class="container">
        <h2>Your Favorite Products</h2>
        <table class="table">
            <thead>
                <tr>
                
                    <th>Product Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (count($favorites) > 0): ?>
                    <?php foreach ($favorites as $favorite): ?>
                        <tr>
                        
                            <td><?php echo $favorite->nom_produit; ?></td>
                            <td><?php echo $favorite->description; ?></td>
                            <td><?php echo $favorite->prix; ?> DH</td>
                            
                            <td>
                                <a href="favorite.php?remove_id=<?php echo $favorite->id_produit; ?>" class="btn btn-danger btn-sm">Remove</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">You have no favorite products.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="text-center">
            <a href="home.php">
                <button class="gh">Go Back Home</button>
            </a>
        </div>
    </div>

</body>

</html>