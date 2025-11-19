<?php 
    require_once 'Database.php';
    require_once 'Produto.php';

    $db = new Database();
    $produtos = new Produto($db);


    //listar todos os produtos
    $listaProd = $produtos -> getAll();

        echo"<h3>Produtos</h3><pre>"; 
        print_r($listaProd);
        echo"</pre>";

        die();


?>