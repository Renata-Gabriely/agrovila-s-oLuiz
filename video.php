<?php
require "../src/conexao-bd.php";
require "../src/repositorio/VideoRepositorio.php";

header("Content-Type: application/json");

$videoRepo = new VideoRepositorio($pdo);

$idCurso = $_GET["id"] ?? null;

if (!$idCurso) {
    echo json_encode([]);
    exit;
}

$videos = $videoRepo->buscarPorCurso($idCurso);
echo json_encode($videos);

