<?php
require "src/conexao-bd.php";

// INCLUSÕES EXISTENTES
require "src/modelo/Noticia.php";
require "src/repositorio/NoticiaRepositorio.php";
$noticiaRepositorio = new NoticiaRepositorio($pdo);
$dados = $noticiaRepositorio->buscarNoticia();

require "src/modelo/Produto.php";
require "src/repositorio/ProdutoRepositorio.php";
$produtoRepositorio = new ProdutoRepositorio($pdo);
$dadosp = $produtoRepositorio->buscarProdutos();

require "src/modelo/Fomento.php";
require "src/repositorio/FomentoRepositorio.php";
$fomentoRepositorio = new FomentoRepositorio($pdo);
$dadosf = $fomentoRepositorio->buscarTodos();

require "src/modelo/Curso.php";
require "src/repositorio/CursoRepositorio.php";
$cursoRepositorio = new CursoRepositorio($pdo);
$cursos = $cursoRepositorio->buscarTodos();

// 👉 NOVAS INCLUSÕES PARA VÍDEOS
require "src/modelo/Video.php";
require "src/repositorio/VideoRepositorio.php";

$videoRepositorio = new VideoRepositorio($pdo);
// 👉 BUSCA DE TODOS OS VÍDEOS
// Assumindo que seu VideoRepositorio tem um método chamado buscarTodos()
$videos = $videoRepositorio->buscarTodos(); 

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agrovila - Adm</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet" />
    <link rel="icon" href="assets/images/favicon_green.ico" type="image/x-icon">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/fontawesome.css" />
    <link rel="stylesheet" href="assets/css/templatemo-villa-agency.css" />
    <link rel="stylesheet" href="assets/css/owl.css" />
    <link rel="stylesheet" href="assets/css/animate.css" />
    <link rel="stylesheet" href="assets/css/noticia.css">
    <link rel="stylesheet" href="assets/css/adm.css">
</head>
<body>
    <!-- HEADER SUPERIOR -->
    <div class="header">
        <div class="left-section">
            <div class="contact-item">
                <svg viewBox="0 0 24 24" fill="currentColor">
                    <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                </svg>
                <span>Agrovila@gmail.com</span>
            </div>
            <div class="contact-item">
                <svg viewBox="0 0 24 24" fill="currentColor">
                    <path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/>
                </svg>
                <span>82 9.9645-8890</span>
            </div>
            <span><a href="./admin.php" class="active">admin</a></span>
        </div>
        <div class="right-section">
            <ul>
                <li class="conect"><a href="#"><i class="fa fa-user"></i>Conecte-se</a></li>
            </ul>
        </div>
    </div>

    <!-- MENU -->
    <header class="header-area header-sticky">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <nav class="main-nav">
                        <a class="logo" href="index.html">
                            <img alt="Logo Agrovila" src="assets/images/Logo-Agrovila.png" style="width: 100px; height: auto"/>
                        </a>
                        <ul class="nav">
                            <li><a href="index.php">Home</a></li>
                            <li><a href="properties.php">Produtos</a></li>
                            <li><a href="cursos.php">Cursos</a></li>
                            <li><a href="agro-noticia.php">Notícias</a></li>
                            <li><a href="property-details.html">Sobre Nós</a></li>
                            <li><a href="contact.html">Contatos</a></li>
                            <li><a href="termo-fomento.php">Termo de Fomento</a></li>
                        </ul>
                        <a class="menu-trigger"><span>Menu</span></a>
                    </nav>
                </div>
            </div>
        </div>
    </header>

  
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de Notícias</h3>
            <a href="cadastrar-noticia.php"><button class="btn-add">+ Cadastrar Notícia</button></a>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>URL</th>
                        <th>Título</th>
                        <th>Descrição</th>
                        <th>Editar</th>
                        <th>Excluir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dados as $dado) { ?>
                        <tr>
                            <td><?= $dado->getCodigo() ?></td>
                            <td><span class="url-link"><?= $dado->getImg() ?></span></td>
                            <td><?= $dado->getTitulo() ?></td>
                            <td><?= $dado->getDescricao() ?></td>
                            <td>
                                <a href="editar-noticia.php?codigo=<?= $dado->getCodigo() ?>">
                                    <button class="btn-edit">Editar</button>
                                </a>
                            </td>
                            <td>
                                <form action="excluir.php" method="post">
                                    <input type="hidden" name="codigo" value="<?= $dado->getCodigo() ?>">
                                    <button class="btn-delete">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

   

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Lista de Produtos</h3>
            <a href="cadastrar-produto.php"><button class="btn-add">+ Cadastrar Produto</button></a>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Código</th>
                        <th>Nome</th>
                        <th>Preço</th>
                        <th>Categoria</th>
                        <th>Editar</th>
                        <th>Excluir</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($dadosp as $produto) { ?>
                        <tr>
                            <td><?= $produto->getCodigo() ?></td>
                            <td><?= $produto->getNome() ?></td>
                            <td><?= $produto->getPreco() ?></td>
                            <td><?= $produto->getCategoria() ?></td>
                            <td>
                                <a href="editar-produto.php?codigo=<?= $produto->getCodigo() ?>">
                                    <button class="btn-edit">Editar</button>
                                </a>
                            </td>
                            <td>
                                <form action="excluir-produto.php" method="post">
                                    <input type="hidden" name="codigo" value="<?= $produto->getCodigo() ?>">
                                    <button class="btn-delete">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Termos de Fomento</h3>
        <a href="cadastrar-fomento.php"><button class="btn-add">+ Cadastrar Fomento</button></a>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Título</th>
                    <th>Descrição</th>
                    <th>Imagem</th>
                    <th>Arquivo</th>
                    <th>Editar</th>
                    <th>Excluir</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($dadosf as $fomento) { ?>
                    <tr>
                        <td><?= $fomento->getCodigo() ?></td>
                        <td><?= htmlspecialchars($fomento->getTitulo()) ?></td>
                        <td><?= htmlspecialchars($fomento->getDescricao()) ?></td>
                        <td>
                            <img src="<?= htmlspecialchars($fomento->getImg()) ?>" alt="Imagem do Fomento" width="80" height="50" style="object-fit:cover; border-radius:5px;">
                        </td>
                        <td>
                            <a href="<?= htmlspecialchars($fomento->getArquivo()) ?>" target="_blank">Ver Arquivo</a>
                        </td>
                        <td>
                            <a href="editar-fomento.php?codigo=<?= $fomento->getCodigo() ?>">
                                <button class="btn-edit">Editar</button>
                            </a>
                        </td>
                        <td>
                            <form action="excluir-fomento.php" method="post">
                                <input type="hidden" name="codigo" value="<?= $fomento->getCodigo() ?>">
                                <button class="btn-delete">Excluir</button>
                            </form>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Cursos</h3>
        <a href="cadastrar-curso.php"><button class="btn-add">+ Cadastrar Curso</button></a>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Descrição</th>
                    <th>Editar</th>
                    <th>Excluir</th>
                    <th>Vídeos</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($cursos as $curso) { ?>
                    <tr>
                        <td><?= $curso->getId() ?></td>
                        <td><?= htmlspecialchars($curso->getTitulo()) ?></td>
                        <td><?= htmlspecialchars($curso->getDescricao()) ?></td>
                        
                        <td>
                            <a href="editar-curso.php?id=<?= $curso->getId() ?>">
                                <button class="btn-edit">Editar</button>
                            </a>
                        </td>
                        
                        <td>
                            <form action="excluir-curso.php" method="post">
                                <input type="hidden" name="id" value="<?= $curso->getId() ?>">
                                <button class="btn-delete">Excluir</button>
                            </form>
                        </td>

                        <td>
                            <a href="cadastrar-video.php?id_curso=<?= $curso->getId() ?>">
                                <button class="btn-view">Adicionar Vídeo</button>
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Lista de Vídeos</h3>
    </div>

    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID Vídeo</th>
                    <th>ID Curso</th>
                    <th>Título do Curso</th>
                    <th>Descrição do Vídeo</th>
                    <th>Excluir</th>
                </tr>
            </thead>

            <tbody>
                <?php 
                // Verifica se existem vídeos
                if (isset($videos) && is_array($videos) && count($videos) > 0): 
                    foreach ($videos as $v): 
                ?>
                    <tr>
                        <!-- ID do vídeo -->
                        <td><?= $v->getId() ?></td>

                        <!-- ID do curso -->
                        <td><?= $v->getCursoId() ?></td>

                        <!-- Título do curso -->
                        <td><?= htmlspecialchars($curso->getTitulo()) ?></td>

                        <!-- Descrição do vídeo -->
                        <td><?= htmlspecialchars($v->getDescricao()) ?></td>

                        <!-- Botão excluir -->
                        <td>
                            <form action="excluir-video.php" method="post" 
                                  onsubmit="return confirm('Tem certeza que deseja excluir este vídeo?');">
                                <input type="hidden" name="id" value="<?= $v->getId() ?>">
                                <button class="btn-delete">Excluir</button>
                            </form>
                        </td>
                    </tr>
                <?php 
                    endforeach; 
                else: 
                ?>
                    <tr>
                        <td colspan="5" style="text-align: center;">Nenhum vídeo cadastrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>

        </table>
    </div>
</div>







    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/isotope.min.js"></script>
    <script src="assets/js/owl-carousel.js"></script>
    <script src="assets/js/counter.js"></script>
    <script src="assets/js/custom.js"></script>
</body>
</html>
