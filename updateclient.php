<?php
session_start();
if (!isset($_SESSION['id_client'])) {
    header('Location: login.php'); 
    exit;
}
require_once "cnx.php";
if (isset($_GET['id_client'])) {
    $id = $_GET['id_client'];
    $sql = "SELECT * FROM clients WHERE id_client = ?";
    $stm = $db->prepare($sql);
    $stm->execute([$id]);
    $client = $stm->fetch(PDO::FETCH_OBJ);

    if (!$client) {
        echo "<div class='alert alert-danger'>Client not found.</div>";
        exit;
    }
} else {
    echo "<div class='alert alert-warning'>Client ID is missing.</div>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom_client'];
    $email = $_POST['email'];
    $adresse = $_POST['adresse'];
    $telephone = $_POST['telephone'];

    if (!empty($nom) && !empty($email) && !empty($adresse) && !empty($telephone)) {
        $stm = "UPDATE clients SET nom_client = ?, email = ?, adresse = ?, telephone = ? WHERE id_client = ?";
        $s = $db->prepare($stm);
        if ($s->execute([$nom, $email, $adresse, $telephone, $id])) {
            echo "<div class='alert alert-dark'>Client updated successfully! <a href='admin_client.php' class='btn btn-secondary'>Go Back</a></div>
            ";
        }
    } 
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Client</title>
    <link rel="stylesheet" href="signup.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container mt-5">
        <h1>Update Client Information</h1>
        <form method="POST" action="">
            <div class="mb-3">
                <label for="nom_client" class="form-label">Nom</label>
                <input type="text" class="form-control" id="nom_client" name="nom_client" value="<?php echo $client->nom_client; ?>" >
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $client->email; ?>" >
            </div>
            <div class="mb-3">
                <label for="adresse" class="form-label">Adresse</label>
                <input type="text" class="form-control" id="adresse" name="adresse" value="<?php echo $client->adresse; ?>" >
            </div>
            <div class="mb-3">
                <label for="telephone" class="form-label">Telephone</label>
                <input type="text" class="form-control" id="telephone" name="telephone" value="<?php echo $client->telephone; ?>" >
            </div>
            <button type="submit" class="btn btn-light">Save Changes</button>
            <a href="admin_produit.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>

</html>