<?php
// Arquivo: excluir-curso.php
require "src/conexao-bd.php";
require "src/modelo/Curso.php";
require "src/repositorio/CursoRepositorio.php";

// Verifica se o ID foi enviado e é válido
if (isset($_POST['id']) && is_numeric($_POST['id'])) {
    $cursoRepositorio = new CursoRepositorio($pdo);
    $cursoRepositorio->deletar((int)$_POST['id']);
}

// Redireciona para o painel admin
header("Location: admin.php");
exit();
