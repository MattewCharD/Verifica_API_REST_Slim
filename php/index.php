<?php
use Slim\Factory\AppFactory;

require __DIR__ . '/vendor/autoload.php';
require __DIR__ . '/controllers/AlunniController.php';
require __DIR__ . '/controllers/ClassiController.php';
require __DIR__ . '/includes/Db.php';

$app = AppFactory::create();

//---------------Classi---------------------

// curl http://localhost:8080/classi
$app->get('/classi', "ClassiController:index");

// curl http://localhost:8080/classi/2
$app->get('/classi/{id}', "ClassiController:show");

// curl -X POST http://localhost:8080/classi -H "Content-Type: application/json" -d '{"sezione" : "4C" , "anno": "2020"}';
$app->post('/classi', "ClassiController:create");

// curl -X PUT http://localhost:8080/classi/2 -H "Content-Type: application/json" -d '{"sezione" : "3A" , "anno": "2024"}';
$app->put('/classi/{id}', "ClassiController:update");

// curl -X DELETE http://localhost:8080/classi/2
$app->delete('/classi/{id}', "ClassiController:destroy");

//---------------Alunni---------------------

// curl http://localhost:8080/classi/2/alunni
$app->get('/classi/{id}/alunni', "AlunniController:index");

// curl http://localhost:8080/classi/2/alunni/1
$app->get('/classi/{id}/alunni/{id2}', "AlunniController:show");

// curl -X POST http://localhost:8080/classi/2/alunni -H "Content-Type: application/json" -d '{"classe_id" : 1 , "nome" : "ciccio" , "cognome": "bello"  }';
$app->post('classi/{id}/alunni', "AlunniController:create");

// curl -X PUT http://localhost:8080/classi/2/alunni/1 -H "Content-Type: application/json" -d '{"classe_id" : 1 , "nome" : "ciccio" , "cognome": "bello"  }';
$app->put('/classi/{id}/alunni/{id2}', "AlunniController:update");

// curl -X DELETE http://localhost:8080/classi/2/alunni/1
$app->delete('/classi/{id}/alunni/{id2}', "AlunniController:destroy");

$app->run();
