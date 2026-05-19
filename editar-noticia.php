<?php
require "src/conexao-bd.php";
require "src/modelo/Noticia.php";
require "src/repositorio/NoticiaRepositorio.php";

$noticiaRepositorio = new NoticiaRepositorio($pdo);
$noticia = $noticiaRepositorio->buscarPorCodigo($_GET['codigo']);

if (isset($_POST['cadastro'])) {

    if (!empty($_FILES['img_file']['name'])) {

        $nomeTemp = $_FILES['img_file']['tmp_name'];
        $nomeFinal = 'uploads/' . basename($_FILES['img_file']['name']);

        if (!is_dir('uploads')) {
            mkdir('uploads', 0777, true);
        }

        move_uploaded_file($nomeTemp, $nomeFinal);
        $img = $nomeFinal;

    } else {
        // mantém a imagem antiga
        $img = $noticia->getImg();
    }

    $noticiaAtualizada = new Noticia(
        $noticia->getCodigo(),
        $_POST['titulo'],
        $_POST['descricao'],
        $img
    );

    $noticiaRepositorio->atualizar($noticiaAtualizada);

    header("Location: admin.php");
    exit;
}


?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agrovila São Luiz - Editar Notícia</title>
    <link rel="stylesheet" href="assets/css/cadastrar.css">
</head>
<body>
    <div id="newsModal" class="modal">
        <div class="modal-content">
            <a href="admin.php"><span class="close" onclick="closeModal()">&times;</span></a>
            <h2>Editar Notícia</h2>

            <div id="successMessage" class="success-message">
                Notícia editada com sucesso!
            </div>

<form id="newsForm" method="post" action="" enctype="multipart/form-data">

    <div class="form-group">
        <label>Imagem atual:</label><br>
        <img src="<?= htmlspecialchars($noticia->getImg()) ?>" 
             alt="Imagem atual" 
             style="width:180px; border-radius:8px; margin-bottom:10px;">
    </div>

    <div class="form-group">
        <label for="newsFile">Enviar nova imagem:</label>
        <input type="file" id="newsFile" name="img_file" accept="image/*">
    </div>

    <div class="form-group">
        <label for="newsTitle">Título:</label>
        <input type="text" id="newsTitle" name="titulo" required
               value="<?= htmlspecialchars($noticia->getTitulo()) ?>">
    </div>

    <div class="form-group">
        <label for="newsText">Texto:</label>
        <textarea id="newsText" name="descricao" required><?= htmlspecialchars($noticia->getDescricao()) ?></textarea>
    </div>

    <button type="submit" name="cadastro" class="submit-btn">Salvar Alterações</button>
</form>


        </div>
    </div>
</body>
</html>
