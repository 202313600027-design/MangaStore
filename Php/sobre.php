<?php
session_start();

if (isset($_SESSION['usuario'])) {
    $usuarioLogado = $_SESSION['usuario'];
} else {
    $usuarioLogado = null;
}
?>
<!DOCTYPE html>
<html lang='pt-br'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Sobre Nós - MangáStore</title>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css'>
    <link rel='stylesheet' href='../Css/pagina_principal.css'>
    <link rel='stylesheet' href='../Css/sobre.css'>
</head>
<body>
    <!-- Header -->
    <header> 
        <div class='container'>
            <div class='header-content'>
                <a href='pagina_principal.php' class='logo'>Manga<span>Store</span></a>
                <nav>
                    <ul>
                        <li><a href='pagina_principal.php'>Home</a></li>
                        <li><a href='carrinho.php'>Carrinho</a></li>
                                                
                        <?php
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
                        } else {
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
                                    </div>
                                  </li>";
                        }
                        ?>
                    </ul>
                </nav>
            </div>
        </div>
    </header>

    <div class='sobre-container'>
        <div class='sobre-header'>
            <h1><i class='fas fa-book'></i> Sobre a MangáStore</h1>
            <p>Somos apaixonados por mangás e nossa missão é levar as melhores histórias para você!</p>
        </div>
        
        <div class='sobre-content'>
            <div class='sobre-text'>
                <h2>Nossa História</h2>
                <p>A MangáStore nasceu em 2020 da paixão de um grupo de amigos por cultura japonesa e narrativas envolventes. Começamos como uma pequena livraria online e, graças ao apoio de nossos clientes, nos tornamos uma das principais referências em mangás no Brasil.</p>
                
                <p>Nosso objetivo sempre foi proporcionar uma experiência única para os fãs de mangá, oferecendo não apenas os títulos mais populares, mas também obras alternativas e independentes que merecem reconhecimento.</p>
                
                <h2>Nossa Missão</h2>
                <p>Conectar leitores com as melhores histórias em quadrinhos japonesas, proporcionando uma experiência de compra fácil, segura e acessível. Queremos ser a ponte entre os mangakás talentosos e os leitores ávidos por novas aventuras.</p>
            </div>
            
            <div class='sobre-image'>
                <img src='https://images.unsplash.com/photo-1589998059171-988d887df646?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80' alt='Livraria de mangás'>
            </div>
        </div>
        
        <h2 style='text-align: center; margin: 60px 0 40px;'>Nossos Valores</h2>
        <div class='valores-grid'>
            <div class='valor-card'>
                <div class='valor-icon'>
                    <i class='fas fa-heart'></i>
                </div>
                <h3>Paixão por Mangás</h3>
                <p>Somos verdadeiros fãs e entendemos o que você procura. Cada recomendação é feita com carinho e conhecimento.</p>
            </div>
            
            <div class='valor-card'>
                <div class='valor-icon'>
                    <i class='fas fa-shipping-fast'></i>
                </div>
                <h3>Entrega Rápida</h3>
                <p>Entregamos seus mangás com agilidade e cuidado, para que você possa começar a leitura o mais rápido possível.</p>
            </div>
            
            <div class='valor-card'>
                <div class='valor-icon'>
                    <i class='fas fa-lock'></i>
                </div>
                <h3>Compra Segura</h3>
                <p>Seus dados e sua compra estão protegidos com os mais altos padrões de segurança da internet.</p>
            </div>
            
            <div class='valor-card'>
                <div class='valor-icon'>
                    <i class='fas fa-headset'></i>
                </div>
                <h3>Suporte Dedicado</h3>
                <p>Nossa equipe está sempre pronta para ajudar com qualquer dúvida sobre produtos, entregas ou sugestões.</p>
            </div>
        </div>
        
        <div class='equipe-section'>
            <h2 style='text-align: center; margin-bottom: 40px;'>Conheça Nossa Equipe</h2>
            <div class='equipe-grid'>
                <div class='membro-card'>
                    <div class='membro-foto'>
                        <i class='fas fa-user'></i>
                    </div>
                    <h4>Tarcizio</h4>
                    <p>Projetista</p>
                </div>
                
                <div class='membro-card'>
                    <div class='membro-foto'>
                        <i class='fas fa-user'></i>
                    </div>
                    <h4>Salomão</h4>
                    <p>Escritor</p>
                </div>
                
                <div class='membro-card'>
                    <div class='membro-foto'>
                        <i class='fas fa-user'></i>
                    </div>
                    <h4>Carlos Silva</h4>
                    <p>Gerente de Vendas</p>
                </div>
                
                <div class='membro-card'>
                    <div class='membro-foto'>
                        <i class='fas fa-user'></i>
                    </div>
                    <h4>Ana Oliveira</h4>
                    <p>Atendimento ao Cliente</p>
                </div>
            </div>
        </div>
        
        <div class='contato-info'>
            <h3><i class='fas fa-envelope'></i> Entre em Contato</h3>
            <div class='contato-item'>
                <div class='contato-icon'>
                    <i class='fas fa-map-marker-alt'></i>
                </div>
                <div>
                    <strong>Endereço:</strong><br>
                    IFBA<br>
                    Eunápolis - BA, 45823-431
                </div>
            </div>
            
            <div class='contato-item'>
                <div class='contato-icon'>
                    <i class='fas fa-phone'></i>
                </div>
                <div>
                    <strong>Telefone:</strong><br>
                    (11) 9999-8888
                </div>
            </div>
            
            <div class='contato-item'>
                <div class='contato-icon'>
                    <i class='fas fa-envelope'></i>
                </div>
                <div>
                    <strong>Email:</strong><br>
                    contato@mangastore.com.br
                </div>
            </div>
            
            <div class='contato-item'>
                <div class='contato-icon'>
                    <i class='fas fa-clock'></i>
                </div>
                <div>
                    <strong>Horário de Atendimento:</strong><br>
                    Segunda a Sexta: 9h às 18h<br>
                    Sábado: 9h às 14h
                </div>
            </div>
        </div>
        
        <div style='text-align: center;'>
            <a href='pagina_principal.php' class='voltar-btn'>
                <i class='fas fa-arrow-left'></i> Voltar para a Loja
            </a>
        </div>
    </div>

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
    </script>
</body>
</html>