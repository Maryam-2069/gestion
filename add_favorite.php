<?php 
session_start();
require_once "cnx.php";

// Ensure the client is logged in
if (!isset($_SESSION['id_client'])) {
    header("Location: login.php");
    exit;
}

$id_client = $_SESSION['id_client'];
$id_produit = $_GET['favorite_product'];

// Debugging: Check if product ID and client ID are set
if (empty($id_produit) || empty($id_client)) {
    die("Product ID or Client ID is missing.");
}

// Check if the product is already in favorites
$sql = "SELECT * FROM favorites WHERE client_id = ? AND product_id = ?";
$stm = $db->prepare($sql);
$stm->execute([$id_client, $id_produit]);
$existingFavorite = $stm->fetch(PDO::FETCH_OBJ);

// Debugging: Check if product already exists in the favorites
if ($existingFavorite) {
    echo "Product is already in your favorites.";
} else {
    // Add product to favorites if not already in the favorites list
    $insertSql = "INSERT INTO favorites (client_id, product_id) VALUES (?, ?)";
    $insertStm = $db->prepare($insertSql);
    $insertStm->execute([$id_client, $id_produit]);

    if ($insertStm) {
        echo "Product added to your favorites.";
    } else {
        die("Error adding product to favorites.");
    }
}

header("Location: favorite.php"); // Redirect after adding to favorites
exit;
?>
