<?php
include("connection.php");

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    // Borrar el estudiante
    $stmt = $conn->prepare("DELETE FROM student WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        header("Location: student.php?msg=deleted");
        exit();
    } else {
        echo "Error al eliminar: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>
