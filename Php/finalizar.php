<?php
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario']) || !isset($_SESSION['logado'])) {
    header("Location: login1.php");
    exit;
}

$usuarioLogado = $_SESSION['usuario'];
extract($_POST);

// Função para obter os itens do carrinho REAL
function getItensCarrinho($usuario) {
    include 'DLL.php';
    
    // Buscar ID do usuário
    $sql_user = "SELECT Id FROM login WHERE usuario = '$usuario' LIMIT 1";
    $result_user = banco('localhost', 'root', '', 'login', $sql_user);
    
    if ($result_user && $result_user->num_rows > 0) {
        $user_row = $result_user->fetch_assoc();
        $user_id = $user_row['Id'];
        
        // Buscar itens do carrinho
        $sql = "SELECT c.id_produto, c.quantidade, p.nome, p.preco
                FROM carrinho c
                INNER JOIN produtos p ON p.id = c.id_produto
                WHERE c.id_usuario = $user_id";
        
        $result = banco('localhost', 'root', '', 'mangastore', $sql);
        
        $itens = array();
        $total = 0;
        
        if ($result) {
            while ($row = $result->fetch_assoc()) {
                $itens[] = array(
                    'nome' => $row['nome'],
                    'quantidade' => $row['quantidade'],
                    'preco' => floatval($row['preco'])
                );
                $total += $row['quantidade'] * floatval($row['preco']);
            }
        }
        return array('itens' => $itens, 'total' => $total);
    }
    return array('itens' => array(), 'total' => 0);
}

// Obter itens e total do carrinho
$carrinhoData = getItensCarrinho($usuarioLogado);
$itensCarrinho = $carrinhoData['itens'];
$totalCarrinho = $carrinhoData['total'];

// Se o carrinho estiver vazio, redirecionar
if (empty($itensCarrinho)) {
    header("Location: carrinho.php?erro=Carrinho vazio");
    exit;
}

// Processar o pagamento quando o formulário for enviado (botão submit)
if (isset($aceito_termos)) {
    // Aqui você processaria o pagamento real
    $metodoPagamento = $metodo_pagamento ?? '';
    $nomeCartao = $nome_cartao ?? '';
    $numeroCartao = $numero_cartao ?? '';
    
    // Verificar se os termos foram aceitos
    if ($aceito_termos) {
        // Simulação de processamento bem-sucedido
        $pedidoSucesso = true;
        $numeroPedido = 'PED' . date('Ymd') . rand(1000, 9999);
    } else {
        echo "<script>alert('Você deve aceitar os termos e condições para finalizar a compra.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang='pt-br'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Finalizar Compra - MangáStore</title>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css'>
    <link rel='stylesheet' href='../Css/pagina_principal.css'>
    <link rel='stylesheet' href='../Css/checkout.css'>
</head>
<body>
    <!-- Header -->
    <header> 
        <div class='container'>
            <div class='header-content'>
                <a href='pagina_principal.php' class='logo'>Manga<span>Store</span></a>
                <nav>
                    <ul>
                        <li class='menu-usuario'>
                            <a href='#' class='link-usuario' onclick='toggleDropdown()'>
                                <i class='fas fa-user-circle icone-usuario'></i>
                                <?php echo $usuarioLogado; ?>
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
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <div class='checkout-container'>
        <?php if (isset($pedidoSucesso) && $pedidoSucesso): ?>
        
        <!-- Tela de confirmação de pedido -->
        <div class='pedido-confirmado'>
            <div class='confirmacao-icon'>
                <i class='fas fa-check-circle'></i>
            </div>
            <h1>Compra Realizada com Sucesso!</h1>
            <div class='resumo-pedido'>
                <h2><i class='fas fa-receipt'></i> Resumo do Pedido</h2>
                <div class='info-pedido'>
                    <p><strong>Número do Pedido:</strong> <?php echo $numeroPedido; ?></p>
                    <p><strong>Data:</strong> <?php echo date('d/m/Y H:i'); ?></p>
                    <p><strong>Valor Total:</strong> R$ <?php echo number_format($totalCarrinho, 2, ',', '.'); ?></p>
                    <p><strong>Método de Pagamento:</strong> <?php echo $metodoPagamento; ?></p>
                </div>
                
                <h3>Itens do Pedido:</h3>
                <ul class='itens-confirmacao'>
                    <?php foreach ($itensCarrinho as $item): ?>
                    <li><?php echo $item['nome']; ?> - <?php echo $item['quantidade']; ?>x - R$ <?php echo number_format($item['preco'], 2, ',', '.'); ?></li>
                    <?php endforeach; ?>
                </ul>
                
                <div class='mensagem-agradecimento'>
                    <p><i class='fas fa-envelope'></i> Um email de confirmação foi enviado para o endereço cadastrado.</p>
                    <p><i class='fas fa-truck'></i> O prazo de entrega é de 5 a 10 dias úteis.</p>
                </div>
                
                <div class='botoes-confirmacao'>
                    <a href='pagina_principal.php' class='btn-voltar-loja'>
                        <i class='fas fa-home'></i> Voltar à Loja
                    </a>
                    <a href='meus-pedidos.php' class='btn-ver-pedidos'>
                        <i class='fas fa-clipboard-list'></i> Ver Meus Pedidos
                    </a>
                    <button onclick='window.print()' class='btn-imprimir'>
                        <i class='fas fa-print'></i> Imprimir Comprovante
                    </button>
                </div>
            </div>
        </div>
        
        <?php else: ?>
        
        <!-- Formulário de Checkout -->
        <div class='checkout-header'>
            <h1><i class='fas fa-shopping-bag'></i> Finalizar Compra</h1>
            <div class='progresso-checkout'>
                <div class='etapa ativa'>
                    <span class='numero'>1</span>
                    <span class='texto'>Carrinho</span>
                </div>
                <div class='linha'></div>
                <div class='etapa ativa'>
                    <span class='numero'>2</span>
                    <span class='texto'>Informações</span>
                </div>
                <div class='linha'></div>
                <div class='etapa'>
                    <span class='numero'>3</span>
                    <span class='texto'>Pagamento</span>
                </div>
            </div>
        </div>
        
        <div class='checkout-content'>
            <div class='checkout-grid'>
                <!-- Coluna 1: Formulário de Entrega e Pagamento -->
                <div class='form-col'>
                    <form method='POST' action='' id='form-checkout'>
                        
                        <!-- Seção: Endereço de Entrega -->
                        <div class='secao-form'>
                            <h2><i class='fas fa-map-marker-alt'></i> Endereço de Entrega</h2>
                            
                            <div class='form-group'>
                                <label for='cep'>CEP *</label>
                                <div class='input-com-botao'>
                                    <input type='text' id='cep' name='cep' placeholder='00000-000' required maxlength='9' value='<?php echo $cep ?? ''; ?>'>
                                </div>
                            </div>
                            
                            <div class='form-duplo'>
                                <div class='form-group'>
                                    <label for='rua'>Rua *</label>
                                    <input type='text' id='rua' name='rua' placeholder='Nome da rua' required value='<?php echo $rua ?? ''; ?>'>
                                </div>
                                <div class='form-group'>
                                    <label for='numero'>Número *</label>
                                    <input type='text' id='numero' name='numero' placeholder='123' required value='<?php echo $numero ?? ''; ?>'>
                                </div>
                            </div>
                            
                            <div class='form-group'>
                                <label for='complemento'>Complemento</label>
                                <input type='text' id='complemento' name='complemento' placeholder='Apartamento, bloco, etc.' value='<?php echo $complemento ?? ''; ?>'>
                            </div>
                            
                            <div class='form-duplo'>
                                <div class='form-group'>
                                    <label for='bairro'>Bairro *</label>
                                    <input type='text' id='bairro' name='bairro' placeholder='Bairro' required value='<?php echo $bairro ?? ''; ?>'>
                                </div>
                                <div class='form-group'>
                                    <label for='cidade'>Cidade *</label>
                                    <input type='text' id='cidade' name='cidade' placeholder='Cidade' required value='<?php echo $cidade ?? ''; ?>'>
                                </div>
                            </div>
                            
                            <div class='form-duplo'>
                                <div class='form-group'>
                                    <label for='estado'>Estado *</label>
                                    <select id='estado' name='estado' required>
                                        <option value=''>Selecione</option>
                                        <?php
                                        $estados = array(
                                            'AC'=>'Acre', 'AL'=>'Alagoas', 'AP'=>'Amapá', 'AM'=>'Amazonas',
                                            'BA'=>'Bahia', 'CE'=>'Ceará', 'DF'=>'Distrito Federal', 'ES'=>'Espírito Santo',
                                            'GO'=>'Goiás', 'MA'=>'Maranhão', 'MT'=>'Mato Grosso', 'MS'=>'Mato Grosso do Sul',
                                            'MG'=>'Minas Gerais', 'PA'=>'Pará', 'PB'=>'Paraíba', 'PR'=>'Paraná',
                                            'PE'=>'Pernambuco', 'PI'=>'Piauí', 'RJ'=>'Rio de Janeiro', 'RN'=>'Rio Grande do Norte',
                                            'RS'=>'Rio Grande do Sul', 'RO'=>'Rondônia', 'RR'=>'Roraima', 'SC'=>'Santa Catarina',
                                            'SP'=>'São Paulo', 'SE'=>'Sergipe', 'TO'=>'Tocantins'
                                        );
                                        
                                        foreach ($estados as $sigla => $nome) {
                                            $selected = ($estado == $sigla) ? 'selected' : '';
                                            echo "<option value='$sigla' $selected>$nome</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class='form-group'>
                                    <label for='telefone'>Telefone *</label>
                                    <input type='tel' id='telefone' name='telefone' placeholder='(11) 99999-9999' required value='<?php echo $telefone ?? ''; ?>'>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Seção: Método de Pagamento -->
                        <div class='secao-form'>
                            <h2><i class='fas fa-credit-card'></i> Método de Pagamento</h2>
                            
                            <div class='opcoes-pagamento'>
                                <div class='opcao-pagamento'>
                                    <input type='radio' id='pagamento-pix' name='metodo_pagamento' value='PIX' <?php echo (($metodo_pagamento ?? 'PIX') == 'PIX') ? 'checked' : ''; ?>>
                                    <label for='pagamento-pix'>
                                        <i class='fas fa-qrcode'></i>
                                        <span>PIX</span>
                                        <small>Pagamento instantâneo</small>
                                    </label>
                                </div>
                                
                                <div class='opcao-pagamento'>
                                    <input type='radio' id='pagamento-cartao' name='metodo_pagamento' value='Cartão de Crédito' <?php echo (($metodo_pagamento ?? '') == 'Cartão de Crédito') ? 'checked' : ''; ?>>
                                    <label for='pagamento-cartao'>
                                        <i class='fas fa-credit-card'></i>
                                        <span>Cartão de Crédito</span>
                                        <small>Até 12x sem juros</small>
                                    </label>
                                </div>
                                
                                <div class='opcao-pagamento'>
                                    <input type='radio' id='pagamento-boleto' name='metodo_pagamento' value='Boleto' <?php echo (($metodo_pagamento ?? '') == 'Boleto') ? 'checked' : ''; ?>>
                                    <label for='pagamento-boleto'>
                                        <i class='fas fa-barcode'></i>
                                        <span>Boleto</span>
                                        <small>Pagamento em até 3 dias</small>
                                    </label>
                                </div>
                            </div>
                            
                            <!-- Campos para cartão de crédito (aparecem apenas quando selecionado) -->
                            <div class='campos-cartao' id='campos-cartao'>
                                <div class='form-group'>
                                    <label for='nome_cartao'>Nome no Cartão *</label>
                                    <input type='text' id='nome_cartao' name='nome_cartao' placeholder='Como está no cartão' value='<?php echo $nome_cartao ?? ''; ?>'>
                                </div>
                                
                                <div class='form-group'>
                                    <label for='numero_cartao'>Número do Cartão *</label>
                                    <input type='text' id='numero_cartao' name='numero_cartao' placeholder='0000 0000 0000 0000' maxlength='19' value='<?php echo $numero_cartao ?? ''; ?>'>
                                </div>
                                
                                <div class='form-duplo'>
                                    <div class='form-group'>
                                        <label for='validade_cartao'>Validade *</label>
                                        <input type='text' id='validade_cartao' name='validade_cartao' placeholder='MM/AA' maxlength='5' value='<?php echo $validade_cartao ?? ''; ?>'>
                                    </div>
                                    <div class='form-group'>
                                        <label for='cvv_cartao'>CVV *</label>
                                        <input type='text' id='cvv_cartao' name='cvv_cartao' placeholder='000' maxlength='3' value='<?php echo $cvv_cartao ?? ''; ?>'>
                                    </div>
                                </div>
                                
                                <div class='form-group'>
                                    <label for='parcelas'>Parcelas</label>
                                    <select id='parcelas' name='parcelas'>
                                        <?php
                                        for ($i = 1; $i <= 12; $i++) {
                                            $valorParcela = $totalCarrinho / $i;
                                            $selected = (($parcelas ?? 1) == $i) ? 'selected' : '';
                                            echo "<option value='$i' $selected>{$i}x de R$ " . number_format($valorParcela, 2, ',', '.') . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            
                            <!-- Instruções para PIX -->
                            <div class='instrucoes-pix' id='instrucoes-pix'>
                                <h3><i class='fas fa-qrcode'></i> Instruções para pagamento via PIX:</h3>
                                <ol>
                                    <li>Após confirmar a compra, será gerado um QR Code</li>
                                    <li>Abra o aplicativo do seu banco e escolha pagar via PIX</li>
                                    <li>Aponte a câmera para o QR Code ou copie o código</li>
                                    <li>Confirme o pagamento no app do banco</li>
                                </ol>
                            </div>
                            
                            <!-- Instruções para Boleto -->
                            <div class='instrucoes-boleto' id='instrucoes-boleto'>
                                <h3><i class='fas fa-barcode'></i> Instruções para pagamento via Boleto:</h3>
                                <ol>
                                    <li>Após confirmar a compra, será gerado um boleto</li>
                                    <li>Imprima o boleto ou pague pelo internet banking</li>
                                    <li>O prazo para pagamento é de 3 dias úteis</li>
                                    <li>O pedido será processado após a confirmação do pagamento</li>
                                </ol>
                            </div>
                        </div>
                        
                        <!-- Termos e Condições -->
                        <div class='termos-checkout'>
                            <input type='checkbox' id='aceito-termos' name='aceito_termos' required <?php echo ($aceito_termos ?? false) ? 'checked' : ''; ?>>
                            <label for='aceito-termos'>
                                Li e concordo com os <a href='termos.php' target='_blank'>Termos de Uso</a> e 
                                <a href='privacidade.php' target='_blank'>Política de Privacidade</a> da MangáStore
                            </label>
                        </div>
                        
                        <button type='submit' class='btn-finalizar-compra'>
                            <i class='fas fa-lock'></i> Finalizar Compra - R$ <?php echo number_format($totalCarrinho, 2, ',', '.'); ?>
                        </button>
                    </form>
                </div>
                
                <!-- Coluna 2: Resumo do Pedido -->
                <div class='resumo-col'>
                    <div class='resumo-pedido'>
                        <h2><i class='fas fa-shopping-cart'></i> Resumo do Pedido</h2>
                        
                        <div class='itens-resumo'>
                            <?php foreach ($itensCarrinho as $item): ?>
                            <div class='item-resumo'>
                                <span class='item-nome'><?php echo $item['nome']; ?> (<?php echo $item['quantidade']; ?>x)</span>
                                <span class='item-preco'>R$ <?php echo number_format($item['preco'] * $item['quantidade'], 2, ',', '.'); ?></span>
                            </div>
                            <?php endforeach; ?>
                        </div>
                        
                        <div class='totais-resumo'>
                            <div class='linha-total'>
                                <span>Subtotal:</span>
                                <span>R$ <?php echo number_format($totalCarrinho, 2, ',', '.'); ?></span>
                            </div>
                            <div class='linha-total'>
                                <span>Frete:</span>
                                <span class='frete-gratis'>Grátis</span>
                            </div>
                            <div class='linha-total total-final'>
                                <span><strong>Total:</strong></span>
                                <span><strong>R$ <?php echo number_format($totalCarrinho, 2, ',', '.'); ?></strong></span>
                            </div>
                        </div>
                        
                        <div class='beneficios'>
                            <h3><i class='fas fa-gift'></i> Benefícios:</h3>
                            <ul>
                                <li><i class='fas fa-check'></i> Frete grátis para todo o Brasil</li>
                                <li><i class='fas fa-check'></i> Entrega em 5-10 dias úteis</li>
                                <li><i class='fas fa-check'></i> Pagamento 100% seguro</li>
                                <li><i class='fas fa-check'></i> Garantia de 7 dias para trocas</li>
                            </ul>
                        </div>
                        
                        <a href='carrinho.php' class='btn-voltar-carrinho'>
                            <i class='fas fa-arrow-left'></i> Voltar ao Carrinho
                        </a>
                    </div>
                    
                    <div class='seguranca-info'>
                        <h3><i class='fas fa-shield-alt'></i> Compra 100% Segura</h3>
                        <p>Seus dados estão protegidos com criptografia. Trabalhamos com os mais altos padrões de segurança.</p>
                        <div class='selos-seguranca'>
                            <span class='selo'><i class='fas fa-lock'></i> SSL</span>
                            <span class='selo'><i class='fas fa-shield-alt'></i> Protegido</span>
                            <span class='selo'><i class='fas fa-credit-card'></i> Pagamento Seguro</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- Footer -->
    <footer>
        <div class='container'>
            <div class='footer-content'>
                <div class='footer-logo'>MangaStore</div>
                <div class='footer-links'>
                    <a href='sobre.php'>Sobre</a>
                    <a href='#'>Contato</a>
                    <a href='termos.php'>Termos de Uso</a>
                    <a href='privacidade.php'>Política de Privacidade</a>
                </div>
                <p class='copyright'>&copy; <?php echo date('Y'); ?> MangaStore. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>

    <script>
function toggleDropdown() {
    event.preventDefault();
    var dropdown = document.getElementById('userDropdown');
    dropdown.classList.toggle('mostrar');
}

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

// Mostrar/ocultar campos de pagamento conforme método selecionado
document.addEventListener('DOMContentLoaded', function() {
    const metodoPix = document.getElementById('pagamento-pix');
    const metodoCartao = document.getElementById('pagamento-cartao');
    const metodoBoleto = document.getElementById('pagamento-boleto');
    const camposCartao = document.getElementById('campos-cartao');
    const instrucoesPix = document.getElementById('instrucoes-pix');
    const instrucoesBoleto = document.getElementById('instrucoes-boleto');
    
    function atualizarCamposPagamento() {
        // Verificar qual método está selecionado
        let metodoSelecionado = 'PIX'; // padrão
        
        if (metodoPix && metodoPix.checked) metodoSelecionado = 'PIX';
        if (metodoCartao && metodoCartao.checked) metodoSelecionado = 'Cartão de Crédito';
        if (metodoBoleto && metodoBoleto.checked) metodoSelecionado = 'Boleto';
        
        // Mostrar campos do cartão apenas se cartão for selecionado
        if (camposCartao) {
            camposCartao.style.display = metodoSelecionado === 'Cartão de Crédito' ? 'block' : 'none';
        }
        
        // Mostrar instruções PIX apenas se PIX for selecionado
        if (instrucoesPix) {
            instrucoesPix.style.display = metodoSelecionado === 'PIX' ? 'block' : 'none';
        }
        
        // Mostrar instruções boleto apenas se boleto for selecionado
        if (instrucoesBoleto) {
            instrucoesBoleto.style.display = metodoSelecionado === 'Boleto' ? 'block' : 'none';
        }
        
        // Tornar campos do cartão obrigatórios apenas se cartão for selecionado
        if (camposCartao) {
            const camposObrigatorios = camposCartao.querySelectorAll('[name]');
            camposObrigatorios.forEach(campo => {
                campo.required = metodoSelecionado === 'Cartão de Crédito';
            });
        }
    }
    
    // Adicionar eventos aos radio buttons
    if (metodoPix) metodoPix.addEventListener('change', atualizarCamposPagamento);
    if (metodoCartao) metodoCartao.addEventListener('change', atualizarCamposPagamento);
    if (metodoBoleto) metodoBoleto.addEventListener('change', atualizarCamposPagamento);
    
    // Inicializar
    atualizarCamposPagamento();
    
    // Máscaras para os campos
    const cepInput = document.getElementById('cep');
    const telefoneInput = document.getElementById('telefone');
    const numeroCartaoInput = document.getElementById('numero_cartao');
    const validadeCartaoInput = document.getElementById('validade_cartao');
    const cvvCartaoInput = document.getElementById('cvv_cartao');
    
    // Máscara para CEP
    if (cepInput) {
        cepInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 5) {
                value = value.substring(0,5) + '-' + value.substring(5,8);
            }
            e.target.value = value;
        });
    }
    
    // Máscara para telefone
    if (telefoneInput) {
        telefoneInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 2) {
                value = '(' + value.substring(0,2) + ') ' + value.substring(2);
            }
            if (value.length > 10) {
                value = value.substring(0,10) + '-' + value.substring(10,15);
            }
            e.target.value = value;
        });
    }
    
    // Máscara para número do cartão
    if (numeroCartaoInput) {
        numeroCartaoInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            value = value.substring(0,16);
            value = value.replace(/(\d{4})/g, '$1 ').trim();
            e.target.value = value;
        });
    }
    
    // Máscara para validade do cartão
    if (validadeCartaoInput) {
        validadeCartaoInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 2) {
                value = value.substring(0,2) + '/' + value.substring(2,4);
            }
            e.target.value = value;
        });
    }
    
    // Máscara para CVV (apenas números, máximo 3)
    if (cvvCartaoInput) {
        cvvCartaoInput.addEventListener('input', function(e) {
            e.target.value = e.target.value.replace(/\D/g, '').substring(0,3);
        });
    }
    
    // Formatar valor do cartão ao carregar a página
    const parcelasSelect = document.getElementById('parcelas');
    if (parcelasSelect) {
        const valorTotal = <?php echo $totalCarrinho; ?>;
        for (let i = 1; i <= 12; i++) {
            if (i <= 4) continue; // Já temos até 4x
            const option = document.createElement('option');
            const valorParcela = valorTotal / i;
            option.value = i;
            option.textContent = `${i}x de R$ ${valorParcela.toFixed(2).replace('.', ',')}`;
            parcelasSelect.appendChild(option);
        }
    }
    
    // Validar formulário antes de enviar
    const formCheckout = document.getElementById('form-checkout');
    if (formCheckout) {
        formCheckout.addEventListener('submit', function(e) {
            // Verificar se os termos foram aceitos
            const aceitoTermos = document.getElementById('aceito-termos');
            if (!aceitoTermos || !aceitoTermos.checked) {
                e.preventDefault();
                alert('Você deve aceitar os termos e condições para finalizar a compra.');
                return;
            }
            
            // Verificar método de pagamento selecionado
            const metodoSelecionado = document.querySelector('input[name="metodo_pagamento"]:checked');
            if (!metodoSelecionado) {
                e.preventDefault();
                alert('Por favor, selecione um método de pagamento.');
                return;
            }
            
            // Se for cartão, validar campos do cartão
            if (metodoSelecionado.value === 'Cartão de Crédito') {
                const nomeCartao = document.getElementById('nome_cartao');
                const numeroCartao = document.getElementById('numero_cartao');
                const validadeCartao = document.getElementById('validade_cartao');
                const cvvCartao = document.getElementById('cvv_cartao');
                
                if (!nomeCartao || !nomeCartao.value.trim()) {
                    e.preventDefault();
                    alert('Por favor, preencha o nome no cartão.');
                    return;
                }
                
                if (!numeroCartao || !numeroCartao.value.replace(/\s/g, '').match(/^\d{16}$/)) {
                    e.preventDefault();
                    alert('Por favor, preencha um número de cartão válido (16 dígitos).');
                    return;
                }
                
                if (!validadeCartao || !validadeCartao.value.match(/^\d{2}\/\d{2}$/)) {
                    e.preventDefault();
                    alert('Por favor, preencha uma validade válida no formato MM/AA.');
                    return;
                }
                
                if (!cvvCartao || !cvvCartao.value.match(/^\d{3}$/)) {
                    e.preventDefault();
                    alert('Por favor, preencha um CVV válido (3 dígitos).');
                    return;
                }
            }
        });
    }
});
</script>
</body>
</html>