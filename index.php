
<?php
require "src/conexao-bd.php";
require "src/modelo/Produto.php";
require "src/repositorio/ProdutoRepositorio.php";

$repositorio = new ProdutoRepositorio($pdo);
$mensagem = "";

// Salvar produto
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'] ?? '';
    $categoria = $_POST['categoria'] ?? '';
    $preco = isset($_POST['preco']) ? (float)$_POST['preco'] : 0.0;

    $imgPath = "uploads/default.jpg";
    if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
        $arquivoTmp = $_FILES['img']['tmp_name'];
        $nomeArquivo = uniqid() . "_" . basename($_FILES['img']['name']);
        if (!is_dir('uploads')) mkdir('uploads', 0755, true);
        $destino = "uploads/" . $nomeArquivo;
        if (move_uploaded_file($arquivoTmp, $destino)) {
            $imgPath = $destino;
        }
    }

    $produto = new Produto(0, $nome, $categoria, $preco, $imgPath);
    $repositorio->salvarProduto($produto);
    $mensagem = "Produto salvo com sucesso!";
}

// Lista todos os produtos
$produtos = $repositorio->produtos();
?>
<!DOCTYPE html>

<html lang="en">
<head>
<meta charset="utf-8"/>
<meta content="width=device-width, initial-scale=1, shrink-to-fit=no" name="viewport"/>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&amp;display=swap" rel="stylesheet"/>
<link href="assets/images/favicon_green.ico" rel="icon" type="image/x-icon"/>
<title>Agrovila São Luiz</title>
<!-- Bootstrap core CSS -->
<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
<!-- Additional CSS Files -->
<link href="assets/css/fontawesome.css" rel="stylesheet"/>
<link href="assets/css/templatemo-villa-agency.css" rel="stylesheet"/>
<link href="assets/css/owl.css" rel="stylesheet"/>
<link href="assets/css/animate.css" rel="stylesheet"/>
<link href="https://unpkg.com/swiper@7/swiper-bundle.min.css" rel="stylesheet"/>
<!--

TemplateMo 591 villa agency

https://templatemo.com/tm-591-villa-agency

-->
</head>
<body>
<!-- ***** Preloader Start ***** -->
<div class="js-preloader" id="js-preloader">
<div class="preloader-inner">
<span class="dot"></span>
<div class="dots">
<span></span>
<span></span>
<span></span>
</div>
</div>
</div>
<!-- ***** Preloader End ***** -->
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
               <span>
                <a href="./admin.php">admin</a>
            </span>
        </div>
        
        <div class="right-section">
        <ul>
           <li class="conect"><a href="#"><i class="fa fa-user"></i>Conecte-se</a></li> 
           </ul>
            <div class="social-links">
                <a href="https://www.facebook.com/share/19RrBnigCs/" class="social-link facebook" target="_blank">
                    <svg viewBox="0 0 24 24">
                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                    </svg>
                </a>
                
                <a href="https://www.instagram.com/agrovilasl?igsh=MWNuM3Q3MWd1a2c1ag==" class="social-link instagram" target="_blank">
                    <svg viewBox="0 0 24 24">
                       <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                    </svg>
                </a>
            </div>
        </div>
      </div>


<!-- ***** Header Area Start ***** -->
<header class="header-area header-sticky">
<div class="container">
<div class="row">
<div class="col-12">
<nav class="main-nav">
<!-- ***** Logo Start ***** -->
<a class="logo" href="index.html">
<img alt="Logo Agrovila" src="assets/images/Logo-Agrovila.png" style="width: 100px; height: auto"/>
</a>
<!-- ***** Logo End ***** -->
<!-- ***** Menu Start ***** -->
<ul class="nav">
<li><a class="active" href="index.php">Home</a></li>
<li><a href="properties.php">Produtos</a></li>
<li><a href="cursos.php">Cursos</a></li>
<li><a href="agro-noticia.php">Notícias</a></li>
<li><a href="property-details.html">Sobre Nós</a></li>
<li><a href="contact.html">Contatos</a></li>
<li><a href="termo-fomento.php">Termo de Fomento</a></li>
</ul>
<a class="menu-trigger">
<span>Menu</span>
</a>
<!-- ***** Menu End ***** -->
</nav>
</div>
</div>
</div>
</header>
<!-- ***** Header Area End ***** -->
<div class="main-banner">
<div class="owl-carousel owl-banner">
<div class="item item-1">
<div class="header-text">
<span class="category">Viçosa, <em>Alagoas</em></span>
<h2>Conheça<br/>a Agrovila São Luiz!</h2>
</div>
</div>
<div class="item item-2">
<div class="header-text">
<span class="category">Viçosa, <em>Alagoas</em></span>
<h2><br/>Produtos saudáveis e de qualidade em sua mesa</h2>
</div>
</div>
<div class="item item-3">
<div class="header-text">
<span class="category">Viçosa, <em>Alagoas</em></span>
<h2>Venha conhecer!<br/>Agrovila são Luiz</h2>
</div>
</div>
</div>
</div>

    <div class="featured section">
      <div class="container">
        <div class="row">
          <div class="col-lg-4">
            <div class="left-image">
              <img src="assets/images/featured.jpg" alt="" />
              <a href="property-details.html"
                ><img
                  src="assets/images/featured-icon.png"
                  alt=""
                  style="max-width: 60px; padding: 0px"
              /></a>
            </div>
          </div>
          <div class="col-lg-5">
            <div class="section-heading">
              <h6>| Serviços</h6>
              <h2>Serviços da Agrovila São Luiz</h2>
            </div>
            <div class="accordion" id="accordionExample">
              <div class="accordion-item">
                <h2 class="accordion-header" id="headingOne">
                  <button
                    class="accordion-button"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#collapseOne"
                    aria-expanded="true"
                    aria-controls="collapseOne"
                  >
                    O que é inovação verde?
                  </button>
                </h2>
                <div
                  id="collapseOne"
                  class="accordion-collapse collapse show"
                  aria-labelledby="headingOne"
                  data-bs-parent="#accordionExample"
                >
                  <div class="accordion-body">
                   <p>
                    Apoiamos a agricultura familiar e promovemos a inserção produtiva de jovens e mulheres. Em parceria com o MAPA, fortalecemos a Agrovila São Luiz através de ações desenvolvidas com emenda parlamentar.
                   </p>
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <h2 class="accordion-header" id="headingTwo">
                  <button
                    class="accordion-button collapsed"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#collapseTwo"
                    aria-expanded="false"
                    aria-controls="collapseTwo"
                  >
                    O que é Tecnologia Agrícola?
                  </button>
                </h2>
                <div
                  id="collapseTwo"
                  class="accordion-collapse collapse"
                  aria-labelledby="headingTwo"
                  data-bs-parent="#accordionExample"
                >
                  <div class="accordion-body">
                   <p>
                    Promovemos uma gestão eficiente e integrada, aliando tecnologia agrícola de ponta para maximizar os resultados. Nosso objetivo é impulsionar o crescimento sustentável do setor.
                   </p>
                  </div>
                </div>
              </div>
                      <div class="accordion-item">
                <h2 class="accordion-header" id="headingFive">
                  <button
                    class="accordion-button collapsed"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#collapseFive"
                    aria-expanded="false"
                    aria-controls="collapseFive"
                  >
                    O que é Consultoria Especializada?
                  </button>
                </h2>
                <div
                  id="collapseFive"
                  class="accordion-collapse collapse"
                  aria-labelledby="headingFive"
                  data-bs-parent="#accordionExample"
                >
                  <div class="accordion-body">
                  <p>
                    Comprometidos com a sustentabilidade, oferecemos consultoria especializada para otimizar a produção agrícola. Nosso foco é impulsionar o desenvolvimento rural de forma responsável.
                  </p>
                  </div>
                </div>
              </div>
              <div class="accordion-item">
                <h2 class="accordion-header" id="headingThree">
                  <button
                    class="accordion-button collapsed"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#collapseThree"
                    aria-expanded="false"
                    aria-controls="collapseThree"
                  >
                    O que é Desenvolvimento Rural?
                  </button>
                </h2>
                <div
                  id="collapseThree"
                  class="accordion-collapse collapse"
                  aria-labelledby="headingThree"
                  data-bs-parent="#accordionExample"
                >
                  <div class="accordion-body">
                    <p>
                      Oferecemos assistência personalizada visando o desenvolvimento rural e a melhoria contínua das práticas agrícolas. Contamos com uma equipe dedicada em potencializar o agronegócio local.
                    </p>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg-3">
            <div class="info-table">
              <ul>
                <li>
                  <img
                    src="assets/images/info-icon-01.png"
                    alt=""
                    style="max-width: 52px"
                  />
                  <h6>Inovação Verde<br /></h6>
                </li>
                <li>
                  <img
                    src="assets/images/info-icon-02.png"
                    alt=""
                    style="max-width: 52px"
                  />
                  <h6>Tecnologia Agrícola<br /></h6>
                </li>
                <li>
                  <img
                    src="assets/images/info-icon-03.png"
                    alt=""
                    style="max-width: 52px"
                  />
                  <h6>Consultoria Especializada<br /></h6>
                </li>
                <li>
                  <img
                    src="assets/images/info-icon-04.jpg"
                    alt=""
                    style="max-width: 52px"
                  />
                    <h6> Desenvolvimento<br />Rural</h6>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>

<div class="section" id="impacto-social" style="padding: 60px 20px; background-color: #f4f8f4;">
  <div class="container">
    <div class="row text-center">
      <div class="col-lg-12">
        <h2>Impacto Social da Agrovila São Luiz</h2>
        <p>Nosso trabalho vai além do campo: fortalecemos famílias, comunidades e o meio ambiente.</p>
      </div>

      <div class="col-lg-4 col-md-6 mb-4">
        <div class="p-4 shadow rounded bg-white">
          <div style="font-size: 2rem">👨‍👩‍👧‍👦</div>
          <h3 class="mt-3">120+</h3>
          <p>Famílias beneficiadas (A mudar)</p>
        </div>
      </div>

      <div class="col-lg-4 col-md-6 mb-4">
        <div class="p-4 shadow rounded bg-white">
          <div style="font-size: 2rem">🌱</div>
          <h3 class="mt-3">30</h3>
          <p>Hortas comunitárias implantadas (A mudar)</p>
        </div>
      </div>

      <div class="col-lg-4 col-md-6 mb-4">
        <div class="p-4 shadow rounded bg-white">
          <div style="font-size: 2rem">📚</div>
          <h3 class="mt-3">80</h3>
          <p>Jovens capacitados (A mudar)</p>
        </div>
      </div>
    </div>
  </div>
</div>

</div>
</div>
<div class="video section">
<div class="container">
<div class="row">
<div class="col-lg-4 offset-lg-4">
<div class="section-heading text-center">
<h6>| Apresentação vídeo</h6>
<h2>Conheça a Agrovila São Luiz!</h2>
</div>
</div>
</div>
</div>
</div>
<div class="video-content">
  <div class="container">
    <div class="row">
      <div class="col-lg-10 offset-lg-1">
        <div class="video-frame">
          <video width="100%" height="500" controls poster="assets/images/video-frame.jpg">
            <source src="assets/videos/apresentacao.mp4" type="video/mp4">
            Seu navegador não suporta a reprodução de vídeos.
          </video>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="fun-facts">
<div class="container">
<div class="row">
<div class="col-lg-12">
<div class="wrapper">
<div class="row">
<div class="col-lg-4">
<div class="counter">
<h2 class="timer count-title count-number" data-speed="1000" data-to="7"></h2>
<p class="count-text">7 Anos<br/>de experiência</p>
</div>
</div>
<div class="col-lg-4">
<div class="counter">
<h2 class="timer count-title count-number" data-speed="1000" data-to="80"></h2>
<p class="count-text">80 Jovens<br/>capacitados</p>
</div>
</div>
<div class="col-lg-4">
<div class="counter">
<h2 class="timer count-title count-number" data-speed="1000" data-to="7"></h2>
<p class="count-text">7 Anos<br/>de experiência</p>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="section best-deal">
<div class="container">
<div class="row">
<div class="col-lg-4">
<div class="section-heading">
<h6>| Ambiente de trabalho</h6>
<h2>Conheça nossa cozinha!!</h2>
</div>
</div>
<div class="col-lg-12">
<div class="tabs-content">
<div class="row">
<div class="nav-wrapper">
<ul class="nav nav-tabs" role="tablist">
<li class="nav-item" role="presentation">
<button aria-controls="appartment" aria-selected="true" class="nav-link active" data-bs-target="#appartment" data-bs-toggle="tab" id="appartment-tab" role="tab" type="button">
                        Ambiente
                      </button>
</li>
<li class="nav-item" role="presentation">
<button aria-controls="villa" aria-selected="false" class="nav-link" data-bs-target="#villa" data-bs-toggle="tab" id="villa-tab" role="tab" type="button">
                        Ferramentas
                      </button>
</li>
<li class="nav-item" role="presentation">
<button aria-controls="penthouse" aria-selected="false" class="nav-link" data-bs-target="#penthouse" data-bs-toggle="tab" id="penthouse-tab" role="tab" type="button">
                        Processo final
                      </button>
</li>
</ul>
</div>
<div class="tab-content" id="myTabContent">
<div aria-labelledby="appartment-tab" class="tab-pane fade show active" id="appartment" role="tabpanel">
<div class="row">
<div class="col-lg-3">
<div class="info-table">
<ul>
<li>Setor <span> **</span></li>
<li>Bancada <span>aço inox</span></li>
<li>Limpeza <span>Frequente</span></li>
<li>Licença Sanitária <span>Aprovada</span></li>
</ul>
</div>
</div>
<div class="col-lg-6">
<img alt="" src="assets/images/deal-01.jpg"/>
</div>
<div class="col-lg-3">
<h4>Cozinha da Agrovila São Luiz</h4>
<p>
                          É um espaço onde moradores e agricultores se reúnem
                          para preparar refeições para instituições e projetos
                          sociais. O ambiente é acolhedor, limpo e bem
                          organizado, promovendo segurança alimentar e
                          fortalecimento comunitário.
                          <br/><br/>Além de gerar renda, a cozinha também é
                          símbolo de cooperação e cuidado coletivo. É um ponto
                          de união e valorização da produção local.
                        </p>

</div>
</div>
</div>
<div aria-labelledby="villa-tab" class="tab-pane fade" id="villa" role="tabpanel">
<div class="row">
<div class="col-lg-3">
<div class="info-table">
<ul>
<li>Setor <span> **</span></li>
<li>Bancada <span>aço inox</span></li>
<li>Limpeza <span>Frequente</span></li>
<li>Licença Sanitária <span>Aprovada</span></li>
</ul>
</div>
</div>
<div class="col-lg-6">
<img alt="" src="assets/images/deal-02.jpg"/>
</div>
<div class="col-lg-3">
<h4>Equipamentos</h4>
<p>
                          liquidificadores industriais, balanças digitais de
                          precisão, bebedouro elétrico, fatiador e outros
                          utensílios essenciais ao trabalho diário.
                          <br/><br/>Esses itens permitem agilidade na produção
                          e padronização na qualidade dos produtos.
                        </p>
</div>
</div>
</div>
<div aria-labelledby="penthouse-tab" class="tab-pane fade" id="penthouse" role="tabpanel">
<div class="row">
<div class="col-lg-3">
<div class="info-table">
<ul>
<li>Setor <span> **</span></li>
<li>Bancada <span>aço inox</span></li>
<li>Limpeza <span>Frequente</span></li>
<li>Licença Sanitária <span>Aprovada</span></li>
</ul>
</div>
</div>
<div class="col-lg-6">
<img alt="" src="assets/images/deal-03.jpg"/>
</div>
<div class="col-lg-3">
<h4>Processo final</h4>
<p>
                          seladora de embalagens, balança digital, impressora de
                          etiquetas e uma cuba para higienização. Essa área é
                          voltada para a finalização e empacotamento dos
                          alimentos, mostrando que a cozinha está preparada
                          tanto para produção quanto para comercialização,
                          seguindo boas práticas de manipulação e controle de
                          qualidade.
                          <br/><br/>A cozinha da Agrovila São Luiz se destaca
                          pela organização, limpeza e estrutura moderna.
                        </p>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
</div>
<div class="properties section">
<div class="container">
<div class="row">
<div class="col-lg-4 offset-lg-4">
<div class="section-heading text-center">
<h6>| Produtos</h6>
<h2>Alimentos saudáveis e de qualidade em sua mesa!</h2>
</div>
</div>
</div>
<div class="row properties-box">
  <?php foreach(array_slice($produtos, 0, 6) as $p): ?>
  <div class="col-lg-4 col-md-6 align-self-center mb-30 properties-items">
      <div class="item">
          <a href="property-details.html">
              <img src="<?= htmlspecialchars($p->getImg()) ?>" alt="<?= htmlspecialchars($p->getNome()) ?>" />
          </a>
          <span class="category"><?= htmlspecialchars($p->getCategoria()) ?></span>
          <h6>R$ <?= number_format($p->getPreco(), 2, ',', '.') ?></h6>
          <h4>
              <a href="property-details.html"><?= htmlspecialchars($p->getNome()) ?></a>
          </h4>
          <div class="main-button">
              <a href="property-details.html">COMPRAR</a>
          </div>
      </div>
  </div>
  <?php endforeach; ?>
</div>



</div>
</div>


<div class="contact section">
<div class="container">
<div class="row">
<div class="col-lg-4 offset-lg-4">
<div class="section-heading text-center">
<h6>| contatos</h6>
<h2>Fale conosco!</h2>
</div>
</div>
</div>
</div>
</div>
<div class="contact-content">
<div class="container">
<div class="row">
<div class="col-lg-7">
  <div id="map">
  <iframe
    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3936.2296993351497!2d-36.264887225214515!3d-9.40122959067572!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x706c3f2b7f02209%3A0x2a0b9f081ab03da4!2sAgrovila%20S%C3%A3o%20Luiz!5e0!3m2!1spt-BR!2sbr!4v1750457300070!5m2!1spt-BR!2sbr"
    allowfullscreen=""
    loading="lazy"
    referrerpolicy="no-referrer-when-downgrade">
  </iframe>
</div>
<div class="row">
<div class="col-lg-6">
<div class="item phone">
<img alt="" src="assets/images/phone-icon.png" style="max-width: 52px"/>
<h6>82 9.9645-8890<br/><span>Número para contato</span></h6>
</div>
</div>
<div class="col-lg-6">
<div class="item email">
<img alt="" src="assets/images/email-icon.png" style="max-width: 52px"/>
<h6>Agrovila@gmail.com<br/><span>E-mail para contato</span></h6>
</div>
</div>
</div>
</div>
<div class="col-lg-5">
<form action="" id="contact-form" method="post">
<div class="row">
<div class="col-lg-12">
<fieldset>
<label for="name">Seu nome</label>
<input autocomplete="on" id="name" name="name" placeholder="Seu Nome..." required="" type="name"/>
</fieldset>
</div>
<div class="col-lg-12">
<fieldset>
<label for="email">Seu E-mail</label>
<input id="email" name="email" pattern="[^ @]*@[^ @]*" placeholder="Seu E-mail..." required="" type="text"/>
</fieldset>
</div>
<div class="col-lg-12">
<fieldset>
<label for="subject">Assunto</label>
<input autocomplete="on" id="subject" name="subject" placeholder="Assunto..." type="subject"/>
</fieldset>
</div>
<div class="col-lg-12">
<fieldset>
<label for="message">Menssagem</label>
<textarea id="message" name="message" placeholder="Digite sua mensagem"></textarea>
</fieldset>
</div>
<div class="col-lg-12">
<fieldset>
<button class="orange-button" id="form-submit" type="submit">
                      Enviar
                    </button>
</fieldset>
</div>
</div>
</form>
</div>
</div>
</div>
</div>
<div class="section" id="impacto-social" style="padding: 60px 20px; background-color: #f4f8f4;"><div class="container"><div class="row text-center"><div class="col-lg-12"><h2>Impacto Social da Agrovila São Luiz</h2><p>Nosso trabalho vai além do campo: fortalecemos famílias, comunidades e o meio ambiente.</p></div><div class="col-lg-4 col-md-6 mb-4"><div class="p-4 shadow rounded bg-white"><div style="font-size: 2rem">👨‍👩‍👧‍👦</div><h3 class="mt-3">120+</h3><p>Famílias beneficiadas (A mudar)</p></div></div><div class="col-lg-4 col-md-6 mb-4"><div class="p-4 shadow rounded bg-white"><div style="font-size: 2rem">🌱</div><h3 class="mt-3">30</h3><p>Hortas comunitárias implantadas (A mudar)</p></div></div><div class="col-lg-4 col-md-6 mb-4"><div class="p-4 shadow rounded bg-white"><div style="font-size: 2rem">📚</div><h3 class="mt-3">80</h3><p>Jovens capacitados (A mudar)</p></div></div></div></div></div>

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
              <li><a href="termo-fomento.html">Termo de Fomento</a></li>
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
            <a
              href="https://www.instagram.com/agrovilasl/?igsh=MWNuM3Q3MWd1a2c1ag%3D%3D#"
              ><i class="fab fa-instagram"></i
            ></a>
          </div>
        </div>
      </footer>

<!-- Scripts -->
<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/isotope.min.js"></script>
<script src="assets/js/owl-carousel.js"></script>
<script src="assets/js/counter.js"></script>
<script src="assets/js/custom.js"></script>
</body>
</html>
