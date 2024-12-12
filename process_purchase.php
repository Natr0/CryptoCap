<?php
session_start();
require 'includes/db_connection.php';

if (isset($_SESSION['user_id']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $coin_name = $_POST['coin_name'];
    $coin_symbol = $_POST['coin_symbol'];
    $amount = $_POST['amount'];
    $purchase_price = $_POST['coin_price'];

    // Bereken de totale kosten van de aankoop
    $total_cost = $amount * $purchase_price;

    // Sla de aankoop op in de database
    $stmt = $connection->prepare("INSERT INTO purchased_coins (user_id, coin_name, coin_symbol, amount, purchase_price) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("issdd", $user_id, $coin_name, $coin_symbol, $amount, $total_cost);

    if ($stmt->execute()) {
        header("Location: wallet.php");
        exit();
    } else {
        echo "Er is een fout opgetreden bij het verwerken van de aankoop.";
    }

    $stmt->close();
} else {
    header("Location: login.php");
    exit();
}
?>
