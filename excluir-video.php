<?php
require "src/conexao-bd.php";
require "src/modelo/Video.php";
require "src/repositorio/VideoRepositorio.php";

// Verifica se o ID foi enviado
if (!isset($_POST['id']) || empty($_POST['id'])) {
    die("Erro: ID do vídeo não enviado.");
}

$videoId = $_POST['id'];

$videoRepositorio = new VideoRepositorio($pdo);

// Executa a exclusão
$videoRepositorio->deletarVideo($videoId);

// Redireciona para a área administrativa
header("Location: admin.php");
exit;
