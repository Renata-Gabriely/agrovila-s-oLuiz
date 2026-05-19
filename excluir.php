<?php
require "src/conexao-bd.php";
require "src/modelo/Noticia.php";
require "src/repositorio/NoticiaRepositorio.php";

$noticiaRepositorio = new NoticiaRepositorio($pdo);
$noticiaRepositorio->deletarNoticia($_POST['codigo']);

header("Location: admin.php");