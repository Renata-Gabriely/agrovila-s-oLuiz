<?php
require "src/conexao-bd.php";
require "src/modelo/Fomento.php";
require "src/repositorio/FomentoRepositorio.php";

if (isset($_POST['cadastro'])) {
    // Cria a pasta de upload se não existir
    $diretorioUpload = "uploads/fomentos/";
    if (!is_dir($diretorioUpload)) {
        mkdir($diretorioUpload, 0777, true);
    }

    // Upload da imagem
    $imgNome = $_FILES['img']['name'];
    $imgTemp = $_FILES['img']['tmp_name'];
    $imgDestino = $diretorioUpload . uniqid() . "-" . basename($imgNome);
    move_uploaded_file($imgTemp, $imgDestino);

    // Upload do arquivo PDF
    $arquivoNome = $_FILES['arquivo']['name'];
    $arquivoTemp = $_FILES['arquivo']['tmp_name'];
    $arquivoDestino = $diretorioUpload . uniqid() . "-" . basename($arquivoNome);
    move_uploaded_file($arquivoTemp, $arquivoDestino);

    // Cria o objeto Fomento
    $fomento = new Fomento(
        0,
        $arquivoDestino,  // caminho salvo do PDF
        $_POST['titulo'],
        $_POST['descricao'],
        $imgDestino        // caminho salvo da imagem
    );

    // Salva no banco
    $fomentoRepositorio = new FomentoRepositorio($pdo);
    $fomentoRepositorio->inserir($fomento);

    header("Location: admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Fomento - Agrovila São Luiz</title>
    <link rel="stylesheet" href="assets/css/cadastrar.css">
</head>
<body>
    <div id="fomentoModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="window.location.href='admin.php'">&times;</span>
            <h2>Adicionar Novo Termo de Fomento</h2>

            <div id="successMessage" class="success-message">
                ✅ Termo de fomento cadastrado com sucesso!
            </div>

            <!-- Formulário com envio de arquivos -->
            <form id="fomentoForm" method="post" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="img">Imagem do Termo (JPG/PNG):</label>
                    <input type="file" id="img" name="img" accept="image/*" required>
                </div>

                <div class="form-group">
                    <label for="titulo">Título:</label>
                    <input type="text" id="titulo" name="titulo" required placeholder="Digite o título do termo de fomento...">
                </div>

                <div class="form-group">
                    <label for="descricao">Descrição:</label>
                    <textarea id="descricao" name="descricao" required placeholder="Descreva o termo de fomento..."></textarea>
                </div>

                <div class="form-group">
                    <label for="arquivo">Arquivo PDF:</label>
                    <input type="file" id="arquivo" name="arquivo" accept=".pdf" required>
                </div>

                <button type="submit" name="cadastro" class="submit-btn">Cadastrar Fomento</button>
            </form>
        </div>
    </div>
</body>
</html>
