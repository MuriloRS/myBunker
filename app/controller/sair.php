<?php
    session_start();

    unset($_SESSION['email']);
    unset($_SESSION['senha']);
    unset($_SESSION['tipo_usuario']);
    unset($_SESSION['login']);

    header('Location: index.php');

?>