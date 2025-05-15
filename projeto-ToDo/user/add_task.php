<?php
require '../includes/db.php';
session_start();
$titulo = $descricao = "";
$erroTitulo = $erroDescricao = "";

// Verifica o post
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Variaveis de preenchimento do formulário
    $titulo = trim(string: $_POST['titulo']);
    $descricao = trim(string: $_POST['descricao']);

    // Verifica se o título está vazios
    if (empty($titulo)){
        $erroTitulo = "O título é obrigatório.";
    }
    // Verifica se a descrição está vazia
    if (empty($descricao)){
        $erroDescricao = "A descrição é obrigatória.";
    }
    // Verifica se as variaveis de erro estão vazias, se sim então ele para inserir pro banco de dados
    if (empty($erroTitulo) && empty($erroDescricao)) {
        // id do usuário logado
        $user_id = $_SESSION['user_id'];
        // Comando SQL para inserir a tarefa
        // O status padrão é 'open' e a data de criação é a data atual
        $sql = "INSERT INTO tasks (user_id, title, description, status, data_criacao) VALUES (?, ?, ?, 'open', NOW())";
        //
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iss", $user_id, $titulo, $descricao);
        // Se a execução do comando for bem sucedida, redireciona para o dashboard
        if ($stmt->execute()) {
            header("Location: dashboard.php");
            exit();
        } else {
            echo "Erro ao adicionar tarefa: " . $conn->error;
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
</head>

<body>

    <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        
        <div class="container mt-5 mb-5 text-center bg-light rounded-3 shadow p-3 mx-auto" style="max-width: 500px;">
            <h1 class="titulo2 text-center">Adicionar Tarefa</h1>
            <div class="form-floating">
                <textarea class="form-control" name="titulo" placeholder="title" id="floatingTextarea"></textarea>
                <label for="floatingTextarea">Título da tarefa</label>
            </div>
            <div class="form-floating">
                <textarea class="form-control" name="descricao" placeholder="description" id="floatingTextarea2"
                    style="height: 100px"></textarea>
                <label for="floatingTextarea2">Descrição</label>
            </div>
            <div class="d-grid gap-2 col-6 mx-auto mt-3">
                <button class="btn btn-primary btn-lg" type="submit">Adicionar</button>
            </div>
        </div>
    </form>







    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq"
        crossorigin="anonymous"></script>
</body>

</html>