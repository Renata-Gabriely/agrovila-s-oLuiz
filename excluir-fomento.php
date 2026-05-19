<?php
// Arquivo: deletar-fomento.php (ou similar)
require "src/conexao-bd.php";
require "src/modelo/Fomento.php";
require "src/repositorio/FomentoRepositorio.php";

// Verifica se o código foi enviado e é um número (boa prática)
if (isset($_POST['codigo']) && is_numeric($_POST['codigo'])) {
    $fomentoRepositorio = new FomentoRepositorio($pdo);
    $fomentoRepositorio->deletarFomento((int)$_POST['codigo']);
}

// Redireciona para a página administrativa após a exclusão
header("Location: admin.php");
exit(); // Garante que o script pare a execução após o redirecionamento