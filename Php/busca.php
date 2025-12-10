<?php
session_start();
include 'DLL.php';


if (isset($_SESSION['usuario'])) {
    $usuarioLogado = $_SESSION['usuario'];
} else {
    $usuarioLogado = null;
}

$busca = $_GET['busca'];

$sql_code = "SELECT * FROM produtos WHERE nome LIKE '%$busca%'";

if (empty(trim($busca))) {
    echo "<script>
        alert('Digite algo para buscar!');
        window.location.href = 'pagina_principal.php';
    </script>";
    exit();
}

$resultado = banco('localhost', 'root', '', 'loja', $sql_code);

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
    <!-- Search Section -->
    <section class='search-section'>
        <div class='container'>
            <div class='header-content'>
                <a href='pagina_principal.php' class='logo'>Manga<span>Store</span></a>
                <div class='container'>
                    <div class='search-container'>
                        <form action='busca.php' method='get' class='search-box'>
                            <input type='text' name='busca' placeholder='Buscar mangás...' value='$busca'>
                            <button type='submit'>Buscar</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Products Section -->
    <section id='produtos' class='container'>
        <h2 class='section-title'>Resultados para: $busca</h2>
        <div class='products-grid'>";

if ($resultado->num_rows > 0) {
    while ($produto = $resultado->fetch_assoc()) {
        echo "
            <div class='product-card'>
                <form method='post' action='carrinho.php'>
                    <img src='{$produto['imagem']}' alt='{$produto['nome']}' class='product-image'>
                    <div class='product-info'>
                        <h3 class='product-title'>{$produto['nome']}</h3>
                        <p class='product-price'>R$ {$produto['preco']}</p>

                        <input type='hidden' name='produto_id' value='{$produto['id']}'>
                        <input type='hidden' name='produto_nome' value='{$produto['nome']}'>
                        <input type='hidden' name='produto_preco' value='{$produto['preco']}'>
                        <input type='hidden' name='produto_imagem' value='{$produto['imagem']}'>
                        <input type='hidden' name='quantidade' value='1'>

                        <button type='submit' name='adicionar' value='1' class='buy-btn'>Adicionar no carrinho</button>
                    </div>
                </form>
            </div>";
    }
} else {
    echo "<p>Nenhum mangá encontrado.</p>";
}

echo "
        </div>
    </section>
</body>
</html>";
?>