<?php
use sys4soft\Database;

require_once('header.php');

require_once('config.php');
require_once('libraries/Database.php');

$erro = null;

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $database = new Database(MYSQL_CONFIG);

    $nome = $_POST['text_nome'];
    $telefone = $_POST['text_telefone'];

    $params = [
        ':telefone'=>$telefone
    ];
    $results = $database->execute_query("SELECT id FROM ninjas WHERE telefone = :telefone", $params);

    if($results->affected_rows != 0)
    {
        $erro = 'Já existe outro ninja com o mesmo número de telefone.';
    }else
    {
        $params = [
            ':nome'=>$nome,
            ':telefone'=>$telefone
        ];
        $results = $database->execute_non_query("INSERT INTO ninjas VALUES(0,:nome,:telefone,NOW(),NOW())",$params);

        header('Location: index.php');
    }
}

?>

<div class="row justify-content-center">
    <div class="col-sm-8 col-md-6 col-10">

        <div class="card p-4">

            <form action="adicionar_contacto.php" method="post">
                <p class="text-center"><strong>NOVO CONTATO - NINJA</strong></p>
                <div class="mb-3">
                    <label for="text_nome" class="form-label">Nome</label>
                    <input type="text" name="text_nome" id="text_nome" class="form-control" minlength="3" maxlength="50" required>
                </div>
                <div class="mb-3">
                    <label for="text_telefone" class="form-label">Telefone</label>
                    <input type="text" name="text_telefone" id="text_telefone" class="form-control" minlength="3" maxlength="12" required>
                </div>
                <div class="text-center">
                    <a href="index.php" class="btn btn-outline-dark">Cancelar</a>
                    <input type="submit" value="Guardar" class="btn btn-outline-dark">
                </div>
            </form>

        </div>

        <?php if(!empty($erro)): ?>
            <div class="mt-3 alert alert-danger p-2 text-center">
                <?= $erro?>
            </div>
        <?php endif;?>

    </div>
</div>

<?php
require_once('footer.php');
?>