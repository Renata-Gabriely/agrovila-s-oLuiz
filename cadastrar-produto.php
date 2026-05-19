<?php
require "src/conexao-bd.php";
require "src/modelo/Produto.php";
require "src/repositorio/ProdutoRepositorio.php";
$produtoRepositorio = new ProdutoRepositorio($pdo);

if (isset($_POST['cadastro'])) {

    $diretorio = "uploads/produtos/";

    if (!is_dir($diretorio)) {
        mkdir($diretorio, 0777, true);
    }

    if (isset($_FILES['img']) && $_FILES['img']['error'] === UPLOAD_ERR_OK) {

        $nomeTemp = $_FILES['img']['tmp_name'];
        $nomeOriginal = basename($_FILES['img']['name']);
        $extensao = pathinfo($nomeOriginal, PATHINFO_EXTENSION);

        $novoNome = uniqid("produto_", true) . "." . strtolower($extensao);
        $caminhoFinal = $diretorio . $novoNome;

        if (move_uploaded_file($nomeTemp, $caminhoFinal)) {

            $preco = (float) str_replace(',', '.', $_POST['preco']);

            $produto = new Produto(
                0,
                $_POST['nome'],
                $_POST['categoria'],
                $preco,
                $caminhoFinal
            );

            try {
                $produtoRepositorio->salvarProduto($produto);
                header("Location: admin.php?sucesso=1");
                exit;
            } catch (Exception $e) {
                $erro = "Erro no banco: " . $e->getMessage();
            }

        } else {
            $erro = "Falha ao mover arquivo.";
        }

    } else {
        $erro = "Erro upload: " . $_FILES['img']['error'];
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agrovila São Luiz - Novo Produto</title>
    <link rel="stylesheet" href="assets/css/cadastrar.css">
</head>
<body>
    <div id="productModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="window.location.href='admin.php'">&times;</span>
            <h2>Adicionar Novo Produto</h2>

            <?php if (isset($erro)): ?>
                <div class="error-message">❌ <?= htmlspecialchars($erro) ?></div>
            <?php endif; ?>

            <?php if (isset($_GET['sucesso'])): ?>
                <div class="success-message">✅ Produto cadastrado com sucesso!</div>
            <?php endif; ?>

            <!-- Formulário de cadastro -->
            <form id="productForm" method="post" action="" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="productImage">Imagem do Produto:</label>
                    <input type="file" id="productImage" name="img" accept="image/*" required>
                </div>

                <div class="form-group">
                    <label for="productName">Nome do Produto:</label>
                    <input type="text" id="productName" name="nome" required placeholder="Digite o nome do produto...">
                </div>

                <div class="form-group">
                    <label for="productCategory">Categoria:</label>
                    <input type="text" id="productCategory" name="categoria" required placeholder="Ex: Raízes e Derivados, Frutas...">
                </div>

                <div class="form-group">
                    <label for="productPrice">Preço (R$):</label>
                    <input type="number" step="0.01" id="productPrice" name="preco" required placeholder="Digite o preço do produto...">
                </div>

                <button type="submit" name="cadastro" class="submit-btn">Cadastrar Produto</button>
            </form>
        </div>
    </div>
</body>
</html>