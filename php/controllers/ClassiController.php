<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class ClassiController{


  //SELECT all -> get
  public function index(Request $request, Response $response, $args){
    $result = Db::getInstance()->select("classi");
    $response->getBody()->write(json_encode($result));
    return $response->withHeader("Content-type", "application/json")->withStatus(200);
  }

  //SELECT where --> get
  public function show(Request $request, Response $response, $args){
    $result = Db::getInstance()->select("classi", "id = " . $args['id']);
    $response->getBody()->write(json_encode($result));
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
    $sezione= $body["sezione"];
    $anno = $body["anno"];

    $result = $db->query("INSERT INTO classi (sezione, anno) VALUES ('$sezione', '$anno')");

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
    $sezione= $body["sezione"];
    $anno = $body["anno"];
    $id = $args["id"];

    $result = $db->query("UPDATE classi SET sezione = '$sezione', anno = '$anno' WHERE id = '$id' ;");
    
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
    $result = $db->query("DELETE FROM classi WHERE id = '$id';");

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