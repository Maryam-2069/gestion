<?php
session_start();
require_once "cnx.php";

if (!isset($_SESSION['id_client'])) {
    header("Location: login.php");
    exit;
}

$id_client = $_SESSION['id_client'];
$sql = "SELECT panier.id_produit, panier.quantite, produits.nom_produit, produits.prix
        FROM panier
        JOIN produits ON panier.id_produit = produits.id_produit
        WHERE panier.id_client = ?";
$stm = $db->prepare($sql);
$stm->execute([$id_client]);
$cartItems = $stm->fetchAll(PDO::FETCH_OBJ);

$total = 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_quantity'])) {
    $id_produit = $_POST['id_produit'];
    $new_quantity = $_POST['quantite'];

    $updateSql = "UPDATE panier SET quantite = ? WHERE id_produit = ? AND id_client = ?";
    $updateStm = $db->prepare($updateSql);
    $updateStm->execute([$new_quantity, $id_produit, $id_client]);

    header("Location: panier.php");
    exit;
}

if (isset($_GET['remove_id'])) {
    $id_produit = $_GET['remove_id'];
    $removeSql = "DELETE FROM panier WHERE id_produit = ? AND id_client = ?";
    $removeStm = $db->prepare($removeSql);
    $removeStm->execute([$id_produit, $id_client]);

    header("Location: panier.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
</head>
<body>
    <h2>Your Cart</h2>
    <table border="1">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($cartItems as $item) : ?>
                <tr>
                    <td><?php echo $item->nom_produit; ?></td>
                    <td><?php echo number_format($item->prix, 2); ?> DH</td>
                    <td>
                        <form method="POST">
                            <input type="number" name="quantite" value="<?php echo $item->quantite; ?>" min="1" required>
                            <input type="hidden" name="id_produit" value="<?php echo $item->id_produit; ?>">
                            <button type="submit" name="update_quantity">Update</button>
                        </form>
                    </td>
                    <td>
                        <a href="panier.php?remove_id=<?php echo $item->id_produit; ?>">Remove</a>
                    </td>
                </tr>
                <?php
                
                $total += $item->prix * $item->quantite;
                ?>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Total: <?php echo $total; ?> DH</h3>
    <a href="home.php">Back to Shop</a>
</body>
</html>
