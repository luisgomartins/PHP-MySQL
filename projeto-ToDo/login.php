<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToDo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Audiowide">
</head>

<body class="bg-light">
    <div class="background">
        <div class="container">
            <h1 class="titulo2 text-center">ToDo</h1>
            <p class="subtitulo text-center">Sistema de Gerenciamento de Tarefas</p>
        </div>
        <nav class=" bg-dark navbar-dark position-fixed top-0 start-0 w-100">
            <div class="container-fluid">
                <a class="navbar-brand" href="index.php">ToDo</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="register.php">Sign Up</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>






        <div class="container w-25 p-2 bg-light rounded-3 text-center">
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <div class="form-floating m-auto p-1">
                    <input type="email" class="form-control" id="inputemail" name="inputemail" placeholder="email" required>
                    <label for="email">Email</label>
                </div>
                <div class="form-floating m-auto p-1 position-relative">
                    <input type="password" class="form-control pe-5" id="inputpassword" name="inputpassword" placeholder="Password" required>
                    <button type="button" id="botaoVerSenha" class="btn position-absolute top-50 end-0 translate-middle-y me-2" onclick="verSenha()" style="border: none; background: none;">
                        <i class="bi bi-eye"></i>
                    </button>
                    <label for="inputpassword">Password</label>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>

        </div>


    </div>









    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    <script>
        function verSenha() {
            let iconeDoOlho = document.getElementById("botaoVerSenha").querySelector("i");
            let campoSenha = document.getElementById("inputpassword");
            if (campoSenha.type === "password") {
                iconeDoOlho.className = "bi bi-eye-slash";
                campoSenha.type = "text";
            } else {
                iconeDoOlho.className = "bi bi-eye";
                campoSenha.type = "password";
            }
        }
    </script>
</body>

</html>