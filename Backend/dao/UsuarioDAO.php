<?php

require_once "Backend/config/Database.php";
require_once "BaseDAO.php";
require_once "Backend/entity/Usuario.php";


class UsuarioDAO
{
    
    private $db;

    public function __construct()
    {
        $this->db = Database::getInstance();
    }

    public function getAll() {
        try {
            $sql = "SELECT * FROM usuario";
            $stmt = $this->db->prepare($sql);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return array_map(function($usuario) {
                return new Usuario($usuario['id'],
                                   $usuario['nome'],
                                   $usuario['senha'],
                                   $usuario['email'],
                                   $usuario['token']);
            }, $result);
        } catch(PDOException $e) {
            return false;
        }
    }

    public function getById($id) {
        try{
            $sql = "SELECT * FROM usuario WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam('id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            return $usuario ? new Usuario(
                $usuario['id'],
                $usuario['nome'],
                $usuario['senha'],
                $usuario['email'],
                $usuario['token']
            ) : null;

        } catch (PDOException $e) {
            return false;
        }
    }

    public function create($usuario)
    {
        try {
            $sql = "INSERT INTO usuario (nome, senha, email, token)
                    VALUES (:nome, :senha, :email, :token)";
            $stmt = $this->db->prepare($sql);

            $nome = $usuario->getNome();
            $senha = $usuario->getSenha();
            $email = $usuario->getEmail();
            $token = $usuario->getToken(); 

            $stmt->bindParam(':nome', $nome);
            $stmt->bindParam(':senha', $senha);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':token', $token);

            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function update($usuario) {
        try{

            $id = $usuario->getId();
            $nome = $usuario->getNome();
            $email = $usuario->getEmail();

            $sql = "UPDATE INTO usuario SET nome = :nome, email = :mail WHERE id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
            $stmt->bindParam(':email', $email, PDO::PARAM_STR);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            return true;
        } catch(PDOException) {
            return false;
        }
    }

    public function getByEmail($email)
    {
        try {
            $sql = "SELECT * FROM usuario WHERE email = :email";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            $usuario = $stmt->fetch(PDO::FETCH_ASSOC);

            return $usuario ? new Usuario(
                $usuario['id'],
                $usuario['nome'],
                $usuario['senha'],
                $usuario['email'],
                $usuario['token']
            ) : null;
        } catch (PDOException $e) {
            return null;
        }
    }

    public function updateToken($id, $token)
    {
        try {
            $sql = "UPDATE usuario SET token = :token WHERE id = :id";
            $stmt = $this->db->prepare($sql);

            $stmt->bindParam(':id', $id);
            $stmt->bindParam(':token', $token);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function delete($email) {
        try{

            $emailValido = htmlspecialchars($email, ENT_NOQUOTES);

            $sql = "DELETE FROM usuario WHERE email = :email";
            $stmt = $this->db->prepare($sql);
            $stmt->bindparam(':email', $emailValido);
            $stmt->execute();

            return true;
        } catch(PDOException) {
            return false;
        }
    }
}