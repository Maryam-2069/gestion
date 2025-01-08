<?php 
require_once "cnx.php";
session_start();
if (!isset($_SESSION['id_client'])) {
    header("Location:login.php");
}
$id_client = $_SESSION['id_client'];
$sql = "SELECT commandes.id_commande, commandes.date_commande, commandes.total, commandes.status, clients.nom_client
        FROM commandes
        JOIN clients ON commandes.id_client = clients.id_client
        WHERE commandes.id_client = ?";
$stm = $db->prepare($sql);
$stm->execute([$id_client]);
$orders = $stm->fetchAll(PDO::FETCH_OBJ);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order History</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
         :root {
            --custom-color: #C37463;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen p-6">

    <div class="container mx-auto">
        <h1 class="text-3xl font-bold text-gray-800 text-center mb-8">Your Order History</h1>

        <div class="overflow-x-auto shadow-lg rounded-lg">
            <table class="table-auto w-full bg-white rounded-lg">
                <thead class="bg-[#C37463] text-white">
                    <tr>
                        <th class="px-4 py-2">Order ID</th>
                        <th class="px-4 py-2">Client Name</th>
                        <th class="px-4 py-2">Date</th>
                        <th class="px-4 py-2">Total</th>
                        <th class="px-4 py-2">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    <?php foreach ($orders as $order) : ?>
                        <tr class="text-gray-700 text-center">
                            <td class="px-4 py-2"><?= $order->id_commande; ?></td>
                            <td class="px-4 py-2"><?= $order->nom_client; ?></td>
                            <td class="px-4 py-2"><?= $order->date_commande; ?></td>
                            <td class="px-4 py-2"><?= $order->total; ?> DH</td>
                            <td class="px-4 py-2">
                                <span class="px-2 py-1 rounded-full text-sm font-medium
                                    <?php echo $order->status === 'pending' ? 'bg-[#C37463] text-white' : ($order->status === 'delivered' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'); ?>">
                                    <?php echo $order->status; ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="flex justify-center items-center mt-8">
    <a href="profile_client.php" class="bg-[var(--custom-color)] text-white px-4 py-2 rounded-lg hover:bg-opacity-90 transition duration-300 ease-in-out shadow-lg">
        Go Back
    </a>
</div>
</body>
</html>
