<?php
include("connection.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $result = $conn->query("SELECT * FROM student WHERE id = $id");
    $student = $result->fetch_assoc();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $conn->prepare("CALL updateStudent(?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
        "issssii",
        $_POST['id'],
        $_POST['first_name'],
        $_POST['last_name_father'],
        $_POST['last_name_mother'],
        $_POST['dni'],
        $_POST['phone_number'],
        $_POST['modality_id']
    );

    if ($stmt->execute()) {
        header("Location: student.php?msg=updated");
        exit();
    } else {
        echo "Error al actualizar: " . $stmt->error;
    }
}

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Alumno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h3>Editar Alumno</h3>
    <form method="POST">
        <input type="hidden" name="id" value="<?php echo $student['id']; ?>">

        <div class="mb-3">
            <label class="form-label">Nombre</label>
            <input type="text" name="first_name" class="form-control" value="<?php echo $student['first_name']; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Apellido Paterno</label>
            <input type="text" name="last_name_father" class="form-control" value="<?php echo $student['last_name_father']; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Apellido Materno</label>
            <input type="text" name="last_name_mother" class="form-control" value="<?php echo $student['last_name_mother']; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">DNI</label>
            <input type="text" name="dni" class="form-control" maxlength="8" value="<?php echo $student['dni']; ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Teléfono</label>
            <input type="text" name="phone_number" class="form-control" value="<?php echo $student['phone_number']; ?>">
        </div>

        <div class="mb-3">
            <label class="form-label">Plan</label>
            <select name="modality_id" class="form-select" required>
            <?php
            $plans = $conn->query("SELECT * FROM modality");
                while($p = $plans->fetch_assoc()) {
                    $selected = ($student['modality_id'] == $p['id']) ? "selected" : "";
                    echo "<option value='{$p['id']}' $selected>{$p['name']}</option>";
                }
            ?>
            </select>
        </div>

        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="student.php" class="btn btn-secondary">Cancelar</a>
    </form>
</div>

</body>
</html>
