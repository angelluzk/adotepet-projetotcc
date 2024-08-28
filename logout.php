<?php
session_start(); //Inicia a sessão

//Destruir a sessão
$_SESSION = array();
session_destroy();
header("Location: index.php"); //Redirecionar para a página index
exit();
?>