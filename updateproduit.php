<?php 
session_start();
if (!isset($_SESSION['id_client'])) {
    header('Location: login.php'); 
    exit;
}
require_once "cnx.php";
if(isset($_GET['id_produit'])){
    $id = $_GET['id_produit'];
    $sql = "SELECT * FROM produits where id_produit = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$id]);
    $produit = $stmt->fetch(PDO::FETCH_OBJ);

    if(!$produit){
        echo "Aucun produit trouvé";
        exit;
    }

}
else{
    echo "<div class='alert alert-warning'>Produit id missing</div>";
}
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $nom = $_POST['nom_produit'];
    $prix = $_POST['prix'];
    $stock = $_POST['stock'];
    $description = $_POST['description'];

    if(!empty($nom) && !empty($prix) && !empty($stock) && !empty($description)){
        $sql = "UPDATE produits SET nom_produit = ?, prix = ?, stock = ?, description = ?   where id_produit = ?";
        $stmt = $db->prepare($sql);
        if($stmt->execute([$nom , $prix , $stock , $description ,$id])){
            header("Location: updateproduit.php?id_produit=" . $id);
            echo "<div class='alert alert-dark'>Produit updated successfully! <a href='admin_produit.php' class='btn btn-secondary'>Go Back</a></div>";
        }
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
        <h1>Update Produit </h1>
        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Nom_produit</label>
                <input type="text" class="form-control"  name="nom_produit" value="<?php echo $produit->nom_produit; ?>" >
            </div>
            <div class="mb-3">
                <label  class="form-label">Prix</label>
                <input type="text" class="form-control" name="prix" value="<?php echo $produit->prix; ?>" >
            </div>
            <div class="mb-3">
                <label  class="form-label">Stock</label>
                <input type="text" class="form-control" name="stock" value="<?php echo $produit->stock; ?>" >
            </div>
            <div class="mb-3">
                <label class="form-label">Decription</label>
                <input type="text" class="form-control" name="description" value="<?php echo $produit->description; ?>" >
            </div>
            <div class="mb-3">
                <label class="form-label">Image</label>
                <input type="file" class="form-control" name="image" value="<?php echo $produit->image; ?>" >
            </div>
            <button type="submit" class="btn btn-light">Save Changes</button>
            <a href="admin_produit.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>