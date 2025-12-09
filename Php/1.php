<?php
session_start();
include 'DLL.php';

// Verifica se o usuário está logado antes de acessar o carrinho
if (!isset($_SESSION['usuario'])) {
    header("Location: login1.php");
    exit();
}

$usuarioLogado = $_SESSION['usuario'];
extract($_POST);

if(!isset($b1)){
    echo '<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carrinho de Compras - MangáStore</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../Css/carrinho.css">
</head>
<style>
 
    </style>
<body>
    <header>
        <div class="container">
            <div class="header-content">
                <a href="pagina_principal.php" class="logo">Manga<span>Store</span></a>
                <nav>
                    <ul>
                        <li class="menu-usuario">
                            <a href="#" class="link-usuario" onclick="toggleDropdown()">
                                <i class="fas fa-user-circle icone-usuario"></i>
                                ' . $usuarioLogado . '
                                <i class="fas fa-chevron-down" style="font-size: 12px;"></i>
                            </a>
                            <div class="menu-suspenso" id="userDropdown">
                                <a href="#" class="item-suspenso">
                                    <i class="fas fa-user"></i> Meu Perfil
                                </a>
                                <a href="carrinho.php" class="item-suspenso">
                                    <i class="fas fa-shopping-bag"></i> Carrinho
                                </a>
                                <a href="logout.php" class="item-suspenso botao-sair">
                                    <i class="fas fa-sign-out-alt"></i> Sair
                                </a>
                            </div>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <div class="container carrinho-container">
        <h1 class="carrinho-title">Meu Carrinho</h1>';

        /// EM CONSTRUÇÃO - SIMULAÇÃO DE ITENS NO CARRINHO

         if (empty($carrinho)) {
            echo '<div class="carrinho-vazio">
                <i class="fas fa-shopping-cart"></i>
                <h3>Seu carrinho está vazio</h3>
                <p>Adicione alguns mangás incríveis ao seu carrinho!</p>
                <a href="pagina_principal.php" class="btn" style="margin-top: 20px;">Continuar Comprando</a>
            </div>';
        }

    echo '
    </div>

    <script>
        function toggleDropdown() {
            event.preventDefault();
            var dropdown = document.getElementById("userDropdown");
            dropdown.classList.toggle("mostrar");
        }

        // Fechar o dropdown quando clicar fora
        window.onclick = function(event) {
            if (!event.target.matches(".link-usuario") && !event.target.closest(".link-usuario")) {
                var dropdowns = document.getElementsByClassName("menu-suspenso");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains("mostrar")) {
                        openDropdown.classList.remove("mostrar");
                    }
                }
            }
        }
    </script>
</body>
</html>';
}

if(isset($adicionar)){
    
}
?>