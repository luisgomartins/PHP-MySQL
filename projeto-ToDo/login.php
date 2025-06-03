<?php
session_start();

$uname = $pw = $email = "";
$errorUsername = $errorPassword = $errorEmail = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["inputpassword"])) {
        $errorPassword = "Campo obrigatório";
    } else {
        $pw = test_input($_POST["inputpassword"]);
    }
    if (empty($_POST["inputemail"])) {
        $errorEmail = "Campo obrigatório";
    } else {
        $email = test_input($_POST["inputemail"]);
    }
    if (empty($errorPassword) && empty($errorEmail)) {
        require 'includes/db.php';
        $hash_pw = md5($pw);
        $sql = "SELECT * FROM users WHERE email = '$email' AND pw = '$hash_pw'";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['email'] = $row['email'];
                $_SESSION['pw'] = $row['pw'];
                $_SESSION['success'] = true;
                $_SESSION['foto'] = $row['foto'];
                header("Location: user/dashboard.php");
            }
        } else {
            $error = " show";
        }
        $conn->close();
    }
}

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}
?>









?>
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
                    <input type="email" class="form-control" id="inputemail" name="inputemail" placeholder="Email" required>
                    <label for="inputemail">Email</label>
                </div>
                <div class="form-floating m-auto p-1 position-relative">
                    <input type="password" class="form-control pe-5" id="inputpassword" name="inputpassword" placeholder="Password" required>
                    <label for="inputpassword">Password</label>
                    <i class="bi bi-eye-slash toggle-password position-absolute top-50 end-0 translate-middle-y me-3"
                        style="cursor: pointer;"
                        data-target="inputpassword"></i>
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>

        </div>
        <div class="alert alert-danger alert-dismissible mx-auto mt-3 fade <?php echo $error; ?>" role="alert" style="height: 70px; width: 350px;">
            ❌ Email or password is invalid!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></button>
        </div>


    </div>









    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            document.querySelectorAll('.toggle-password').forEach(function(icon) {
                icon.addEventListener('click', function() {
                    const targetInput = document.getElementById(this.getAttribute('data-target'));
                    const isPassword = targetInput.type === 'password';
                    targetInput.type = isPassword ? 'text' : 'password';
                    this.classList.toggle('bi-eye');
                    this.classList.toggle('bi-eye-slash');
                });
            });
        });
    </script>
</body>

</html>