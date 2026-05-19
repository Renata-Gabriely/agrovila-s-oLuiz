<?php
require "src/conexao-bd.php";
require "src/modelo/Curso.php";
require "src/repositorio/CursoRepositorio.php";

$cursoRepositorio = new CursoRepositorio($pdo);

// Verifica se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $titulo = $_POST['titulo'] ?? '';
    $descricao = $_POST['descricao'] ?? '';

    if (!empty($titulo) && !empty($descricao)) {

        $curso = new Curso();
        $curso->setTitulo($titulo);
        $curso->setDescricao($descricao);

        $cursoRepositorio->adicionar($curso);

        header("Location: admin.php?sucesso=1");
        exit;

    } else {
        $erro = "Preencha todos os campos!";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agrovila São Luiz - Novo Curso</title>
    <link rel="stylesheet" href="assets/css/cadastrar.css">
</head>
<body>
    <div id="productModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="window.location.href='admin.php'">&times;</span>
            <h2>Adicionar Novo Curso</h2>

            <?php if (isset($erro)): ?>
                <div class="error-message">❌ <?= htmlspecialchars($erro) ?></div>
            <?php endif; ?>

            <?php if (isset($_GET['sucesso'])): ?>
                <div class="success-message">✅ Curso cadastrado com sucesso!</div>
            <?php endif; ?>

            <!-- Formulário de cadastro -->
          <form id="productForm" method="post" action="cadastrar-curso.php">


                
                <div class="form-group">
                    <label for="titulo">Título do Curso:</label>
                    <input type="text" id="titulo" name="titulo" required placeholder="Digite o título do curso...">
                </div>

                <div class="form-group">
                    <label for="descricao">Descrição:</label>
                    <textarea id="descricao" name="descricao" rows="5" required placeholder="Digite a descrição do curso..."></textarea>
                </div>

                <button type="submit" name="cadastro" class="submit-btn">Adicionar Curso</button>
            </form>
        </div>
    </div>
</body>
</html>
