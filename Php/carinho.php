<?php
// =======================================================
// Carrinho de compras armazenado no banco MySQL
// usando apenas a função banco() de DLL.php
// =======================================================

include "app/cons.php"; 
require_once "app/DLL.php";


// =======================================================
// FUNÇÃO: Pegar produto por ID
// =======================================================
function GetProduto($id) {
    $sql = "SELECT * FROM produtos WHERE id = $id LIMIT 1";
    $r = banco($server, $user, $password, $db, $sql);

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

    // Verifica se já existe
    $sql = "SELECT quantidade FROM carrinho 
            WHERE id_usuario = $id_usuario AND id_produto = $id_produto";

    $r = banco($server, $user, $password, $db, $sql);

    if ($r && count($r) > 0) {
        // Já existe → aumenta quantidade
        $novaQtd = $r[0]['quantidade'] + 1;

        $update = "UPDATE carrinho SET quantidade = $novaQtd
                   WHERE id_usuario = $id_usuario AND id_produto = $id_produto";

      banco($server, $user, $password, $db, $update);

    } else {
        // Não existe → insere
        $insert = "INSERT INTO carrinho (id_usuario, id_produto, quantidade)
                   VALUES ($id_usuario, $id_produto, 1)";

       banco($server, $user, $password, $db, $insert);
    }
}


// =======================================================
// FUNÇÃO: Remover item do carrinho
// =======================================================
function removerDoCarrinho($id_usuario, $id_produto) {

    $sql = "DELETE FROM carrinho 
            WHERE id_usuario = $id_usuario AND id_produto = $id_produto";

   banco($server, $user, $password, $db, $sql);
}


// =======================================================
// FUNÇÃO: Listar itens do carrinho
// =======================================================
function listarCarrinho($id_usuario) {

    $sql = "SELECT c.id_produto, c.quantidade, p.nome, p.preco
            FROM carrinho c
            INNER JOIN produtos p ON p.id = c.id_produto
            WHERE c.id_usuario = $id_usuario";

    return banco($server, $user, $password, $db, $sql);
}


// =======================================================
// AÇÕES (GET)
// =======================================================
if (isset($_GET['add'])) {
    adicionarAoCarrinho($id_usuario, intval($_GET['add']));
    header("Location: carrinho.php");
    exit;
}

if (isset($_GET['del'])) {
    removerDoCarrinho($id_usuario, intval($_GET['del']));
    header("Location: carrinho.php");
    exit;
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Carrinho MySQL (via banco())</title>
</head>
<body>

<h2>Carrinho de Compras (Armazenado no MySQL)</h2>

<table border="1" cellpadding="8">
    <tr>
        <th>Produto</th>
        <th>Preço</th>
        <th>Quantidade</th>
        <th>Total</th>
        <th>Ação</th>
    </tr>

<?php
$itens = listarCarrinho($id_usuario);
$totalGeral = 0;

if ($itens) {
    foreach ($itens as $item) {
        $totalItem = $item['preco'] * $item['quantidade'];
        $totalGeral += $totalItem;
?>
<tr>
    <td><?= $item['nome']; ?></td>
    <td>R$ <?= number_format($item['preco'], 2, ',', '.'); ?></td>
    <td><?= $item['quantidade']; ?></td>
    <td>R$ <?= number_format($totalItem, 2, ',', '.'); ?></td>
    <td><a href="?del=<?= $item['id_produto']; ?>">Remover</a></td>
</tr>

</table>

<h3>Total Geral: R$ <?= number_format($totalGeral, 2, ',', '.'); ?></h3>

<hr>

<h3>Adicionar produtos no carrinho (exemplo)</h3>
<ul>
    <li><a href="?add=1">Adicionar Produto 1</a></li>
    <li><a href="?add=2">Adicionar Produto 2</a></li>
    <li><a href="?add=3">Adicionar Produto 3</a></li>
</ul>

</body>
</html>
