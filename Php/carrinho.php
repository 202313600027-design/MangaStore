<?php
// =======================================================
// Carrinho de compras armazenado no banco MySQL
// usando apenas a função banco() de DLL.php
// =======================================================

include "cons.php"; 
require_once "DLL.php";
session_start();

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario']) || !isset($_SESSION['logado'])) {
    header("Location: login1.php");
    exit;
}

$id_usuario = $_SESSION['usuario'];

// =======================================================
// FUNÇÃO: Pegar produto por ID
// =======================================================
function GetProduto($id) {
    $sql = "SELECT * FROM produtos WHERE id = $id LIMIT 1";
    $r = banco('localhost', 'root', '', 'mangastore', $sql);

    if ($r && count($r) > 0) {
        return $r[0];
    }
    return null;
}

// =======================================================
// FUNÇÃO: Adicionar um item no carrinho
// Se o item já existe → aumenta a quantidade
// Se não existe → insere
// =======================================================
function adicionarAoCarrinho($id_usuario, $id_produto) {
    // Primeiro precisamos pegar o ID do usuário da tabela login
    $sql_user = "SELECT Id FROM login WHERE usuario = '$id_usuario' LIMIT 1";
    $result_user = banco('localhost', 'root', '', 'login', $sql_user);
    
    if ($result_user && $result_user->num_rows > 0) {
        $user_row = $result_user->fetch_assoc();
        $user_id = $user_row['Id'];
        
        // Verifica se já existe no carrinho
        $sql = "SELECT quantidade FROM carrinho 
                WHERE id_usuario = $user_id AND id_produto = $id_produto";
        
        $result = banco('localhost', 'root', '', 'mangastore', $sql);
        
        if ($result && $result->num_rows > 0) {
            // Já existe → aumenta quantidade
            $row = $result->fetch_assoc();
            $novaQtd = $row['quantidade'] + 1;
            
            $update = "UPDATE carrinho SET quantidade = $novaQtd
                       WHERE id_usuario = $user_id AND id_produto = $id_produto";
            
            banco('localhost', 'root', '', 'mangastore', $update);
        } else {
            // Não existe → insere
            $insert = "INSERT INTO carrinho (id_usuario, id_produto, quantidade)
                       VALUES ($user_id, $id_produto, 1)";
            
            banco('localhost', 'root', '', 'mangastore', $insert);
        }
    }
}

// =======================================================
// FUNÇÃO: Remover item do carrinho
// =======================================================
function removerDoCarrinho($id_usuario, $id_produto) {
    // Primeiro precisamos pegar o ID do usuário da tabela login
    $sql_user = "SELECT Id FROM login WHERE usuario = '$id_usuario' LIMIT 1";
    $result_user = banco('localhost', 'root', '', 'login', $sql_user);
    
    if ($result_user && $result_user->num_rows > 0) {
        $user_row = $result_user->fetch_assoc();
        $user_id = $user_row['Id'];
        
        $sql = "DELETE FROM carrinho 
                WHERE id_usuario = $user_id AND id_produto = $id_produto";
        
        banco('localhost', 'root', '', 'mangastore', $sql);
    }
}

// =======================================================
// FUNÇÃO: Listar itens do carrinho
// =======================================================
function listarCarrinho($id_usuario) {
    // Primeiro precisamos pegar o ID do usuário da tabela login
    $sql_user = "SELECT Id FROM login WHERE usuario = '$id_usuario' LIMIT 1";
    $result_user = banco('localhost', 'root', '', 'login', $sql_user);
    
    if ($result_user && $result_user->num_rows > 0) {
        $user_row = $result_user->fetch_assoc();
        $user_id = $user_row['Id'];
        
        $sql = "SELECT c.id_produto, c.quantidade, p.nome, p.preco
                FROM carrinho c
                INNER JOIN produtos p ON p.id = c.id_produto
                WHERE c.id_usuario = $user_id";
        
        $result = banco('localhost', 'root', '', 'mangastore', $sql);
        
        $itens = array();
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $itens[] = $row;
            }
        }
        return $itens;
    }
    return array();
}

// =======================================================
// AÇÕES (GET e POST)
// =======================================================

// Processa adição via POST (da página principal)
if (isset($_POST['adicionar']) && isset($_POST['produto_id'])) {
    adicionarAoCarrinho($id_usuario, intval($_POST['produto_id']));
    header("Location: carrinho.php");
    exit;
}

// Processa adição via GET
if (isset($_GET['add'])) {
    adicionarAoCarrinho($id_usuario, intval($_GET['add']));
    header("Location: carrinho.php");
    exit;
}

// Processa remoção via GET
if (isset($_GET['del'])) {
    removerDoCarrinho($id_usuario, intval($_GET['del']));
    header("Location: carrinho.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Carrinho de Compras - MangáStore</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../Css/pagina_principal.css">
</head>
<body>

    <!-- Header (igual ao da página principal) -->
    <header> 
        <div class="container">
            <div class="header-content">
                <a href="pagina_principal.php" class="logo">Manga<span>Store</span></a>
                <nav>
                    <ul>
                        <li class="menu-usuario">
                            <a href="#" class="link-usuario" onclick="toggleDropdown()">
                                <i class="fas fa-user-circle icone-usuario"></i>
                                <?php echo $id_usuario; ?>
                                <i class="fas fa-chevron-down" style="font-size: 12px;"></i>
                            </a>
                            <div class="menu-suspenso" id="userDropdown">
                                <a href="pagina_principal.php" class="item-suspenso">
                                    <i class="fas fa-home"></i> Página Principal
                                </a>
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

    <div class="container" style="margin-top: 30px;">
        <h2><i class="fas fa-shopping-cart"></i> Meu Carrinho</h2>

        <?php
        $itens = listarCarrinho($id_usuario);
        
        if (count($itens) > 0) {
        ?>
        <table border="1" cellpadding="8" style="width: 100%; margin-top: 20px;">
            <tr>
                <th>Produto</th>
                <th>Preço Unitário</th>
                <th>Quantidade</th>
                <th>Total</th>
                <th>Ação</th>
            </tr>

            <?php
            $totalGeral = 0;
            
            foreach ($itens as $item) {
                $totalItem = $item['preco'] * $item['quantidade'];
                $totalGeral += $totalItem;
            ?>
            <tr>
                <td><?php echo $item['nome']; ?></td>
                <td>R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></td>
                <td><?php echo $item['quantidade']; ?></td>
                <td>R$ <?php echo number_format($totalItem, 2, ',', '.'); ?></td>
                <td>
                    <a href="?del=<?php echo $item['id_produto']; ?>" 
                       style="color: #ff4444; text-decoration: none;">
                       <i class="fas fa-trash"></i> Remover
                    </a>
                </td>
            </tr>
            <?php } ?>
            
            <tr style="font-weight: bold; background-color: #121212;">
                <td colspan="3" style="text-align: right;">Total Geral:</td>
                <td colspan="2">R$ <?php echo number_format($totalGeral, 2, ',', '.'); ?></td>
            </tr>
        </table>

        <div style="margin-top: 20px; text-align: center;">
            <a href="pagina_principal.php" style="margin-right: 10px; padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px;">
                <i class="fas fa-arrow-left"></i> Continuar Comprando
            </a>
            <a href="finalizar.php" style="padding: 10px 20px; background-color: #2196F3; color: white; text-decoration: none; border-radius: 5px;">
                <i class="fas fa-credit-card"></i> Finalizar Compra
            </a>
        </div>

        <?php } else { ?>
        
        <div style="text-align: center; margin-top: 50px; padding: 40px;">
            <i class="fas fa-shopping-cart" style="font-size: 60px; color: #ccc;"></i>
            <h3>Seu carrinho está vazio</h3>
            <p>Adicione produtos ao seu carrinho para visualizá-los aqui.</p>
            <a href="pagina_principal.php" style="margin-top: 20px; padding: 10px 20px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 5px; display: inline-block;">
                <i class="fas fa-store"></i> Ver Produtos
            </a>
        </div>
        
        <?php } ?>
        
        <hr style="margin: 30px 0;">
        
        <h3>Adicionar mais produtos:</h3>
        <ul style="list-style: none; padding: 0;">
            <li style="display: inline-block; margin-right: 10px;">
                <a href="?add=1" style="padding: 5px 10px; background-color: #121212; text-decoration: none;">
                    <i class="fas fa-plus"></i> Attack on Titan
                </a>
            </li>
            <li style="display: inline-block; margin-right: 10px;">
                <a href="?add=2" style="padding: 5px 10px; background-color: #121212; text-decoration: none;">
                    <i class="fas fa-plus"></i> One Piece
                </a>
            </li>
            <li style="display: inline-block; margin-right: 10px;">
                <a href="?add=3" style="padding: 5px 10px; background-color: #121212; text-decoration: none;">
                    <i class="fas fa-plus"></i> Naruto
                </a>
            </li>
        </ul>
    </div>

    <!-- Footer -->
    <footer style="margin-top: 50px;">
        <div class="container">
            <div class="footer-content">
                <div class="footer-logo">MangaStore</div>
                <div class="footer-links">
                    <a href="sobre.html">Sobre</a>
                    <a href="#">Contato</a>
                    <a href="#">Termos de Uso</a>
                    <a href="#">Política de Privacidade</a>
                </div>
                <p class="copyright">&copy; 2023 MangaStore. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>

    <script>
    function toggleDropdown() {
        event.preventDefault();
        var dropdown = document.getElementById('userDropdown');
        dropdown.classList.toggle('mostrar');
    }
    
    // Fechar o menu suspenso quando clicar fora
    window.onclick = function(event) {
        if (!event.target.matches('.link-usuario') && !event.target.closest('.link-usuario')) {
            var dropdowns = document.getElementsByClassName('menu-suspenso');
            for (var i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('mostrar')) {
                    openDropdown.classList.remove('mostrar');
                }
            }
        }
    }
    </script>
</body>
</html>