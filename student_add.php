<?php 
include("connection.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $stmt = $conn->prepare("CALL registerStudent(?, ?, ?, ?, ?, ?)");
    $stmt->bind_param(
        "sssssi",
        $_POST['first_name'],
        $_POST['last_name_father'],
        $_POST['last_name_mother'],
        $_POST['dni'],
        $_POST['phone_number'],
        $_POST['modality_id']
    );

    if ($stmt->execute()) {
        header("Location: student.php?msg=created");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close();
?>

