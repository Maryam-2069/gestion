<?php 
session_start();
require_once 'cnx.php';
$total = $_GET['total'];
if(!isset($_SESSION['id_client'])){
    header("Location:login.php");
}
$id_client = $_SESSION['id_client'];
$sql = "SELECT * FROM clients where id_client = ?";
$stmt = $db->prepare($sql);
$stmt->execute([$id_client]);
$result = $stmt->fetch(PDO::FETCH_OBJ);


if(isset($_POST['submit'])){
$name = $_POST['name'];
$adresse = $_POST['address'];
$email = $_POST['email'];
$tel = $_POST['tel'];
if(!empty($name) && !empty($adresse) && !empty($email) && !empty($tel)){
    $sql = "UPDATE clients SET nom_client = ?, email = ?, adresse = ? ,telephone = ? where id_client = ?";
    $stmt = $db->prepare($sql);
    $stmt->execute([$name, $email, $adresse, $tel, $id_client]);

    if($stmt){
        $date_commande = date('Y-m-d H:i:s');
        $sql = "INSERT INTO commandes (id_client , date_commande , total ) values (?,?,?)";
        $stmt = $db->prepare($sql);
        $stmt->execute([$id_client, $date_commande, $total]);
         header("Location:home.php");
    }
}
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Form</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
   <link rel="stylesheet" href="profile.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h1>Checkout</h1>
            <form action="" method="post">
                <div class="mb-4">
                    <label for="name" class="form-label">Name:</label>
                    <input type="text" name="name" value="<?php echo $result->nom_client ?>" class="form-control" placeholder="Enter your full name" required>
                </div>
                <div class="mb-4">
                    <label for="email" class="form-label">Email:</label>
                    <input type="email" name="email"  value="<?php echo $result->email ?>"  class="form-control" placeholder="Enter your email address" required>
                </div>
                <div class="mb-4">
                    <label for="address" class="form-label">Address:</label>
                    <input type="text" name="address"   value="<?php echo $result->adresse ?>" class="form-control" placeholder="Enter your address" required>
                </div>
                <div class="mb-4">
                    <label for="address" class="form-label">Telephone:</label>
                    <input type="text" name="tel" class="form-control"  value="<?php echo $result->telephone ?>" placeholder="Enter your address" required>
                </div>
                <div class="mb-4">
                    <label for="payment" class="form-label">Payment Method:</label>
                    <select name="payment" class="form-select" required>
                        <option value="" disabled selected>Select a payment method</option>
                        <option value="apple">Apple Pay</option>
                        <option value="card">Card</option>
                        <option value="paypal">PayPal</option>
                    </select>
                </div>
                <button type="submit" class="btn" name="submit">Place Order</button>
            </form>
        </div>
    </div>
</body>
</html>
