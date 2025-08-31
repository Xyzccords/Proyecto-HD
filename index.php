<?php
require_once "functions.php";

// Ejecutar el procedimiento almacenado para actualizar vencidos
$conn->query("CALL UpdateExpiredPayments()");

$result = getPagos($conn);
$resumen = getResumen($conn);
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Academia de Marinera - Sistema de Pagos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

  <!-- Encabezado -->
  <nav class="navbar navbar-dark bg-dark mb-4">
    <div class="container-fluid">
      <a href="presentation.html" class="navbar-brand">
        <i class="bi bi-arrow-left"></i> Volver
      </a>
      <span class="navbar-brand mb-0 h1">Sistema de gestión de pagos</span>
    </div>
  </nav>

  <div class="container">
    <!-- Resumen financiero -->
    <div class="row text-center mb-4">
      <div class="col-md-4">
          <div class="card shadow-sm">
              <div class="card-body">
                  <h6 class="text-muted">Deudas Pendientes</h6>
                  <h3 class="text-danger">S/ <?php echo number_format($resumen['pendientes'], 2); ?></h3>
              </div>
          </div>
      </div>
      <div class="col-md-4">
          <div class="card shadow-sm">
              <div class="card-body">
                  <h6 class="text-muted">Alumnos con Deuda Pendiente</h6>
                  <h3 class="text-primary"><?php echo $resumen['alumnosPendientes']; ?></h3>
              </div>
          </div>
      </div>
      <div class="col-md-4">
          <div class="card shadow-sm">
              <div class="card-body">
                  <h6 class="text-muted">Alumnos con Deuda Vencida</h6>
                  <h3 class="text-warning"><?php echo $resumen['alumnosVencidos']; ?></h3>
              </div>
          </div>
    </div>
  </div>


    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4>Gestión de Pagos</h4>
        <a href="student.php" class="btn btn-dark">+ Gestión de Alumnos</a>
    </div>

    <!-- Tabla de pagos -->
    <div class="card shadow-sm mb-4">
      <div class="card-header bg-dark text-white">
        Gestión de Pagos
      </div>
      <div class="card-body">
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th>Alumno</th>
              <th>Plan / Servicio</th>
              <th>Fecha Emisión</th>
              <th>Fecha Vencimiento</th>
              <th>Fecha Pago</th>
              <th>Estado</th>
              <th>Acción</th>
            </tr>
          </thead>
          <tbody>
            <?php if ($result && $result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                      <td><?php echo $row['alumno']; ?></td>
                      <td><?php echo $row['plan']; ?></td>
                      <td><?php echo $row['issue_date']; ?></td>
                      <td><?php echo $row['expiration_date']; ?></td>
                      <td>
                        <?php echo $row['payment_date'] ? $row['payment_date'] : '<span class="text-muted">—</span>'; ?>
                      </td>
                      <td>
                        <?php if ($row['estado'] === 'PAGADO'): ?>
                            <span class="badge bg-success">Pagado</span>
                        <?php elseif ($row['estado'] === 'PENDIENTE'): ?>
                            <span class="badge bg-danger">Pendiente</span>
                        <?php else: ?>
                            <span class="badge bg-warning">Vencido</span>
                        <?php endif; ?>
                      </td>
                      <td>
                        <?php if ($row['estado'] === 'PAGADO'): ?>
                            <a href="receipt.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-secondary">Ver comprobante</a>
                        <?php else: ?>
                            <a href="register_payment.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-primary">Registrar pago</a>
                        <?php endif; ?>
                      </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="7" class="text-center">No hay pagos registrados.</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php $conn->close(); ?>
