<?php
/**
 * Created by PhpStorm.
 * User: soarebianca
 * Date: 27/03/2018
 * Time: 15:10
 */


require_once __DIR__ . '/configDb.php';
require_once __DIR__ . '/DatabaseConnection.php';

$erorrs = [];

/** @var PDO $dbh */
$dbh = DatabaseConnection::getConnection($configDb);
//cu functia predefinita setAttribute imi aarata in browser eroarea sql daca exista
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "SELECT * FROM clienti";

$stmt = $dbh->prepare($sql);

$stmt->execute();

$clienti = $stmt->fetchAll(PDO::FETCH_ASSOC);

//var_dump($clienti);



$sql = "SELECT * FROM produse";

$stmt = $dbh->prepare($sql);

$stmt->execute();

$produse = $stmt->fetchAll(PDO::FETCH_ASSOC);

//var_dump($produse);

if (isset($_POST["buton"])) {

    if ("" !== $_POST["comanda"]) {
        $comanda = $_POST["comanda"];
        if (!preg_match('/^[-a-zA-z\s]{3,15}$/', $comanda)) {
            $erorrs["comanda"] = 'Comanda invalida';
        } else {
            $sql = "INSERT INTO comenzi (clienti_id, produse_id, comanda) VALUES (:clienti_id, :produse_id, :comanda)";
            $stmt = $dbh->prepare($sql);
            $valori = [
                "comanda" => $_POST["comanda"],
                "clienti_id" => $_POST["client"],
                "produse_id" => $_POST["produs"]
            ];
            $stmt->execute($valori);

            echo "S-a inserat comanda $comanda cu id-ul " . $dbh->lastInsertId();
        }
    }

}


if (isset($erorrs)) {
    echo implode("<br/>", $erorrs);
}


?>

<form method="POST" action="">
    <label for="comanda">Nume Comanda:</label>
    <input id="comanda" type="text" name="comanda" value="" required="required"/><br/>

    <label for="client">Client:</label>
    <select id="client" name="client">
        <?php foreach ($clienti as $client) { ?>
            <option value="<?php echo $client["id"] ?>"
                <?php if (array_key_exists("client",$_POST) && $client["id"] == $_POST["client"]) echo 'selected';?>>
            <?php echo $client["nume"]." ".$client["prenume"] ?> </option>
        <?php } ?>

    </select><br/>

    <label for="produs">Produs:</label>
    <select id="produs" name="produs">
        <?php foreach ($produse as $produs) { ?>
        <option value="<?php echo $produs["id"] ?>"
            <?php if (array_key_exists("produs",$_POST) && $produs["id"] == $_POST["produs"]) echo 'selected';?>>
         <?php echo $produs["denumire"] ?> </option>
        <?php }  ?>
    </select><br/>

    <input type="submit" name="buton" value="TRIMITE"/>
</form>