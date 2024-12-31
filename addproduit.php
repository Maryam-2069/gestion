<?php 
require_once "cnx.php";

if (isset($_POST['submit'])) {
    $nom = $_POST['nom_produit'];
    $prix = $_POST['prix'];
    $stock = $_POST['stock'];
    $description = $_POST['description'];

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_name = $_FILES['image']['name'];
        $image_tmp_name = $_FILES['image']['tmp_name'];
        $image_path = 'images/' . $image_name;

        if (move_uploaded_file($image_tmp_name, $image_path)) {
            $sql = "INSERT INTO produits (nom_produit, prix, stock, description, image) VALUES (?, ?, ?, ?, ?)";
            $stmt = $db->prepare($sql);
            $stmt->execute([$nom, $prix, $stock, $description, $image_path]);

            echo "<div class='alert alert-dark'>Product added successfully!</div>";
        } else {
            echo "<div class='alert alert-danger'>Failed to upload image.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>Please select an image to upload.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="signup.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Add Produit</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label  class="form-label">Nom de produit</label>
                <input type="text" class="form-control"  name="nom_produit">
            </div>
            <div class="mb-3">
                <label  class="form-label">Prix de produit</label>
                <input type="text" class="form-control"  name="prix">
            </div>
            <div class="mb-3">
                <label class="form-label">Stock</label>
                <input type="text" class="form-control"  name="stock">
            </div>
            <div class="mb-3">
                <label  class="form-label">Description de produit</label>
                <input type="text" class="form-control"  name="description" >
            </div>
            <div class="mb-3">
                <label class="form-label">Image de Produit</label>
                <input type="file" class="form-control" name="image" >
            </div>
            <button type="submit" class="btn btn-light" name='submit'>Add</button>
            <a href="admin_produit.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>