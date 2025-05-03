<?php
session_start();
if (isset($_SESSION['register'])) {
    $register = " show";
    unset($_SESSION['register']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToDo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="styles2.css">
</head>

<body class="bg-dark">
    <?php if (!empty($register)) : ?>
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
                <img src="https://icones.pro/wp-content/uploads/2021/02/icone-utilisateur.png" alt="Foto de Perfil" class="rounded-circle me-2 bg-white" width="40" height="40">

                <span class="me-3 fw-bold text-white"><?php echo $_SESSION['username'] ?></span>

                <a href="perfil.php" class="btn btn-primary btn-sm me-2">
                    <i class="bi bi-gear"></i> Configurações
                </a>

                <a href="logout.php" class="btn btn-danger btn-sm">Logout</a>
            </div>
        </div>
    </nav>


    <div class="container mt-5 mx-auto">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <h1 class="text-center text-white">Perfil</h1>
            <div class="text-center mt-4">
                <img src="https://icones.pro/wp-content/uploads/2021/02/icone-utilisateur.png" alt="Foto de Perfil" class="rounded-circle bg-white" width="250" height="250">
                <div class="container mx-auto mt-2">
                    <button type="button" class="btn btn-dark btn-sm" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Update Profile Photo
                    </button>
                </div>

            </div>
            <div class="container mt-5 mx-auto" style="width: 400px;">
                <div class="form-floating m-auto">
                    <input type="text" class="form-control" id="inputusername" name="inputusername" placeholder="Username" required>
                    <label for="inputusername">Name</label>
                </div>
            </div>
        </form>
    </div>










    <footer class="bg-dark text-white text-center py-3">
        <p>&copy; 2025 To Do. Todos os direitos reservados.</p>
        <p><a href="" class="text-white" style="text-decoration: none;">Contato </a><a href="" class="text-white" style="text-decoration: none;">| Sobre o projeto</a></p>

    </footer>



</body>

</html>











<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>

</html>