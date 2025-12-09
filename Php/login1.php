<?php
include 'DLL.php';
extract($_POST);

// Exibe o formulário de login/cadastro
if (!isset($b1) && !isset($b2)) {
    echo "
    <html lang='pt-br'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>MangáStore - Login</title>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css'>
        <link rel='stylesheet' href='../Css/login.css'>
    </head>
    <body>
        <header>
           <div class='voltar'><ul><li><a href='pagina_principal.php'><i class='fas fa-arrow-left'></i> Voltar</a></li></ul></div>
        </header>
        <div class='container'>
            <div class='logo'><i class='fas fa-book'></i> MangáStore</div>
            <form method='post' action=''>
                <div class='form-group'>
                    <label for='usuario'><i class='fas fa-user'></i> Usuário</label>
                    <input type='text' id='usuario' name='usuario' placeholder='Digite o usuário' required>
                </div>
                <div class='form-group'>
                    <label for='senha'><i class='fas fa-lock'></i> Senha</label>
                    <input type='password' id='senha' name='senha' placeholder='Digite a senha' required>
                </div>
                <div class='btn-group'>
                    <button type='submit' name='b1' class='btn btn-cadastrar'><i class='fas fa-user-plus'></i> Cadastrar</button>
                    <button type='submit' name='b2' class='btn btn-entrar'><i class='fas fa-right-to-bracket'></i> Entrar</button>
                </div>
            </form>
        </div>
    </body>
    </html>";
// Cadastro
} else if (isset($b1)) {
    $consulta = "INSERT INTO `login` (Id, usuario, senha) VALUES (NULL, '$usuario', '$senha')";
    banco('localhost', 'root', '', 'login', $consulta);

    echo "
    <html lang='pt-br'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Cadastro Realizado</title>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css'>
        <link rel='stylesheet' href='../Css/login.css'>
    </head>
    <body>
       <header>
           <div class='voltar'><ul><li><a href='login1.php'><i class='fas fa-arrow-left'></i> Voltar</a></li></ul></div>
       </header>
        <div class='container'>
            <div class='icon success-icon'><i class='fas fa-check-circle'></i></div>
            <h2>Cadastro Realizado!</h2>
            <p>Usuário <strong>" . $usuario . "</strong> cadastrado com sucesso.</p>
            <form method='post' action='login1.php'>
                <input type='hidden' name='usuario' value='" . $usuario . "'>
                <input type='hidden' name='senha' value='" . $senha . "'>
                <button type='submit' name='b2' value='1' class='btn-voltar'><i class='fas fa-arrow-left'></i> Voltar e Entrar</button>
            </form>
        </div>
    </body>
    </html>";
// Login
} else if (isset($b2)) {

    session_start();

    $sql = "SELECT * FROM login WHERE usuario = '$usuario' AND senha = '$senha'";
    $resultado = banco('localhost','root','','login',$sql);
    $linha = $resultado->fetch_assoc();

    if ($linha) {
        $_SESSION['usuario'] = $linha['usuario'];
        $_SESSION['logado'] = true;
        header("Location: pagina_principal.php");
        exit();

    } else {

        echo "
        <script>
            alert('Usuário ou senha incorretos!');
            window.location.href='login1.php';
        </script>
        ";
        exit();
    }
}
?>