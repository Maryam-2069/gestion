<?php 
require_once "cnx.php";
if(isset($_POST['submit'])){
    $nom = $_POST['nom_client'];
    $email = $_POST['email'];
    $telephone = $_POST['telephone'];
    $adresse = $_POST['adresse'];
    $password = $_POST['password'];
    $sql = "INSERT INTO clients (nom_client , email,adresse,pasword,telephone) VALUES (?,?,?,?,?)";
    $stm = $db->prepare($sql);
    $stm->execute([$nom,$email,$adresse,$password,$telephone]);
    if($stm){
        echo "<div class='alert alert-dark'>Client added successfully!</div>";
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
        <h1>Add Clients</h1>
        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label  class="form-label">Nom de client</label>
                <input type="text" class="form-control"  name="nom_client">
            </div>
            <div class="mb-3">
                <label  class="form-label">Email</label>
                <input type="text" class="form-control"  name="email">
            </div>
            <div class="mb-3">
                <label class="form-label">Adresse</label>
                <input type="text" class="form-control"  name="adresse">
            </div>
            <div class="mb-3">
                <label  class="form-label">Telephone</label>
                <input type="text" class="form-control"  name="telephone" >
            </div>
            <div class="mb-3">
                <label  class="form-label">Password</label>
                <input type="text" class="form-control"  name="password" >
            </div>
            <button type="submit" class="btn btn-light" name='submit'>Add</button>
            <a href="admin_client.php" class="btn btn-secondary">Cancel</a>
        </form>
    </div>
</body>
</html>