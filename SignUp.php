<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
     <link rel="stylesheet" href="signup.css">
</head>
<body>
<nav>
        <h3 class="logo">Logo</h3>
        <ul class="navlinks">
            <li><a href="">Shop</a></li>
            <li><a href="">About</a></li>
            <li><a href="">Contact</a></li>
        </ul>
        <div class="icons">
            <img src="images/icons8-shop-30.png">
            <button class="signup"><a href="login.php">Login</a></button>
        </div>
    </nav>
    <?php 
    session_start();
    require_once "cnx.php";
    if(isset($_POST['submit'])){
        $nom = $_POST['nom'];
        $adress = $_POST['adress'];
        $tel = $_POST['tel'];
        $email = $_POST['email'];
        $pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);
        $sql = "INSERT INTO clients (nom_client ,email,adresse,pasword,telephone)  VALUES (?,?,?,?,?)";
        $stm = $db->prepare($sql);
        $stm->execute([$nom,$email,$adress,$pass,$tel]);
        if($stm){
            $_SESSION['client'] = [
                'nom'=>$nom,
                'email'=>$email,
                'id'=>$id
            ];
            header('Location:login.php');
        }
    }
    ?>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body cb">
                        <h4 class="card-title mb-4" style="text-align: center;">SignUp</h4>
                        <form action="" method="post">
                            <div class="mb-3">
                                <label  class="form-label">Nom</label>
                                <input type="text" class="form-control" id="nom" name="nom">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Adress</label>
                                <input type="text" class="form-control" id="adress" name="adress">
                            </div>
                            <div class="mb-3">
                                <label  class="form-label">Telephone</label>
                                <input type="text" class="form-control" id="tel" name="tel">
                            </div>
                            <div class="mb-3">
                                <label  class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email">
                            </div>
                            <div class="mb-3">
                                <label  class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="pass">
                            </div>
                            <div class="d-flex justify-content-center">
                                <button type="submit" class="send" name="submit">Sign Up</button>
                            </div>
                            
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>