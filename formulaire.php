<?php


// connexion a la base de donnée

$pdo = new PDO(
    "mysql:host=localhost;dbname=tchat;charset=UTF8",
    "root",
    "",
    [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]
            );


$task = "list";

if(isset($_GET['task'])){
    $task = $_GET['task'];
}


if($task == "write"){
    postMessage();
}else{
    getMessages();
}



function getMessages(){
    global $pdo;

    $resultats = $pdo->query('SELECT * FROM messages ORDER BY date DESC LIMIT 20  ');

    $messages = $resultats->fetchAll();

    echo json_encode($messages);
}


function postMessage(){
    global $pdo;

    if(!isset($_POST['pseudo']) || !isset($_POST['message']) || empty($_POST['pseudo'])){
        echo json_encode(['status' => "error ", "message" => 'Problème sur vos données']);
        return;
    }

    $pseudo = $_POST['pseudo'];
    $message = $_POST['message'];

    $query = $pdo->prepare('INSERT INTO messages SET pseudo=:pseudo, content=:content , date = NOW()');

    $query->execute([
        ':pseudo' => $pseudo,
        ':content' => $message, 
    ]);

    echo json_encode(['status' => "success"]);

}