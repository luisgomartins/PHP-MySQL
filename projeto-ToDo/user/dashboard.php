<?php
require '../includes/db.php';
session_start();
if (isset($_SESSION['success'])) {
    $sucess = " show";
    unset($_SESSION['success']);
}
$user_id = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT * FROM tasks WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$tasks = $stmt->get_result();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <?php if (!empty($sucess)) : ?>
        <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1100;">
            <div class="toast align-items-center text-white bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <?php echo "Welcome " . $_SESSION['username'] . " 🚀"; ?>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <nav class="navbar navbar-expand navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">Dashboard</a>
            <a class="navbar-brand" href="report.php">Graphics</a>

            <div class="d-flex align-items-center ms-auto">
                <!-- Foto do perfil -->
                <img src="https://icones.pro/wp-content/uploads/2021/02/icone-utilisateur.png" alt="Foto de Perfil" class="rounded-circle me-2 bg-white" width="40" height="40">

                <!-- Nome do usuário -->
                <span class="me-3 fw-bold text-white"><?php echo $_SESSION['username'] ?></span>

                <!-- Botão de configurações -->
                <a href="perfil.php" class="btn btn-primary btn-sm me-2">
                    <i class="bi bi-gear"></i> Configurações
                </a>

                <!-- Botão de logout -->
                <a href="logout.php?logout=1" class="btn btn-danger btn-sm">Logout</a>

            </div>
        </div>
    </nav>






    <button id="add-task-btn" class="btn p-3 text-bg-dark mx-auto btn-lg">
        <i class="bi bi-file-plus-fill"></i>
    </button>
    <div class="container">
        <div class="row g-1 mt-3">
            <?php while ($task = $tasks->fetch_assoc()): ?>
                <?php if ($task['status'] == 'open') {
                    $color = " bg-dark";
                    $text_color = " color: white";
                    $button_color = " bi-bookmark-check-fill";
                    $button_color2 = " btn-success";
                } elseif ($task['status'] == 'done') {
                    $color = " bg-success";
                    $text_color = " color: white";
                    $button_color = " bi bi-bookmark-x-fill";
                    $button_color2 = " btn-danger";
                } ?>
                <div class="card mt-4 mx-auto <?php echo $color ?>" style="max-width: 18rem; <?php echo $text_color ?>">
                    <div class="card-header">Data
                    </div>

                    <div class="card-body">
                        <h5 class="card-title"><?= $task['title'] ?></h5>
                        <p class="card-text"><?= $task['description'] ?></p>
                    </div>
                    <div class="mx-auto mb-2">

                        <a href="edit_task.php?id=<?= $task['id'] ?>" style="display: inline-block;">
                            <button class="btn btn-primary btn-sm me-1">
                                <i class="bi bi-pencil-fill"></i>
                            </button>
                        </a>
                        <button class="btn btn-danger btn-sm">
                            <i class="bi bi-trash-fill"></i>
                        </button>
                            <button class="btn btn-primary btn-sm m-1 <?php echo $button_color2 ?>">
                                <i class="<?php echo $button_color ?>"></i>
                            </button>

                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
    </div>
    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2025 To Do. Todos os direitos reservados.</p>
        <p><a href="" class="text-white" style="text-decoration: none;">Contato </a><a href="" class="text-white" style="text-decoration: none;">| Sobre o projeto</a></p>

    </footer>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous">
        
    </script>

</body>

</html>