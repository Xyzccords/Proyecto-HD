<?php
require_once "connection.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $estado_id = intval($_POST['estado_id']);
    $fecha_pago = !empty($_POST['payment_date']) ? "'".$_POST['payment_date']."'" : "NULL";

    $sql = "UPDATE payment_receipt 
            SET state_id = $estado_id, 
                payment_date = $fecha_pago
            WHERE id = $id";

    if ($conn->query($sql) === TRUE) {
        header("Location: receipt.php?id=$id");
        exit;
    } else {
        echo "Error al actualizar el pago: " . $conn->error;
    }
}
$conn->close();
?>
