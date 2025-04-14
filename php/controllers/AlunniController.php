<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AlunniController{

  //SELECT all -> get
  public function index(Request $request, Response $response, $args){
    $db = Db::getInstance();

    $result = $db->query("select * from alunni a where a.classe_id = " . $args["id"] . "");
    $results = $result->fetch_all(MYSQLI_ASSOC);
    $response->getBody()->write(json_encode($results));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

  //SELECT where --> get
  public function show(Request $request, Response $response, $args){
    $db = Db::getInstance();
    
    $result = $db->query("select * from alunni a where a.classe_id = " . $args["id2"] . " and a.id =". $args["id"]);
  
    if($results = $result->fetch_all(MYSQLI_ASSOC)){
        $response->getBody()->write(json_encode($results));
        return $response->withHeader("Content-type", "application/json")->withStatus(200);
      }
      else{
        $response->getBody()->write('{"msg": "Not Found"}');
        return $response->withHeader("Content-type", "application/json")->withStatus(404);
      }
  } 

  //CREATE --> post
  public function create(Request $request, Response $response, $args){
    $db = Db::getInstance();
    $body = json_decode($request->getBody()->getContents(), true);
    $nome= $body["nome"];
    $cognome = $body["cognome"];
    $classe_id = $body["classe_id"];

    $result = $db->query("INSERT INTO `alunni` (`nome`, `cognome`, `classe_id`) VALUES ('$nome', '$cognome', $classe_id),");

    if($db->affected_rows > 0){
      $results = ["msg" => "OK"];
      $response->getBody()->write(json_encode($results));
      return $response->withHeader("Content-type", "application/json")->withStatus(201);
    } 

    $results = ["msg" => "KO"];
    $response->getBody()->write(json_encode($results));
    return $response->withHeader("Content-type", "application/json")->withStatus(400);
  }

  //UPDATE --> put
  public function update(Request $request, Response $response, $args){
    $db = Db::getInstance();
    $body = json_decode($request->getBody()->getContents(),true);
    $nome= $body["nome"];
    $cognome = $body["cognome"];
    $classe_id = $body["classe_id"];

    $result = $db->query("UPDATE alunni SET nome = '$nome', cognome = '$cognome'  WHERE id = '".$args["id"]."' ;");
    
    if($db->affected_rows > 0){
      $results = ["msg" => "OK"];
      $response->getBody()->write(json_encode($results));
      return $response->withHeader("Content-type", "application/json")->withStatus(201);
    } 

    $results = ["msg" => "KO"];
    $response->getBody()->write(json_encode($results));
    return $response->withHeader("Content-type", "application/json")->withStatus(400);
  }
  
  //DELETE --> delete
  
  public function destroy(Request $request, Response $response, $args){
    $db = Db::getInstance();
    $id=$args["id"];
    $classe_id = $args["id2"];
    $result = $db->query("DELETE FROM alunni WHERE id = '$id' and classe_id = '$classe_id';");

    if($db->affected_rows > 0){
      $results = ["msg" => "OK"];
      $response->getBody()->write(json_encode($results));
      return $response->withHeader("Conent-type", "application/json")->withStatus(201);
    } 

    $results = ["msg" => "KO"];
    $response->getBody()->write(json_encode($results));
    return $response->withHeader("Conent-type", "application/json")->withStatus(400);
  }
}
