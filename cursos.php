<?php
require "src/conexao-bd.php";
require "src/modelo/Curso.php";
require "src/repositorio/CursoRepositorio.php";
require "src/modelo/Video.php";
require "src/repositorio/VideoRepositorio.php";

$cursoRepo = new CursoRepositorio($pdo);
$videoRepo = new VideoRepositorio($pdo);

$cursos = $cursoRepo->buscarTodos();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cursos - Agrovila São Luiz</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="assets/css/templatemo-villa-agency.css">
    <link rel="stylesheet" href="assets/css/curso.css">
</head>

<body>

<div class="header">
    <div class="left-section">
        <div class="contact-item">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/></svg>
            <span>Agrovila@gmail.com</span>
        </div>
        <div class="contact-item">
            <svg viewBox="0 0 24 24" fill="currentColor"><path d="M6.62 10.79c1.44 2.83 3.76 5.14 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
            <span>82 9.9645-8890</span>
        </div>
    </div>
    <div class="right-section">
        <ul>
            <li><a href="#"><i class="fa fa-user"></i> Conecte-se</a></li>
        </ul>
    </div>
</div>

<header class="header-area header-sticky">
    <div class="container">
        <nav class="main-nav">
            <a href="index.php" class="logo">
                <img src="assets/images/Logo-Agrovila.png" alt="Logo Agrovila" style="width:100px;">
            </a>
            <ul class="nav">
                <li><a href="index.php">Home</a></li>
                <li><a href="properties.php">Produtos</a></li>
                <li><a href="cursos.php" class="active">Cursos</a></li>
                <li><a href="agro-noticia.php">Notícias</a></li>
                <li><a href="property-details.html">Sobre Nós</a></li>
                <li><a href="contact.html">Contatos</a></li>
                <li><a href="termo-fomento.php">Termo de Fomento</a></li>
            </ul>
            <a class="menu-trigger"><span>Menu</span></a>
        </nav>
    </div>
</header>

<div class="page-heading header-text">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <span class="breadcrumb"><a href="index.php">Home</a> / Cursos</span>
                <h3>Cursos da Agrovila São Luiz</h3>
            </div>
        </div>
    </div>
</div>

<div class="container-cursos">

    <?php foreach ($cursos as $curso): ?>

        <?php 
            $videos = $videoRepo->buscarPorCurso($curso->getId());
        ?>

        <div class="container-header" onclick="toggleLinks(<?= $curso->getId() ?>)">
            <div class="header-content">
                <h2 class="container-title"><?= htmlspecialchars($curso->getTitulo()) ?></h2>
                <div class="container-id">ID do curso: #<?= $curso->getId() ?></div>
                <p class="container-description">
                    <?= htmlspecialchars($curso->getDescricao()) ?>
                </p>
            </div>

            <div class="arrow" id="arrow-<?= $curso->getId() ?>">▼</div>
        </div>

        <div class="links-container" id="links-<?= $curso->getId() ?>">

            <div class="links-content">

                <?php if (count($videos) === 0): ?>
                    <p style="opacity:0.7;">Nenhum vídeo cadastrado para este curso.</p>
                <?php endif; ?>

                <?php foreach ($videos as $video): ?>
                    <a href="<?= htmlspecialchars($video->getCodigo()) ?>" target="_blank" class="link-item">
                        <div class="link-title">🔗 Link do Vídeo</div>
                        <div class="link-description">
                            <?= htmlspecialchars($video->getDescricao()) ?>
                        </div>
                    </a>
                <?php endforeach; ?>

            </div>
        </div>

    <?php endforeach; ?>

</div>

 <footer class="footer">
        <div class="footer-content">
            <div class="footer-column">
                <a href="property-details.html"><h3>SOBRE NÓS</h3></a>
            </div>

            <div class="footer-column">
                <h3>LINKS</h3>
                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="properties.html">Produtos</a></li>
                    <li><a href="property-details.html">Sobre nós</a></li>
                    <li><a href="termo-fomento.php">Termo de Fomento</a></li>
                </ul>
            </div>

            <div class="footer-column">
                <h3>SUPORTE</h3>
                <ul>
                    <li><a href="contact.html">Contatos</a></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            <div class="social-icons">
                <a href="https://www.facebook.com/AgroVilaSL?rdid=zdSPuDAhRP9NB5AN&share_url=https%3A%2F%2Fwww.facebook.com%2Fshare%2F1YxiYerSU4%2F#"><i class="fab fa-facebook-f"></i></a>
                <a href="#"><i class="fab fa-whatsapp"></i></a>
                <a href="https://www.instagram.com/agrovilasl/?igsh=MWNuM3Q3MWd1a2c1ag%3D%3D#"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </footer>

<script>
function toggleLinks(id) {
    const container = document.getElementById("links-" + id);
    const arrow = document.getElementById("arrow-" + id);
    container.classList.toggle("expanded");
    arrow.classList.toggle("rotated");
}
</script>


    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/custom.js"></script>

</body>
</html>
