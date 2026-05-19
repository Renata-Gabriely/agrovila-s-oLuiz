<?php
require "src/conexao-bd.php";
require "src/modelo/Curso.php";
require "src/repositorio/CursoRepositorio.php";

$cursoRepositorio = new CursoRepositorio($pdo);
if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("ID do curso não informado.");
}

$id = (int) $_GET['id'];
$curso = $cursoRepositorio->buscarPorId($id);



if (isset($_POST['cadastro'])) {

   
    // Cria objeto atualizado
    $cursoAtualizado = new Curso(
        $curso->getId(),
        $_POST['titulo'],
        $_POST['descricao']
    );

    $cursoRepositorio->atualizar($cursoAtualizado);
    header("Location: admin.php");
exit();
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agrovila São Luiz - Editar Curso</title>
    <link rel="stylesheet" href="assets/css/cadastrar.css">
</head>
<body>
    <div id="newsModal" class="modal">
        <div class="modal-content">
            <a href="admin.php"><span class="close">&times;</span></a>
            <h2>Editar Curso</h2>

            <div id="successMessage" class="success-message">
                Curso editado com sucesso!
            </div>

<form id="courseForm" method="post" action="" enctype="multipart/form-data">

    <div class="form-group">
        <label for="courseTitle">Título:</label>
        <input type="text" id="courseTitle" name="titulo" required
               value="<?= htmlspecialchars($curso->getTitulo()) ?>">
    </div>

    <div class="form-group">
        <label for="courseText">Descrição:</label>
        <textarea id="courseText" name="descricao" required><?= htmlspecialchars($curso->getDescricao()) ?></textarea>
    </div>

    <button type="submit" name="cadastro" class="submit-btn">Salvar Alterações</button>
</form>

        </div>
    </div>
</body>
</html>
