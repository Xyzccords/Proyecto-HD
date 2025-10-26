<?php
require_once "connection.php";

// Validar ID
if (!isset($_GET['id'])) {
    die("ID de pago no especificado.");
}

$id = intval($_GET['id']);

// Obtener datos del pago
$sql = "SELECT pr.id, pr.issue_date, pr.expiration_date, pr.payment_date, pr.total_amount,
                CONCAT(s.first_name, ' ', s.last_name_father, ' ', s.last_name_mother) AS alumno,
                m.name AS plan,
                st.id AS estado_id, st.name AS estado
        FROM payment_receipt pr
        JOIN student s ON pr.student_id = s.id
        JOIN modality m ON pr.modality_id = m.id
        JOIN state st ON pr.state_id = st.id
        WHERE pr.id = $id
        LIMIT 1";

$result = $conn->query($sql);
if (!$result || $result->num_rows === 0) {
    die("Pago no encontrado.");
}
$data = $result->fetch_assoc();

// Obtener lista de estados
$estados = $conn->query("SELECT id, name FROM state");
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Pago</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container my-4">
    <h3>Registrar Pago</h3>
    <div class="card shadow">
        <div class="card-body">
            <form method="post" action="save_payment.php">
                <input type="hidden" name="id" value="<?php echo $data['id']; ?>">

                <p><strong>Alumno:</strong> <?php echo $data['alumno']; ?></p>
                <p><strong>Plan:</strong> <?php echo $data['plan']; ?></p>
                <p><strong>Monto:</strong> S/ <?php echo number_format($data['total_amount'], 2); ?></p>

                <div class="mb-3">
                    <label for="estado" class="form-label">Estado del pago</label>
                    <select name="estado_id" id="estado" class="form-select" required>
                        <?php while ($row = $estados->fetch_assoc()): ?>
                            <option value="<?php echo $row['id']; ?>" 
                                <?php echo ($row['id'] == $data['estado_id']) ? 'selected' : ''; ?>>
                                <?php echo $row['name']; ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="fecha_pago" class="form-label">Fecha de pago</label>
                    <input type="date" class="form-control" id="fecha_pago" name="payment_date"
                        value="<?php echo $data['payment_date'] ?? date('Y-m-d'); ?>">
                </div>

                <button type="submit" class="btn btn-primary">Guardar</button>
                <a href="index.php" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</body>
</html>
