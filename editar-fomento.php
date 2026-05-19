<?php
require "src/conexao-bd.php";
require "src/modelo/Fomento.php";
require "src/repositorio/FomentoRepositorio.php";

$fomentoRepositorio = new FomentoRepositorio($pdo);
$fomento = $fomentoRepositorio->buscarPorCodigo($_GET['codigo']);

if (!$fomento) {
    die("Fomento não encontrado!");
}

if (isset($_POST['cadastro'])) {

    /* ======================
       TRATAR A IMAGEM
       ====================== */
    if (!empty($_FILES['img_file']['name'])) {

        $imgTemp = $_FILES['img_file']['tmp_name'];
        $imgFinal = 'uploads/' . basename($_FILES['img_file']['name']);

        if (!is_dir('uploads')) {
            mkdir('uploads', 0777, true);
        }

        move_uploaded_file($imgTemp, $imgFinal);
        $img = $imgFinal;

    } else {
        $img = $fomento->getImg();
    }


    /* ======================
   TRATAR O ARQUIVO PDF
   ====================== */
    if (
    isset($_FILES['arquivo_file']) &&
    $_FILES['arquivo_file']['error'] === UPLOAD_ERR_OK
    ) {
    $pdfTemp  = $_FILES['arquivo_file']['tmp_name'];
    $pdfFinal = 'uploads/' . uniqid('pdf_', true) . '.pdf';

    if (!is_dir('uploads')) {
        mkdir('uploads', 0777, true);
    }

    move_uploaded_file($pdfTemp, $pdfFinal);
    $arquivo = $pdfFinal;

     } else {
    // ✅ mantém o PDF antigo
    $arquivo = $fomento->getArquivo();
   }


    /* ======================
       CRIAR OBJETO ATUALIZADO
       ====================== */
    $fomentoAtualizado = new Fomento(
        $fomento->getCodigo(),
        $arquivo,
        $_POST['titulo'],
        $_POST['descricao'],
        $img
    );

    /* ======================
       ATUALIZAR NO BANCO
       ====================== */
    $fomentoRepositorio->atualizar($fomentoAtualizado);
    
    header("Location: admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Fomento</title>
    <link rel="stylesheet" href="assets/css/cadastrar.css">
</head>

<body>
    <div id="newsModal" class="modal">
        <div class="modal-content">
            <a href="admin.php"><span class="close">&times;</span></a>
            <h2>Editar Fomento</h2>

            <div id="successMessage" class="success-message">
                Fomento atualizado com sucesso!
            </div>

            <form id="fomentoForm" method="post" action="" enctype="multipart/form-data">

                <!-- Imagem atual -->
                <div class="form-group">
                    <label>Imagem atual:</label><br>
                    <img src="<?= htmlspecialchars($fomento->getImg()) ?>" 
                         alt="Imagem atual"
                         style="width:180px; border-radius:8px; margin-bottom:10px;">
                </div>

                <div class="form-group">
                    <label for="imgFile">Enviar nova imagem:</label>
                    <input type="file" id="imgFile" name="img_file" accept="image/*">
                </div>

                <!-- PDF atual -->
                <div class="form-group">
                    <label>Arquivo atual (PDF):</label><br>
                    <a href="<?= htmlspecialchars($fomento->getArquivo()) ?>" target="_blank">
                        Abrir PDF atual
                    </a>
                </div>

                <div class="form-group">
                    <label for="arquivoFile">Enviar novo PDF:</label>
                    <input type="file" id="arquivoFile" name="arquivo_file" accept="application/pdf">
                </div>

                <div class="form-group">
                    <label for="titulo">Título:</label>
                    <input type="text" id="titulo" name="titulo" required
                           value="<?= htmlspecialchars($fomento->getTitulo()) ?>">
                </div>

                <div class="form-group">
                    <label for="descricao">Descrição:</label>
                    <textarea id="descricao" name="descricao" required><?= htmlspecialchars($fomento->getDescricao()) ?></textarea>
                </div>

                <button type="submit" name="cadastro" class="submit-btn">Salvar Alterações</button>
            </form>

        </div>
    </div>
</body>
</html>
