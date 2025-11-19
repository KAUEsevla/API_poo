<?php 

    header("Content-Type: application/json");
    header("Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE");

    include_once ('Database.php');
    include_once ('Produto.php');

    $db = new Database();
    $produtos = new Produto ($db);

    $method = $_SERVER['REQUEST_METHOD'];
    $input = json_decode(file_get_contents('php://input'), true);

    switch ($method) {
        case 'GET':

            if(isset($_GET["id"])) {
                $id = $_GET['id'];
                $idprod = $produtos -> findById($id);

                if($idprod){
                    http_response_code(200);
                    echo json_encode($idprod);
                }else{
                    echo json_encode(["message" => "Produto não encontrado!"]);
                }
            }else{
                $prod = $produtos -> getAll();
                if($prod > 0) {
                    $codigo = 200;
                    http_response_code($codigo);
                    echo json_encode($prod);
                }else{
                    echo json_encode(["message" => "Nenhum produto encontrado!"]);
                }
            }
            break;
        
        case 'POST':
            if(!isset($input["descri"], $input["preco"])){
                http_response_code(400);
                echo json_encode(["error" => "Campos 'descri' e 'preco' são obrigatórios"]);
            }else{
                $novoId = $produtos -> create($input);
                http_response_code(200);
                echo json_encode($novoId);
            }
            break;

        case 'PUT':
            if(!isset($input["descri"], $input["preco"])){
                http_response_code(400);
                echo json_encode(["error" => "Informe o iD do produto"]);
            }else{
                $id = $_GET['id'];

                if(!isset($input["descri"], $input["preco"])){
                    http_response_code(400);
                    echo json_encode(["error" => "Campos 'descri' e 'preco' são obrigatórios"]);
                }else{
                    $prodAtt = $produtos -> update($id, $input);
                    if($prodAtt){
                        http_response_code(200);
                        echo json_encode(["message" => "Produto atualizado com sucesso!"]);
                    }else{http_response_code(404);
                        echo json_encode(["error" => "Produto não encontrado!"]);
                    }
            }

        default:
            $codigo = 405;
            http_response_code($codigo);
            echo json_encode(["erro" => "Método não autorizado!"]);
            break;}



?>