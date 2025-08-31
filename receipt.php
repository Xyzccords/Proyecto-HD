<?php
require_once "connection.php";

if (!isset($_GET['id'])) {
    die("ID de comprobante no especificado.");
}

$id = intval($_GET['id']);

$sql = "SELECT pr.id, pr.issue_date, pr.expiration_date, pr.payment_date, pr.total_amount,
                CONCAT(s.first_name, ' ', s.last_name_father, ' ', s.last_name_mother) AS alumno,
                m.name AS plan,
                st.name AS estado
        FROM payment_receipt pr
        JOIN student s ON pr.student_id = s.id
        JOIN modality m ON pr.modality_id = m.id
        JOIN state st ON pr.state_id = st.id
        WHERE pr.id = $id
        LIMIT 1";

$result = $conn->query($sql);
if (!$result || $result->num_rows === 0) {
    die("Comprobante no encontrado.");
}
$data = $result->fetch_assoc();
$conn->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Comprobante de Pago</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container my-4">
    <div class="card shadow">
        <div class="card-header bg-dark text-white">
            Comprobante de Pago
        </div>
        <div class="card-body">
            <p><strong>Alumno:</strong> <?php echo $data['alumno']; ?></p>
            <p><strong>Plan / Servicio:</strong> <?php echo $data['plan']; ?></p>
            <p><strong>Fecha Emisión:</strong> <?php echo $data['issue_date']; ?></p>
            <p><strong>Fecha Vencimiento:</strong> <?php echo $data['expiration_date']; ?></p>
            <p><strong>Fecha Pago:</strong> <?php echo $data['payment_date']; ?></p>
            <p><strong>Monto:</strong> S/ <?php echo number_format($data['total_amount'], 2); ?></p>
            <p><strong>Estado:</strong> <span class="badge bg-success"><?php echo $data['estado']; ?></span></p>
        </div>
        <div class="card-footer text-end">
            <a href="index.php" class="btn btn-dark">Volver</a>
        </div>
    </div>
</body>
</html>
