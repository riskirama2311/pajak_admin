<?php
include('../includes/db_connect.php');

$id = $_GET['id'];

// Hapus data konsultasi terkait klien ini
$sql_delete_consultations = "DELETE FROM consultation WHERE client_id = $id";
$conn->query($sql_delete_consultations);

// Hapus data klien
$sql_delete_client = "DELETE FROM client WHERE id = $id";
if ($conn->query($sql_delete_client) === TRUE) {
    header('Location: clients.php');
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
