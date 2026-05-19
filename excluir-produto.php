<?php
require "src/conexao-bd.php";
require "src/modelo/Produto.php";
require "src/repositorio/ProdutoRepositorio.php";

$produtoRepositorio = new ProdutoRepositorio($pdo);
$produtoRepositorio->deletarProduto($_POST['codigo']);

header("Location: admin.php");