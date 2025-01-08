<?php
session_start();
require_once 'cnx.php';

$sql = "SELECT commandes.id_commande, commandes.date_commande, commandes.total, commandes.status, clients.nom_client
        FROM commandes
        JOIN clients ON commandes.id_client = clients.id_client";
$stmt = $db->prepare($sql);
$stmt->execute();
$orders = $stmt->fetchAll(PDO::FETCH_OBJ);

if (isset($_POST['update_status'])) {
    $status = $_POST['status'];
    $id_commande = $_POST['id_commande'];

    $sql = "UPDATE commandes SET status = ? WHERE id_commande = ?";
    $stm = $db->prepare($sql);
    $stm->execute([$status, $id_commande]);

    header("Location: admin_orders.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Orders</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        :root {
            --custom-color: #C37463;
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen p-6">
<div class="container mx-auto">
    <h1 class="text-3xl font-bold text-gray-800 text-center mb-8">Manage Orders</h1>

    <div class="overflow-x-auto shadow-lg rounded-lg">
        <table class="table-auto w-full bg-white rounded-lg">
            <thead style="background-color: var(--custom-color);" class="text-white">
            <tr>
                <th class="px-4 py-2">Order ID</th>
                <th class="px-4 py-2">Client Name</th>
                <th class="px-4 py-2">Date</th>
                <th class="px-4 py-2">Total</th>
                <th class="px-4 py-2">Status</th>
                <th class="px-4 py-2">Action</th>
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
                            <?= $order->status === 'pending' ? 'bg-yellow-100 text-yellow-700' : ($order->status === 'delivered' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700'); ?>">
                            <?= $order->status; ?>
                        </span>
                    </td>
                    <td class="px-4 py-2">
                        <form method="POST" class="flex justify-center items-center gap-2">
                            <input type="hidden" name="id_commande" value="<?= $order->id_commande; ?>">
                            <select name="status" class="rounded-lg border-gray-300 text-gray-700">
                                <option value="pending" <?php echo $order->status === 'pending' ? 'selected' : ''; ?>>Pending</option>
                                <option value="delivered" <?php echo $order->status === 'delivered' ? 'selected' : ''; ?>>Delivered</option>
                                <option value="canceled" <?php echo $order->status === 'canceled' ? 'selected' : ''; ?>>Canceled</option>
                            </select>
                            <button type="submit" name="update_status" class="bg-[var(--custom-color)] text-white px-3 py-1 rounded-lg hover:bg-opacity-90">
                                Update
                            </button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    
</div>
<div class="flex justify-center items-center mt-8">
    <a href="admin_client.php" class="bg-[var(--custom-color)] text-white px-4 py-2 rounded-lg hover:bg-opacity-90 transition duration-300 ease-in-out shadow-lg">
        Go Back
    </a>
</div>

</body>
</html>
