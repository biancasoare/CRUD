<?php
/**
 * Created by PhpStorm.
 * User: soarebianca
 * Date: 27/03/2018
 * Time: 14:45
 */



require_once __DIR__ . '/configDb.php';
require_once __DIR__ . '/DatabaseConnection.php';

/** @var PDO $dbh */
$dbh = DatabaseConnection::getConnection($configDb);
//cu functia predefinita setAttribute imi aarata in browser eroarea sql daca exista
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


$sql = "SELECT * FROM clienti";

$stmt = $dbh->prepare($sql);

$stmt->execute();

$clienti = $stmt->fetchAll(PDO::FETCH_ASSOC);

//var_dump($clienti);



if (isset($_POST["buton"])) {
    $sql = "DELETE FROM clienti WHERE id= :id";

    $stmt = $dbh->prepare($sql);
    $valori = [
        "id" => $_POST["client"],
    ];
    $stmt->execute($valori);

    echo "Record deleted successfully";
}

?>

<form method="POST" action="">

    <label for="client">Client:</label>
    <select id="client" name="client">
        <?php foreach ($clienti as $client) { ?>
            <option value="<?php echo $client["id"] ?>"> <?php echo $client["nume"]." ".$client["prenume"] ?> </option>
        <?php } ?>

    </select><br/>

    <input type="submit" name="buton" value="sterge"/>
</form>