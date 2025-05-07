<?php
require '../includes/db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['task_id'])) {
    $task_id = $_POST['task_id'];
    $user_id = $_SESSION['user_id']; // segurança
    $status = isset($_POST['status']) && $_POST['status'] === 'done' ? 'done' : 'open';

    $sql = "UPDATE tasks SET status = ? WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sii", $status, $task_id, $user_id);

    if ($stmt->execute()) {
        
        header('Location: dashboard.php');
        exit;
    } else {
        echo "Erro ao atualizar status.";
    }
} else {
    echo "Requisição inválida.";
}
