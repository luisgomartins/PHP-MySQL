<?php
require '../includes/db.php';
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['editarbtn'])) {
        $task_id = $_POST['task_id'];
        $title = $_POST['title'];
        $description = $_POST['description'];

        // Atualiza a tarefa no banco de dados
        $update_sql = "UPDATE tasks SET title = ?, description = ? WHERE id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("ssi", $title, $description, $task_id);
        if ($update_stmt->execute()) {
            header("Location: dashboard.php?editou=1");
        } else {
            echo "Erro ao atualizar tarefa: " . $conn->error;
        }
    }
}



// Verifica se há mensagem de sucesso na sessão
if (isset($_SESSION['success'])) {
    $sucess = " show";
    unset($_SESSION['success']);
}


$limit = 5; // Número de tarefas por página
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1; // Página atual
$offset = ($page - 1) * $limit; // Deslocamento para a consulta SQL

// Pega os filtros da URL
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : '';
$search = isset($_GET['search']) ? $_GET['search'] : '';
$status = isset($_GET['status']) ? $_GET['status'] : '';

// Inicia a consulta com a condição do usuário
$conditions = "WHERE user_id = ?";
$params = [$_SESSION['user_id']];

// Se houver um filtro de data
if ($start_date) {
    $conditions .= " AND data_criacao >= ?";
    $params[] = $start_date;
}
if ($end_date) {
    $conditions .= " AND data_criacao <= ?";
    $params[] = $end_date;
}

// Se houver um filtro de pesquisa
if ($search) {
    $conditions .= " AND (title LIKE ? OR description LIKE ?)";
    $params[] = "%" . $search . "%";
    $params[] = "%" . $search . "%";
}

// Se houver um filtro de status
if ($status) {
    $conditions .= " AND status = ?";
    $params[] = $status;
}

// Consulta para obter o total de tarefas com os filtros
$total_tasks_query = "SELECT COUNT(*) as total FROM tasks $conditions";
$stmt = $conn->prepare($total_tasks_query);
$stmt->bind_param(str_repeat("s", count($params)), ...$params); // Usar os parâmetros dinâmicos
$stmt->execute();
$total_result = $stmt->get_result();
$total_row = $total_result->fetch_assoc();
$total_tasks = $total_row['total'];
$total_pages = ceil($total_tasks / $limit); // Total de páginas

// Consulta para obter as tarefas com limite e deslocamento
$tasks_query = "SELECT * FROM tasks $conditions LIMIT ? OFFSET ?";
$params[] = $limit;
$params[] = $offset;
$stmt = $conn->prepare($tasks_query);
$stmt->bind_param(str_repeat("s", count($params) - 2) . "ii", ...$params); // Ajuste no número de parâmetros
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
    <?php if (isset($_SESSION['delete_success'])): ?>
        <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1100;">
            <div class="toast align-items-center text-white bg-success border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <?php echo $_SESSION['delete_success']; ?>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
        <?php unset($_SESSION['delete_success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['delete_error'])): ?>
        <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1100;">
            <div class="toast align-items-center text-white bg-danger border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <?php echo $_SESSION['delete_error']; ?>
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        </div>
        <?php unset($_SESSION['delete_error']); ?>
    <?php endif; ?>
    <nav class="navbar navbar-expand navbar-dark bg-dark shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">Dashboard</a>

            <div class="d-flex align-items-center ms-auto">
                <img src="https://icones.pro/wp-content/uploads/2021/02/icone-utilisateur.png" alt="Foto de Perfil" class="rounded-circle me-2 bg-white" width="40" height="40">

                <span class="me-3 fw-bold text-white"><?php echo $_SESSION['username'] ?></span>

                <a href="profile.php" class="btn btn-primary btn-sm me-2">
                    <i class="bi bi-gear"></i> Profile
                </a>

                <a href="logout.php?logout=1" class="btn btn-danger btn-sm">Logout</a>
            </div>
        </div>
    </nav>





    <a href="add_task.php">
        <button id="add-task-btn" class="btn p-3 text-bg-dark mx-auto btn-lg">

            <i class="bi bi-file-plus-fill"></i>
        </button>
    </a>
    <div class="container mt-4">
        <form method="GET" class="row g-5">
            <div class="col-md-3">
                <label for="start_date" class="form-label" style="color: white;">Data de Início</label>
                <input type="date" class="form-control" id="start_date" name="start_date" value="<?= isset($_GET['start_date']) ? $_GET['start_date'] : '' ?>">
            </div>
            <div class="col-md-3">
                <label for="end_date" class="form-label" style="color: white;">Data de Fim</label>
                <input type="date" class="form-control" id="end_date" name="end_date" value="<?= isset($_GET['end_date']) ? $_GET['end_date'] : '' ?>">
            </div>
            <div class="col-md-3">
                <label for="search" class="form-label" style="color: white;">Buscar</label>
                <input type="text" class="form-control" id="search" name="search" placeholder="Título ou descrição" value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>">
            </div>
            <div class="col-md-3">
                <label for="status" class="form-label" style="color: white;">Status</label>
                <select class="form-control" id="status" name="status">
                    <option value="">Selecione</option>
                    <option value="open" <?= isset($_GET['status']) && $_GET['status'] == 'open' ? 'selected' : '' ?>>Open</option>
                    <option value="done" <?= isset($_GET['status']) && $_GET['status'] == 'done' ? 'selected' : '' ?>>Done</option>
                </select>
            </div>
            <div class="col-12 mt-3 mx-auto">
                <button type="submit" class="btn btn-dark">Filtrar</button>
            </div>
        </form>
    </div>



    <div class="container mx-auto">
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
                <div class="card mx-2 <?php echo $color ?> position-relative" style="max-width: 15.2rem; top: 20px; height: 350px; z-index: 9999 ;  <?php echo $text_color ?>">
                    <div class="card-header"> <?= $task['data_criacao'] ?>
                        <form action="update_status.php" method="post" class="d-inline">
                            <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
                            <div class="form-check form-switch form-check-reverse">
                                <input class="form-check-input" type="checkbox" name="status" value="done"
                                    onchange="this.form.submit()" <?= $task['status'] === 'done' ? 'checked' : '' ?>>
                                <?php if ($task['status'] == 'done') {
                                    echo '<label class="form-check-label" for="switchCheckReverse"> Done </label>';
                                } else {
                                    echo '<label class="form-check-label" for="switchCheckReverse"> Open </label>';
                                } ?>
                                <label class="form-check-label" for="switchCheckReverse"></label>
                            </div>
                        </form>
                    </div>

                    <div class="card-body">

                        <h5 class="card-title"><?= $task['title'] ?></h5>
                        <p class="card-text"><?= $task['description'] ?></p>
                    </div>
                    <div class="mx-auto mb-2">

                        <!-- <a href="edit_task.php?id= <?= $task['id'] ?>" style="display: inline-block;"> -->
                        <button onclick="toggleEdit('editar<?php echo $task['id'] ?>')" class="btn btn-primary btn-sm me-1">
                            <i class="bi bi-pencil-fill"></i>
                        </button>

                        <!-- Por este formulário -->
                        <form action="delete_task.php" method="post" class="d-inline" onsubmit="return confirm('Tem certeza que deseja excluir esta tarefa?');">
                            <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
                            <button type="submit" class="btn btn-danger btn-sm">
                                <i class="bi bi-trash-fill"></i>
                            </button>
                        </form>

                        <?php if (isset($_SESSION['delete_error'])): ?>
                            <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1100;">
                                <div class="toast align-items-center text-white bg-danger border-0 show" role="alert" aria-live="assertive" aria-atomic="true">
                                    <div class="d-flex">
                                        <div class="toast-body">
                                            <?php echo $_SESSION['delete_error']; ?>
                                        </div>
                                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                                    </div>
                                </div>
                            </div>
                            <?php unset($_SESSION['delete_error']); ?>
                        <?php endif; ?>


                    </div>

                    <div id="editar<?php echo $task["id"] ?>" class="container mb-5 text-center bg-dark rounded-3 shadow p-3 mx-auto position-absolute top-0 start-0" style="display: none; max-width: 500px; height: 350px;">
                        <h1 class="titulo2 text-center text-light" style="font-size: 24px;">Editar Tarefa</h1>
                        <form method="post">
                            <input type="hidden" name="task_id" value="<?= $task['id'] ?>">
                            <div class="form-floating">
                                <textarea name="title" class="form-control mt-3" placeholder="title" id="floatingTextarea" value="<?= $task['title'] ?>"></textarea>
                                <label for="floatingTextarea">Title</label>
                            </div>
                            <div class="form-floating">
                                <textarea name="description" class="form-control mt-3 mb-3" placeholder="description" id="floatingTextarea2" style="height: 150px" value="<?= $task['description'] ?>"></textarea>
                                <label for=" floatingTextarea2">Description</label>
                            </div>
                            <button name="editarbtn" type="submit" class="btn btn-danger btn-sm">
                                <i class="bi bi-pencil-square"></i>
                            </button>
                        </form>
                    </div>
                </div>

            <?php endwhile; ?>
        </div>
    </div>

    <div class="container mt-4">
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center" style="margin-top: 40px;">
                <?php if ($page > 1): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $page - 1 ?>">
                            <i class="bi bi-caret-left-fill"></i>
                        </a>
                    </li>
                <?php endif; ?>

                <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?= $i == $page ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                <?php endfor; ?>

                <?php if ($page < $total_pages): ?>
                    <li class="page-item">
                        <a class="page-link" href="?page=<?= $page + 1 ?>">
                            <i class="bi bi-caret-right-fill"></i>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>

    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2025 To Do. Todos os direitos reservados.</p>
        <p><a href="" class="text-white" style="text-decoration: none;">Contato </a><a href="" class="text-white" style="text-decoration: none;">| Sobre o projeto</a></p>

    </footer>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous">

    </script>
    <script>
        function toggleEdit(id) {
            const editElement = document.getElementById(id);
            if (editElement.style.display === "none" || editElement.style.display === "") {
                editElement.style.display = "block";
            } else {
                editElement.style.display = "none";
            }
        }
    </script>
    <script>
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                if (!confirm('Tem certeza que deseja excluir esta tarefa?')) {
                    e.preventDefault();
                }
            });
        });
    </script>

</body>

</html>