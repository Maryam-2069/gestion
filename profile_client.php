<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="admin.css?v-1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body>
    <div class="container">
        <div class="dashboard">
            <img src="images/profile.png" alt="Profile" class="profile-img">
            <ul>
                <li>
                    <img src="images/details.png" alt="Clients Icon">
                    <a href="">Personal Details</a>
                </li>
                <li>
                    <img src="images/heart.png" alt="Clients Icon">
                    <a href="favorite.php">Favorite</a>
                </li>
                <li>
                    <img src="images/icons8-cart-50.png" alt="Clients Icon">
                    <a href="panier.php">Orders</a>
                </li>
                <li>
                    <img src="images/goback.png" alt="Logout Icon">
                    <a href="home.php">Go Back Shop</a>
                </li>
                <li>
                    <img src="images/logout.png" alt="Logout Icon">
                    <a href="logout.php">Logout</a>
                </li>
            </ul>
            
        </div>
        <?php
        require_once "cnx.php";
        if (!isset($_SESSION['id_client'])) {
            header("Location:login.php");
        }
        $id_client = $_SESSION['id_client'];
        $sql = "SELECT * from clients where id_client = ?";
        $stm = $db->prepare($sql);
        $stm->execute([$id_client]);
        $result = $stm->fetch(PDO::FETCH_OBJ);
        if (isset($_POST['submit'])) {
            $nom = $_POST['nom'];
            $email = $_POST['email'];
            $adresse = $_POST['adresse'];
            $telephone = $_POST['tel'];
            $oldpass = $_POST['oldpass'];
            $newpass = $_POST['newpass'];

            if (!empty($nom) && !empty($email) && !empty($adresse) && !empty($telephone) ) {
                if(password_verify($oldpass,$result->pasword)){
                    $pashash = password_hash($newpass,PASSWORD_DEFAULT);
                    $sql = "UPDATE clients SET nom_client = ?, email = ?, adresse = ?, pasword = ? ,telephone = ? where id_client = ?";
                    $stm = $db->prepare($sql);
                    $stm->execute([$nom, $email, $adresse,$pashash, $telephone, $id_client]);
                    
                $_SESSION['nom_client'] = $nom;
                header("Location:profile_client.php");
                }
             
            }
        }

        ?>

        <div class="cnt">
        <h2 >Welcome <?php echo $_SESSION['nom_client'] ?></h2>
            <form action="" method="post">
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" class="form-control" name="nom" value="<?php echo $result->nom_client; ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control"  name="email" value="<?php echo $result->email; ?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="adresse" class="form-label">Adresse</label>
                        <input type="text" class="form-control"  name="adresse" value="<?php echo $result->adresse; ?>" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tel" class="form-label">Telephone</label>
                        <input type="tel" class="form-control" id="tel" name="tel" value="<?php echo $result->telephone; ?>" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="adresse" class="form-label">Old Password</label>
                        <input type="text" class="form-control"  name="oldpass"required placeholder="Enter Your Old Password">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="tel" class="form-label">New Password </label>
                        <input type="tel" class="form-control"  name="newpass" placeholder="Enter Ur New Password">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 text-center">
                        <button type="submit" class="updt" name="submit">Update</button>
                    </div>
                </div>
            </form>

        </div>
    </div>

</body>

</html>