<?php

class Dados{

    private $pdo;

    //é a conexão com o banco de dados

    public function __construct(){
        $dbname = 'banco_soares';
        $dbuser = 'root';
        $dbpass = '';

        $this->pdo = new PDO("mysql:dbname=".$dbname.";host=localhost;", $dbuser, $dbpass);
    }

    public function adicionar($post){
        
        if($this->verificarEmail($post['email'])){

            $sql = "INSERT INTO usuarios (nome, email, telefone, comentario, receita, criado) VALUES (:nome, :email, :telefone, :comentario, :receita, :criado)";

            //$sql é o nome da função 
            //bindaValue troca o valor de VALUES por outro 

            $sql = $this->pdo->prepare($sql);
            $sql->bindValue(':nome', $post['nome']);
            $sql->bindValue(':email', $post['email']);
            $sql->bindValue(':telefone', $post['telefone']);
            $sql->bindValue(':comentario', $post['comentario']);
            $sql->bindValue(':receita', $post['receita']);
            $sql->bindValue(':criado', $post['criado']);
            $sql->execute();

            echo "200"; //sucesso
        }else{
            echo '302'; //email ja existente
        }

    }

    private function verificarEmail($email){
        
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $sql = $this->pdo->prepare($sql);
        $sql->bindValue(':email', $email);
        $sql->execute();

        if($sql->rowCount() > 0){
            return false;
        }else{
            return true;
        }

    }

    public function saveImg($img, $type){
        $tipo = explode('/', $type); //image/png
        $tipo = $tipo[1];
        $nome_arquivo = md5(time().rand(1, 99999)).'.'.$tipo;
        $path = '../assets/images/'.$nome_arquivo;

        move_uploaded_file($img, $path);
        return $nome_arquivo;

    }





}