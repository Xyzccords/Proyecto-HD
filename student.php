<?php
include("connection.php"); 
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Gestión de Alumnos | Academia de Marinera</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

  <nav class="navbar navbar-dark bg-dark mb-4">
    <div class="container-fluid">
      <a href="index.php" class="navbar-brand">
        <i class="bi bi-arrow-left"></i> Volver
      </a>
      <span class="navbar-brand mb-0 h1">Administración de Alumnos</span>
    </div>
  </nav>

  <div class="container">

    <?php if (isset($_GET['msg'])): ?>
      <?php
        $msg = $_GET['msg'];
        $alertClass = 'alert-success';
        $text = 'Operación correcta.';
        if ($msg === 'deleted') { $alertClass = 'alert-warning'; $text = 'Alumno eliminado correctamente.'; }
        if ($msg === 'updated') { $alertClass = 'alert-success'; $text = 'Alumno actualizado correctamente.'; }
        if ($msg === 'created') { $alertClass = 'alert-success'; $text = 'Alumno creado correctamente.'; }
      ?>
      <div class="alert <?php echo $alertClass; ?> alert-dismissible fade show" role="alert">
        <?php echo htmlspecialchars($text); ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-3">
      <h4><i class = "bi bi-people-fill">Lista Actualizada de Alumnos</i></h4>
      <div>
        <button class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#modalAlumno">+ Agregar Alumno</button>
      </div>
    </div>

    <!-- Barra de búsqueda -->
    <div class="row mb-3">
      <div class="col-md-8">
        <input id="filtroAlumnos" class="form-control" placeholder="Buscar por nombre, DNI, teléfono o plan...">
      </div>
      <div class="col-md-4">
        <div class="d-flex gap-2">
          <button id="btnBuscar" class="btn btn-primary"><i class="bi bi-search"></i> Buscar</button>
          <button id="btnLimpiar" class="btn btn-outline-secondary"><i class="bi bi-x-circle"></i> Limpiar</button>
        </div>
      </div>
    </div>

    <div class="card shadow-sm">
      <div class="card-body">
        <table class="table table-striped table-hover">
          <thead>
            <tr>
              <th>Nombre</th>
              <th>DNI</th>
              <th>Teléfono</th>
              <th>Plan</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody id="tablaAlumnosBody">
            <?php
              $sql = "SELECT s.id, s.first_name, s.last_name_father, s.last_name_mother, 
                              s.dni, s.phone_number, s.modality_id, m.name AS plan
                      FROM student s
                      LEFT JOIN modality m ON s.modality_id = m.id
                      ORDER BY s.first_name, s.last_name_father";
              $result = $conn->query($sql);

              if ($result && $result->num_rows > 0) {
                  while ($row = $result->fetch_assoc()) {
                      $id = (int)$row['id'];
                      $full = htmlspecialchars(trim($row['first_name'] . ' ' . $row['last_name_father'] . ' ' . $row['last_name_mother']));
                      $dni = htmlspecialchars($row['dni']);
                      $phone = htmlspecialchars($row['phone_number']);
                      $plan = htmlspecialchars($row['plan'] ?? '-');
                      ?>
                      <tr>
                        <td><?php echo $full; ?></td>
                        <td><?php echo $dni; ?></td>
                        <td><?php echo $phone; ?></td>
                        <td><?php echo $plan; ?></td>
                        <td>
                          <!-- Editar -->
                          <a href="student_edit.php?id=<?php echo $id; ?>" class="btn btn-sm btn-primary" title="Editar">
                            <i class="bi bi-pencil-square"></i>
                          </a>

                          <!-- Eliminar -->
                          <a href="student_delete.php?id=<?php echo $id; ?>"
                              class="btn btn-sm btn-danger"
                              title="Eliminar"
                              onclick="return confirm('¿Seguro que deseas eliminar este alumno?');">
                            <i class="bi bi-trash"></i>
                          </a>
                        </td>
                      </tr>
                      <?php
                  }
              } else {
                  echo "<tr><td colspan='5' class='text-center'>No hay alumnos registrados</td></tr>";
              }
            ?>
          </tbody>
        </table>
      </div>
    </div>

    <div class="modal fade" id="modalAlumno" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog">
        <form class="modal-content" method="POST" action="student_add.php" novalidate>
          <div class="modal-header">
            <h5 class="modal-title text-primary">Registrar Nuevo Alumno</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label class="form-label">Nombre</label>
              <input type="text" name="first_name" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Apellido Paterno</label>
              <input type="text" name="last_name_father" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Apellido Materno</label>
              <input type="text" name="last_name_mother" class="form-control" required>
            </div>
            <div class="mb-3">
              <label class="form-label">DNI</label>
              <input type="text" name="dni" class="form-control" maxlength="8" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Teléfono</label>
              <input type="text" name="phone_number" class="form-control">
            </div>
            <div class="mb-3">
              <label class="form-label">Tipo de plan</label>
              <select name="modality_id" class="form-select" required>
                <option value="">Selecciona un plan</option>
                <?php
                  $plans = $conn->query("SELECT id, name FROM modality ORDER BY id");
                  if ($plans) {
                    while($p = $plans->fetch_assoc()) {
                      $pid = (int)$p['id'];
                      $pname = htmlspecialchars($p['name']);
                      echo "<option value='{$pid}'>{$pname}</option>";
                    }
                  }
                ?>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-success">Guardar Alumno</button>
          </div>
        </form>
      </div>
    </div>

  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <script src = "js/search.js"></script>
</body>
</html>

<?php
$conn->close();
?>
