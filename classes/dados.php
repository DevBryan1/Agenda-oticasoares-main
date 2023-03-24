<?php

//conexão de 1 pagina para outra
require('config.php');

//seta o horário igual o de SP
date_default_timezone_set('America/Sao_Paulo');


//puxa a classe do config.php
$dados = new Dados();

if(isset($_POST['name']) && !empty($_POST['name'])){

    if(isset($_FILES['arquivo'])){
        $file = $_FILES['arquivo'];

        if($file['error'] == 0){
            //tudo certo
            $img = $dados->saveImg($file['tmp_name'], $file['type']);
        }else{
            //tudo errado
            $img = 'null';
        }
    }else{
        $img = 'null';
    }

    
    $post = [
        'nome' => filter_var($_POST['name'], FILTER_SANITIZE_SPECIAL_CHARS),
        'email' => filter_var($_POST['email'], FILTER_SANITIZE_SPECIAL_CHARS),
        'telefone' => filter_var($_POST['telefone'], FILTER_SANITIZE_SPECIAL_CHARS),
        'comentario' => filter_var($_POST['comentario'], FILTER_SANITIZE_SPECIAL_CHARS),
        'receita' => $img,
        'criado' => date('Y-m-d H:i:s')
    ];
    

 $dados->adicionar($post);

}else{
    echo "404"; //sem dados
}