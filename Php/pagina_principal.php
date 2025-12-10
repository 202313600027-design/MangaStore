<?php
session_start();
include 'DLL.php';

if (isset($_SESSION['usuario'])) {
    $usuarioLogado = $_SESSION['usuario'];
} else {
    $usuarioLogado = null;
}



// Página Principal
echo "
<!DOCTYPE html>
<html lang='pt-br'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>MangáStore - Sua Loja de Mangás</title>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css'>
    <link rel='stylesheet' href='../Css/pagina_principal.css'>
</head>
<body>
    <!-- Header -->
    <header> 
        <div class='container'>
            <div class='header-content'>
                <a href='pagina_principal.php' class='logo'>Manga<span>Store</span></a>
                <nav>
                    <ul>";

// Verifica se o usuário está logado para mostrar o nome ou o link de login
if ($usuarioLogado) {
    echo "<li class='menu-usuario'>
            <a href='#' class='link-usuario' onclick='toggleDropdown()'>
                <i class='fas fa-user-circle icone-usuario'></i>
                $usuarioLogado
                <i class='fas fa-chevron-down' style='font-size: 12px;'></i>
            </a>
            <div class='menu-suspenso' id='userDropdown'>
                <a href='#' class='item-suspenso'>
                    <i class='fas fa-user'></i> Meu Perfil
                </a>
                <a href='carrinho.php' class='item-suspenso'>
                    <i class='fas fa-shopping-bag'></i> Carrinho
                </a>
                <a href='logout.php' class='item-suspenso botao-sair'>
                    <i class='fas fa-sign-out-alt'></i> Sair
                </a>
            </div>
          </li>";
}else {
    echo "<li class='menu-usuario'>
            <a href='#' class='link-usuario' onclick='toggleDropdown()'>
                <i class='fas fa-user-circle icone-usuario'></i>
                Login
                <i class='fas fa-chevron-down' style='font-size: 12px;'></i>
            </a>
            <div class='menu-suspenso' id='userDropdown'>
                <a href='login1.php' class='item-suspenso'>
                    <i class='fas fa-user'></i> Login
                </a>
                <a href='carrinho.php' class='item-suspenso'>
                    <i class='fas fa-shopping-bag'></i> Carrinho
                </a>
                <a href='logout.php' class='item-suspenso botao-sair'>
                    <i class='fas fa-sign-out-alt'></i> Sair
                </a>
            </div>
          </li>";
}
// Fecha a tag ul, nav, divs e header
echo "
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <!-- Hero Section -->
    <section class='hero'>
        <div class='container'>
            <h1>Os Melhores Mangás do Mercado</h1>
            <p>Encontre sua próxima leitura favorita em nossa vasta coleção de mangás. Aventura, ação, romance e muito mais!</p>
            <a href='#produtos' class='btn'>Ver Produtos</a>
        </div>
    </section>

    <!-- Search Section -->
    <section class='search-section'>
        <div class='container'>
            <div class='search-container'>
                <form  action='busca.php' method='' class='search-box'>
                    <input type='text' name='busca' placeholder='Buscar mangás...'>
                    <button type='submit'>Buscar</button>
                </form>
            </div>
        </div>
    </section>
        <!-- Products Section -->
        <section id='produtos' class='container'>
            <h2 class='section-title'>Mangás em Destaque</h2>
            <div class='products-grid'>
               <div class='product-card'>
        <form method='post' action='carrinho.php'>
            <img src='../fotos/Attack on Titan - Vol. 1.jpg' alt='Attack on Titan' class='product-image'>
            <div class='product-info'>
                <h3 class='product-title'>Attack on Titan - Vol. 1</h3>
                <p class='product-price'>R$ 24,90</p>
    
                <!-- MUDAR AQUI: de 'aot-001' para '1' -->
                <input type='hidden' name='produto_id' value='1'>
                <input type='hidden' name='produto_nome' value='Attack on Titan - Vol. 1'>
                <input type='hidden' name='produto_preco' value='24.90'>
                <input type='hidden' name='produto_imagem' value='../fotos/Attack on Titan - Vol. 1.jpg'>
                <input type='hidden' name='quantidade' value='1'>
    
                <button type='submit' name='adicionar' value='1' class='buy-btn'>Adicionar no carrinho</button>
            </div>
        </form>
    </div>
    
    <!-- Product 2 - One Piece -->
    <div class='product-card'>
        <form method='post' action='carrinho.php'>
            <img src='../fotos/Volume 1 One Piece.png' alt='One Piece' class='product-image'>
            <div class='product-info'>
                <h3 class='product-title'>One Piece - Vol. 1</h3>
                <p class='product-price'>R$ 19,90</p>
    
                <!-- MUDAR AQUI: de 'op-001' para '2' -->
                <input type='hidden' name='produto_id' value='2'>
                <input type='hidden' name='produto_nome' value='One Piece - Vol. 1'>
                <input type='hidden' name='produto_preco' value='19.90'>
                <input type='hidden' name='produto_imagem' value='../fotos/Volume 1 One Piece.png'>
                <input type='hidden' name='quantidade' value='1'>
    
                <button type='submit' name='adicionar' value='1' class='buy-btn'>Adicionar no carrinho</button>
            </div>
        </form>
    </div>
    
    <!-- Product 3 - Naruto -->
    <div class='product-card'>
        <form method='post' action='carrinho.php'>
            <img src='../fotos/naruto-vol-1.jpg' alt='Naruto' class='product-image'>
            <div class='product-info'>
                <h3 class='product-title'>Naruto - Vol. 1</h3>
                <p class='product-price'>R$ 22,90</p>
    
                <!-- MUDAR AQUI: de 'naruto-001' para '3' -->
                <input type='hidden' name='produto_id' value='3'>
                <input type='hidden' name='produto_nome' value='Naruto - Vol. 1'>
                <input type='hidden' name='produto_preco' value='22.90'>
                <input type='hidden' name='produto_imagem' value='../fotos/naruto-vol-1.jpg'>
                <input type='hidden' name='quantidade' value='1'>
    
                <button type='submit' name='adicionar' value='1' class='buy-btn'>Adicionar no carrinho</button>
            </div>
        </form>
    </div>
    
    <!-- Product 4 - My Hero Academia -->
    <div class='product-card'>
        <form method='post' action='carrinho.php'>
            <img src='../fotos/my hero academia - vol.1.jpg' alt='My Hero Academia' class='product-image'>
            <div class='product-info'>
                <h3 class='product-title'>My Hero Academia - Vol. 1</h3>
                <p class='product-price'>R$ 21,90</p>
    
                <!-- MUDAR AQUI: de 'mha-001' para '4' -->
                <input type='hidden' name='produto_id' value='4'>
                <input type='hidden' name='produto_nome' value='My Hero Academia - Vol. 1'>
                <input type='hidden' name='produto_preco' value='21.90'>
                <input type='hidden' name='produto_imagem' value='../fotos/my hero academia - vol.1.jpg'>
                <input type='hidden' name='quantidade' value='1'>
    
                <button type='submit' name='adicionar' value='1' class='buy-btn'>Adicionar no carrinho</button>
            </div>
        </form>
    </div>
    
    <!-- Product 5 - Demon Slayer -->
    <div class='product-card'>
        <form method='post' action='carrinho.php'>
            <img src='../fotos/demon slayer - vol.1.jpg' alt='Demon Slayer' class='product-image'>
            <div class='product-info'>
                <h3 class='product-title'>Demon Slayer - Vol. 1</h3>
                <p class='product-price'>R$ 23,90</p>
    
                <!-- MUDAR AQUI: de 'ds-001' para '5' -->
                <input type='hidden' name='produto_id' value='5'>
                <input type='hidden' name='produto_nome' value='Demon Slayer - Vol. 1'>
                <input type='hidden' name='produto_preco' value='23.90'>
                <input type='hidden' name='produto_imagem' value='../fotos/demon slayer - vol.1.jpg'>
                <input type='hidden' name='quantidade' value='1'>
    
                <button type='submit' name='adicionar' value='1' class='buy-btn'>Adicionar no carrinho</button>
            </div>
        </form>
    </div>
    
    <!-- Product 6 - Tokyo Ghoul -->
    <div class='product-card'>
        <form method='post' action='carrinho.php'>
            <img src='../fotos/tokyo ghoul - vol.1.jpg' alt='Tokyo Ghoul' class='product-image'>
            <div class='product-info'>
                <h3 class='product-title'>Tokyo Ghoul - Vol. 1</h3>
                <p class='product-price'>R$ 25,90</p>
    
                <!-- MUDAR AQUI: de 'tg-001' para '6' -->
                <input type='hidden' name='produto_id' value='6'>
                <input type='hidden' name='produto_nome' value='Tokyo Ghoul - Vol. 1'>
                <input type='hidden' name='produto_preco' value='25.90'>
                <input type='hidden' name='produto_imagem' value='../fotos/tokyo ghoul - vol.1.jpg'>
                <input type='hidden' name='quantidade' value='1'>
    
                <button type='submit' name='adicionar' value='1' class='buy-btn'>Adicionar no carrinho</button>
            </div>
        </form>
    </div>
            </div>
    </section>

    <!-- Footer -->
    <footer>
        <div class='container'>
            <div class='footer-content'>
                <div class='footer-logo'>MangaStore</div>
                <div class='footer-links'>
                    <a href='sobre.php'>Sobre</a>
                    <a href='#'>Contato</a>
                    <a href='#'>Termos de Uso</a>
                    <a href='#'>Política de Privacidade</a>
                </div>
                <p class='copyright'>&copy; 2025 MangaStore. Todos os direitos reservados.</p>
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
</html>";
?>