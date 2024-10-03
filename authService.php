<?php

session_start();
require_once 'Backend/entity/Usuario.php';
require_once 'Backend/dao/UsuarioDAO.php';

$type = filter_input(INPUT_POST, "type");

if ($type === "register") {
    //// Cadastro de Usuario

    // Recebimento de dados vindos por input do HTML
    $new_nome = filter_input(INPUT_POST, "new_nome");
    $new_email = filter_input(INPUT_POST, "new_email", FILTER_SANITIZE_EMAIL);
    $new_password = filter_input(INPUT_POST, "new_password");
    $confirm_password = filter_input(INPUT_POST, "confirm_password");

    // Verificação dos dados informados
    if ($new_email && $new_nome && $new_password) {
        if ($new_password === $confirm_password) {
            // Etapa de segurança: criação de senha segura e geração de token
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $token = bin2hex(random_bytes(25));
            
            // Criação do Usuário no banco de dados por uso do UsuarioDAO
            $usuario = new Usuario(null, $new_nome, $hashed_password, $new_email, $token);
            $usuarioDAO = new UsuarioDAO();

            if(!$usuarioDAO->getByEmail($new_email)) {
                $success = $usuarioDAO->create($usuario);

                if($success) {
                    $_SESSION['token'] = $token;
                    header('Location: index.php');  
                    exit();
                } else {
                    echo "Erro ao registrar no banco de dados!";
                    exit();
                }
            } else {
                echo "Email já utilizado";
            }
        } else {
            echo "Senhas incompatíveis!";
        }
    } else {
        echo "Dados de input inválidos!";
    }
} elseif ($type === "login") {
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, "password");

    $usuarioDAO = new UsuarioDAO();
    $usuario = $usuarioDAO->getByEmail($email);

    if($usuario) {
        if(password_verify($password, $usuario->getSenha())) {
            $token = bin2hex(random_bytes(25));
            $usuarioDAO->updateToken($usuario->getId(), $token);
            $_SESSION['token'] = $token;
            header('Location: index.php');
            exit();
        } else {
            echo "Senha inválida!";
        }
    } else {
        echo "Email não encontrado!";
    }
} elseif ($type === "logout") {
    $_SESSION = array();
    session_destroy();
    header('Location: ./login.php');
    exit();
}

?>