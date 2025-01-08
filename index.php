<?php

use sys4soft\Database;

require_once('header.php');

require_once('config.php');
require_once('libraries/Database.php');

$ninjas = null;
$total_ninjas = 0;
$search = null;
$database = new Database(MYSQL_CONFIG);

if($_SERVER['REQUEST_METHOD'] == 'POST'){

    $search = $_POST['text_search'];
    $params = [
        ':search' => '%' . $search . '%'
    ];
    $results = $database->execute_query(
        "SELECT * FROM ninjas WHERE nome LIKE :search OR telefone LIKE :search ORDER BY id DESC", $params);
} else {
    $results = $database->execute_query("SELECT * FROM ninjas ORDER BY id DESC");
}

$ninjas = $results->results;
$total_ninjas = $results->affected_rows;

?>

<div class="row align-items-center mb-3">
    <div class="col">

        <form action="index.php" method="post">
            <div class="row">
                <div class="col-auto"><input type="text" class="form-control" name="text_search" id="text_search" minlength="3" maxlength="20" required></div>
                <div class="col-auto"><input type="submit" class="btn btn-outline-dark" value="Procurar"></div>
                <div class="col-auto"><a href="index.php" class="btn btn-outline-dark">Ver tudo</a></div>
            </div>
        </form>

    </div>

    <div class="col text-end">
        <a href="adicionar_contacto.php" class="btn btn-outline-dark">Adicionar ninja</a>
    </div>
</div>

<div class="row">
    <div class="col">

    <?php if($total_ninjas == 0): ?>
        <p class="text-center opacity-75 mt-3">Não foram encontrados ninjas registados.</p>
    <?php else:?>
        <table class="table table-sm table-striped table-bordered">
            <thead class="bg-dark text-white">
                <tr>
                    <th width="40%">Nome</th>
                    <th width="30%">Telefone</th>
                    <th width="15%"></th>
                    <th width="15%"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($ninjas as $ninja):?>
                    <tr>
                        <td><?=$ninja->nome?></td>
                        <td><?=$ninja->telefone?></td>
                        <td class="text-center"><a href="editar_contacto.php?id=<?=$ninja->id?>">Editar</a></td>
                        <td class="text-center"><a href="eliminar_contacto.php?id=<?=$ninja->id?>">Eliminar</a></td>
                    </tr>
                <?php endforeach;?>
            </tbody>
        </table>

        <div class="row">
            <div class="col">
                <p>Total: <strong><?=$total_ninjas?></strong></p>
            </div>
        </div>
    <?php endif;?>

    </div>
</div>

<?php
require_once('footer.php');
?>