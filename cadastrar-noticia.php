<?php
require "src/conexao-bd.php";
require "src/modelo/Noticia.php";
require "src/repositorio/NoticiaRepositorio.php";

    if (isset($_POST['cadastro'])) {

    // Verifica se o arquivo foi enviado
    if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {
        $pasta = "uploads/";
        if (!is_dir($pasta)) {
            mkdir($pasta, 0777, true);
        }

        $nomeArquivo = uniqid() . "-" . basename($_FILES['img']['name']);
        $caminho = $pasta . $nomeArquivo;

        move_uploaded_file($_FILES['img']['tmp_name'], $caminho);

    } else {
        die("Erro ao enviar a imagem!");
    }

    // Agora cria o objeto notícia com o caminho da imagem
    $noticia = new Noticia(
        0,
        $_POST['titulo'],
        $_POST['descricao'],
        $caminho  // <-- salva caminho da imagem
    );

    $noticiaRepositorio = new NoticiaRepositorio($pdo);
    $noticiaRepositorio->SalvarNoticia($noticia);

    header("Location: admin.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agrovila São Luiz - Nova Notícia</title>
    <link rel="stylesheet" href="assets/css/cadastrar.css">
</head>
<body>
    <div id="newsModal" class="modal">
        <div class="modal-content">
            <a href="admin.php"><span class="close" onclick="closeModal()">&times;</span></a>
            <h2>Adicionar Nova Notícia</h2>

            <div id="successMessage" class="success-message">
                Notícia publicada com sucesso!
            </div>

            <!-- Formulário corrigido -->
           <form id="newsForm" method="post" action="" enctype="multipart/form-data">
    <div class="form-group">
        <label for="newsImage">Imagem:</label>
        <input type="file" id="newsImage" name="img" required accept="image/*">
    </div>

    <div class="form-group">
        <label for="newsTitle">Título:</label>
        <input type="text" id="newsTitle" name="titulo" required placeholder="Digite o título da notícia...">
    </div>

    <div class="form-group">
        <label for="newsText">Texto:</label>
        <textarea id="newsText" name="descricao" required placeholder="Digite o conteúdo completo da notícia..."></textarea>
    </div>

    <button type="submit" name="cadastro" class="submit-btn">Publicar Notícia</button>
</form>

        </div>
    </div>
</body>
</html>
