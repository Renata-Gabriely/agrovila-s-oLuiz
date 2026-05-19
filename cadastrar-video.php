<?php
require "src/conexao-bd.php";
require "src/modelo/Video.php";
require "src/repositorio/VideoRepositorio.php";

$videoRepositorio = new VideoRepositorio($pdo);

// Recebe id_curso enviado pela URL
$idCurso = $_GET['id_curso'] ?? null;

if (!$idCurso) {
    die("ID do curso não informado.");
}

// Mensagem de sucesso / erro
$sucesso = false;
$erro = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $descricao = trim($_POST['descricao'] ?? '');
    $codigo = trim($_POST['codigo'] ?? '');
    $idCurso = $_POST['id_curso'];

    // Validação simples
    if ($descricao === '' || $codigo === '') {
        $erro = "Preencha todos os campos!";
    } else {

        // Criar objeto Video
        $video = new Video();
        $video->setDescricao($descricao);
        $video->setCodigo($codigo);
        $video->setCursoId($idCurso);

        // Salvar no banco
        if ($videoRepositorio->adicionar($video)) {
            $sucesso = true;
        } else {
            $erro = "Erro ao salvar vídeo no banco de dados.";
        }
    }

    header("Location: admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Adicionar Vídeo</title>
    <link rel="stylesheet" href="assets/css/cadastrar.css">
</head>
<body>
    <div id="productModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="window.location.href='admin.php?id_curso=<?= $idCurso ?>'">&times;</span>
            <h2>Adicionar Novo Vídeo</h2>

            <?php if ($erro): ?>
                <div class="error-message">❌ <?= htmlspecialchars($erro) ?></div>
            <?php endif; ?>

            <?php if ($sucesso): ?>
                <div class="success-message">✅ Vídeo cadastrado com sucesso!</div>
            <?php endif; ?>

            <form id="productForm" method="post">
                <input type="hidden" name="id_curso" value="<?= $idCurso ?>">

                <div class="form-group">
                    <label for="descricao">Descrição:</label>
                    <textarea id="descricao" name="descricao" rows="4" required placeholder="Digite uma descrição...">
                        <?= htmlspecialchars($_POST['descricao'] ?? '') ?>
                    </textarea>
                </div>

                <div class="form-group">
                    <label for="codigo">Código do Vídeo:</label>
                    <input 
                        type="text" 
                        id="codigo" 
                        name="codigo" 
                        required 
                        placeholder="Cole aqui o código / URL / ID do vídeo"
                        value="<?= htmlspecialchars($_POST['codigo'] ?? '') ?>"
                    >
                </div>

                <button type="submit" name="cadastro" class="submit-btn">Salvar vídeo</button>
            </form>
        </div>
    </div>
</body>
</html>
