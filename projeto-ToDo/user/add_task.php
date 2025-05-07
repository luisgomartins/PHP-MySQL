<?php
require '../includes/db.php';
session_start();
$titulo = $descricao = "";
$erroTitulo = $erroDescricao = "";

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>

<body>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">

        <div class="container mt-5 mb-5 text-center bg-light rounded-3 shadow p-3 mx-auto" style="max-width: 500px;">
            <h1 class="titulo2 text-center">Adicionar Tarefa</h1>
            <div class="form-floating">
                <textarea class="form-control" placeholder="title" id="floatingTextarea"></textarea>
                <label for="floatingTextarea">Title</label>
            </div>
            <div class="form-floating">
                <textarea class="form-control" placeholder="description" id="floatingTextarea2" style="height: 100px"></textarea>
                <label for="floatingTextarea2">Description</label>
            </div>
        </div>
        <button>
            <a href="dashboard.php" class="btn btn-primary btn-lg" type="submit">Adicionar</a>
        </button>

    </form>







    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
</body>

</html>