<?php
session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>

<body>

    <nav>
        <h3 class="logo">Logo</h3>
        <ul class="navlinks">
            <li><a href="home.php">Shop</a></li>
            <li><a href="">About</a></li>
            <li><a href="">Contact</a></li>
        </ul>
        <div class="icons">
            <img src="images/icons8-shop-30.png">
            <?php
            if (!isset($_SESSION['id_client'])): ?>
                <button class="signup"><a href="SignUp.php">SignUp</a></button>
                <button class="signup"><a href="login.php">Login</a></button>
            <?php else: ?>
                <a href="profile_client.php"><img src="images/profile.png" style="width: 40px;"></a>
            <?php endif ?>

        </div>
    </nav>
    <section class="intro">
        <div class="text-content">
            <h3 class="title">Wear Your Confidence, <br> Shape Your Story</h3>
            <p class="paragraph">
                Clothing is more than fabric; it’s an extension of who you are. <br>
                The right outfit doesn’t just dress you—it empowers you. At MaryamStore,<br>
                we believe in celebrating individuality through timeless designs and vibrant trends. <br>
                Let your wardrobe tell your story—authentic, confident, and uniquely you.
            </p>
            <button class="shopbtn">Shop Now</button>
        </div>
        <img src="images/image.png" class="animated-lady">
    </section>
    <section class="shopitems">
        <div class="title_parag">
            <h2>What we have in our store</h2>
            <p>Shop our trendy , hight-quality clothig for only occasion . </p>
        </div>
        <div class="container_circles">
            <div class="circles">
                <img src="images/iconpants.png" alt="">
                <span class="titlecircles">Pants</span>
            </div>
            <div class="circles">
                <img src="images/iconjacket.png" alt="">
                <span class="titlecircles">Jackets</span>
            </div>
            <div class="circles">
                <img src="images/iconheels.png" alt="">
                <span class="titlecircles">Heels</span>
            </div>
            <div class="circles">
                <img src="images/iconglasses.png" alt="">
                <span class="titlecircles">Glasses</span>
            </div>
        </div>
    </section>
    <?php
    require_once "cnx.php";
    $sql = "SELECT * FROM produits";
    $stm = $db->prepare($sql);
    $stm->execute();
    $result = $stm->fetchAll(PDO::FETCH_OBJ);




    ?>
    <section class="shop">
        <h2>Shop Now</h2>
        <div class="container_cards">
            <?php foreach ($result as $r) : ?>
                <div class="cardds">
                    <img src="<?php echo $r->image ?>" alt="Product Image">
                    <div class="foooter">
                        <span style="font-weight :bold;"><?php echo $r->nom_produit ?></span>
                        <p><?php echo $r->description ?></p>
                        <div class="images_container">
                            <span><?php echo $r->prix ?>DH</span>
                            <div>
                                <img src="images/hearticon.png" class="img">
                                <a href="add_panier.php?id_produit=<?php echo $r->id_produit ?>&client=<?php echo $_SESSION['id_client']; ?>">
                                    <img src="images/icons8-shop-30.png">
                                </a>

                            </div>

                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </section>



    <section class="contact">
        <div class="container_contact">
            <h2>Contact Us</h2>
            <form action="" class="form">
                <input type="text" placeholder="Name" class="inp"><br>
                <input type="text" placeholder="Email" class="inp"><br>
                <textarea placeholder="Message" class="inp"></textarea><br>
                <input type="submit" value="Send" class="send">
            </form>
        </div>
    </section>
    <footer>
        <div class="footer">

        </div>
    </footer>

</body>

</html>