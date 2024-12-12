<?php
 session_start(); 
require 'includes/db_connection.php';

if (isset($_SESSION['user_id']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $coin_id = $_POST['coin_id'];
    $sell_amount = $_POST['sell_amount'];
    $current_amount = $_POST['current_amount'];

    // Controleer of de verkoophoeveelheid geldig is
    if ($sell_amount > 0 && $sell_amount <= $current_amount) {
        $remaining_amount = $current_amount - $sell_amount;

        if ($remaining_amount > 0) {
            // Update de hoeveelheid als er nog coins overblijven
            $stmt = $connection->prepare("UPDATE purchased_coins SET amount = ? WHERE id = ? AND user_id = ?");
            $stmt->bind_param("dii", $remaining_amount, $coin_id, $user_id);
        } else {
            // Verwijder de coin als alles verkocht is
            $stmt = $connection->prepare("DELETE FROM purchased_coins WHERE id = ? AND user_id = ?");
            $stmt->bind_param("ii", $coin_id, $user_id);
        }

        if ($stmt->execute()) {
            header("Location: wallet.php");
            exit();
        } else {
            echo "Er is een fout opgetreden bij het verwerken van de verkoop.";
        }

        $stmt->close();
    } else {
        echo "Ongeldige verkoophoeveelheid.";
    }
} else {
    header("Location: login.php");
    exit();
}
?>
