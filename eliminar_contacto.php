<?php

use sys4soft\Database;

require_once('header.php');

if(empty($_GET['id'])){
    header('Location: index.php');
}

require_once('config.php');
require_once('libraries/Database.php');

$id = $_GET['id'];
$database = new Database(MYSQL_CONFIG);
$params = [
    ':id'=>$id
];

if(empty($_GET['delete'])){
    $results = $database->execute_query("SELECT * FROM ninjas WHERE id = :id", $params);
    $ninja = $results->results[0];
}else{
    $database->execute_non_query("DELETE FROM ninjas WHERE id = :id", $params);
    header('Location: index.php');
}
?>

<div class="row">
    <div class="col text-center">
        <h3>Deseja eliminar este ninja?</h3>

        <div class="my-4">
            <div>
                <span class="me-5">Nome: <strong> <?=$ninja->nome?> </strong></span>
                <span>Telefone: <strong> <?=$ninja->telefone?> </strong></span>
            </div>
        </div>

        <a href="index.php" class="btn btn-outline-dark yes-no-width">Não</a>
        <a href="eliminar_contacto.php?id=<?=$id?>&delete=yes" class="btn btn-outline-dark yes-no-width">Sim</a>
    </div>
</div>

<?php
require_once('footer.php');
?>