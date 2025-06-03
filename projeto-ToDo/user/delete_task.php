<?php
require '../includes/db.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['task_id'])) {
    $task_id = $_POST['task_id'];
    
    // Verificar se a tarefa pertence ao usuário logado
    $check_sql = "SELECT user_id FROM tasks WHERE id = ?";
    $check_stmt = $conn->prepare($check_sql);
    $check_stmt->bind_param("i", $task_id);
    $check_stmt->execute();
    $result = $check_stmt->get_result();
    
    if ($result->num_rows > 0) {
        $task = $result->fetch_assoc();
        
        if ($task['user_id'] == $_SESSION['user_id']) {
            // Excluir a tarefa
            $delete_sql = "DELETE FROM tasks WHERE id = ?";
            $delete_stmt = $conn->prepare($delete_sql);
            $delete_stmt->bind_param("i", $task_id);
            
            if ($delete_stmt->execute()) {
                $_SESSION['delete_success'] = "Tarefa excluída com sucesso!"; // Usando uma chave diferente
                header("Location: dashboard.php?deleted=1");
                exit();
            } else {
                $_SESSION['delete_error'] = "Erro ao excluir tarefa: " . $conn->error;
                header("Location: dashboard.php");
                exit();
            }
        } else {
            $_SESSION['delete_error'] = "Você não tem permissão para excluir esta tarefa";
            header("Location: dashboard.php");
            exit();
        }
    } else {
        $_SESSION['delete_error'] = "Tarefa não encontrada";
        header("Location: dashboard.php");
        exit();
    }
} else {
    header("Location: dashboard.php");
    exit();
}
?>