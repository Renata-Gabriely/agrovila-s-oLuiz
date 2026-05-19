<?php
require "src/conexao-bd.php";
require "src/modelo/Produto.php";
require "src/repositorio/ProdutoRepositorio.php";

$produtoRepositorio = new ProdutoRepositorio($pdo);
$produto = $produtoRepositorio->buscarPorCodigo($_GET['codigo']);

if (!$produto) {
    die("Produto não encontrado!");
}

if (isset($_POST['cadastro'])) {

    // Se o usuário enviou uma nova imagem
    if (!empty($_FILES['img_file']['name'])) {

        $nomeTemp = $_FILES['img_file']['tmp_name'];
        $nomeFinal = 'uploads/' . basename($_FILES['img_file']['name']);

        if (!is_dir('uploads')) {
            mkdir('uploads', 0777, true);
        }

        move_uploaded_file($nomeTemp, $nomeFinal);

        $img = $nomeFinal;

    } else {
        // Mantém a imagem antiga
        $img = $produto->getImg();
    }

    // Criar objeto atualizado
    $produtoAtualizado = new Produto(
        $produto->getCodigo(),
        $_POST['nome'],
        $_POST['categoria'],
        $_POST['preco'],
        $img
    );

    // Atualizar no BD
    $produtoRepositorio->atualizar($produtoAtualizado);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Produto</title>
    <link rel="stylesheet" href="assets/css/cadastrar.css">
</head>

<body>
    <div id="newsModal" class="modal">
        <div class="modal-content">
            <a href="admin.php"><span class="close">&times;</span></a>
            <h2>Editar Produto</h2>

            <div id="successMessage" class="success-message">
                Produto editado com sucesso!
            </div>

            <form id="productForm" method="post" action="" enctype="multipart/form-data">

                <div class="form-group">
                    <label>Imagem atual:</label><br>
                    <img src="<?= htmlspecialchars($produto->getImg()) ?>" 
                         alt="Imagem atual" 
                         style="width:180px; border-radius:8px; margin-bottom:10px;">
                </div>

                <div class="form-group">
                    <label for="productFile">Enviar nova imagem:</label>
                    <input type="file" id="productFile" name="img_file" accept="image/*">
                </div>

                <div class="form-group">
                    <label for="productName">Nome:</label>
                    <input type="text" id="productName" name="nome" required
                           value="<?= htmlspecialchars($produto->getNome()) ?>">
                </div>

                <div class="form-group">
                    <label for="productCategory">Categoria:</label>
                    <input type="text" id="productCategory" name="categoria" required
                           value="<?= htmlspecialchars($produto->getCategoria()) ?>">
                </div>

                <div class="form-group">
                    <label for="productPrice">Preço:</label>
                    <input type="text" id="productPrice" name="preco" required
                           value="<?= htmlspecialchars($produto->getPreco()) ?>">
                </div>

                <button type="submit" name="cadastro" class="submit-btn">Salvar Alterações</button>
            </form>
        </div>
    </div>
</body>
</html>