<?php
require_once "connection.php"; 

// Función para obtener pagos
function getPagos($conn) {
    $sql = "SELECT pr.id, 
                    CONCAT(s.first_name, ' ', s.last_name_father, ' ', s.last_name_mother) AS alumno,
                    m.name AS plan,
                    pr.issue_date,
                    pr.expiration_date,
                    pr.payment_date,
                    pr.total_amount,
                    st.name AS estado
            FROM payment_receipt pr
            JOIN student s ON pr.student_id = s.id
            JOIN modality m ON pr.modality_id = m.id
            JOIN `state` st ON pr.state_id = st.id
            ORDER BY pr.issue_date DESC";
    return $conn->query($sql);
}

// Función para obtener el resumen financiero
function getResumen($conn) {
    $totalIngresos = 0;
    $totalPendientes = 0;
    $alumnosPendientes = 0;
    $alumnosVencidos = 0;

    $sqlResumen = "SELECT st.name AS estado, 
                            SUM(pr.total_amount) as total, 
                            COUNT(DISTINCT pr.student_id) as alumnos 
                    FROM payment_receipt pr
                    JOIN state st ON pr.state_id = st.id
                    GROUP BY st.name";
    $resumen = $conn->query($sqlResumen);

    if ($resumen && $resumen->num_rows > 0) {
        while ($row = $resumen->fetch_assoc()) {
            if ($row['estado'] === 'PAGADO') {
                $totalIngresos += $row['total'];
            } elseif ($row['estado'] === 'PENDIENTE') {
                $totalPendientes += $row['total'];
                $alumnosPendientes += $row['alumnos'];
            } elseif ($row['estado'] === 'VENCIDO') {
                $totalPendientes += $row['total'];
                $alumnosVencidos += $row['alumnos'];
            }
        }
    }

    return [
        "ingresos" => $totalIngresos,
        "pendientes" => $totalPendientes,
        "alumnosPendientes" => $alumnosPendientes,
        "alumnosVencidos" => $alumnosVencidos
    ];
}
?>
