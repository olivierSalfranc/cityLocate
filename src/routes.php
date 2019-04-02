<?php

use Slim\Http\Request;
use Slim\Http\Response;

$token = sha1(date("Y-m-d"));
$container = $app->getContainer();
$container['pdo']=function (){
    return new PDO('mysql:dbname=olivier;host=localhost','olivier','3003');
};



$app->get('/[{name}]', function (Request $request, Response $response, array $args) {
    // Sample log message
    $this->logger->info("Slim-Skeleton '/' route");

    // Render index view
    return $this->renderer->render($response, 'index.phtml', $args);
});



$app->post('/play/games', function (Request $request, Response $response, array $args) use ($token) {
    $user = $request->getParsedBody();

    if ($user['ville']=="lyon") $req=$this->pdo->prepare("select * from ville where id=1;");
    else $req=$this->pdo->prepare("select * from ville where id=2;");
    $req->execute();
    $ville=$req->fetch();


    if ($user['ville']=="lyon") $req=$this->pdo->prepare("select * from images where idVille=1;");
    else $req=$this->pdo->prepare("select * from images where idVille=2;");

    $req->execute();
    $tab=$req->fetchAll();
    return $response->withJson(array('images'=>$tab,'ville'=>$ville));
});


$app->post('/bestScore', function (Request $request, Response $response, array $args) use ($token) {
    $tab = $request->getParsedBody();
    $pseudo=$tab['psuedo'];
    $score=$tab['score'];
    if ($tab['ville']=="lyon") $req=$this->pdo->prepare("INSERT INTO `partie` (`id`, `nomJoueur`, `score`, `idVille`) VALUES (NULL, '$pseudo', $score, 1);");
    else $req=$this->pdo->prepare("INSERT INTO `partie` (`id`, `nomJoueur`, `score`, `idVille`) VALUES (NULL, '$pseudo', $score, 2);");

    $req->execute();


    if ($tab['ville']=="lyon") $req=$this->pdo->prepare("select * from partie where idVille=1 order by score DESC ;");
    else $req=$this->pdo->prepare("select * from partie where idVille=2 order by score DESC ;");
    $req->execute();
    $tab=$req->fetchAll();
    if (sizeof($tab)>10){
        $tab=array_slice($tab,0,9);
    }
    return $response->withJson($tab);




});


