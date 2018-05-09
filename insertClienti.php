<?php
/**
 * Created by PhpStorm.
 * User: soarebianca
 * Date: 27/03/2018
 * Time: 14:45
 */



require_once __DIR__ . '/configDb.php';
require_once __DIR__ . '/DatabaseConnection.php';

$erorrs = [];

if (isset($_POST["buton"])) {

    if ("" !== $_POST["nume"]) {
        $nume = $_POST["nume"];
        if (!preg_match('/^[-a-zA-z\s]{3,15}$/', $nume)) {
            $erorrs["nume"] = 'Nume invalid';
        }
    }

    if ("" !== $_POST["prenume"]) {
        $prenume = $_POST["prenume"];
        if (!preg_match('/^[-a-zA-z\s]{3,15}$/', $prenume)) {
            $erorrs["prenume"] = 'Prenume invalid';
        }
    }

    if ("" !== $_POST["email"]) {
        $email = $_POST["email"];
        if (!preg_match('/^[-._a-z0-9]+@[-.a-z0-9]+\.[a-z]{2,4}$/', $email)) {
            $erorrs["email"] = 'Email invalid';
        }
    }
}

if (isset($erorrs)) {
    echo implode("<br/>", $erorrs);
}

if (isset($_POST["buton"]) && !count($erorrs)) {
    /** @var PDO $dbh */
    $dbh = DatabaseConnection::getConnection($configDb);


    $sql = "INSERT INTO clienti (nume, prenume, email) VALUES (:prenume, :nume, :email)";
    $stmt = $dbh->prepare($sql);
    $valori = [
        'nume' => $_POST["nume"],
        'prenume' => $_POST["prenume"],
        'email' => $_POST["email"]
    ];
    $stmt->execute($valori);

    echo "S-a inserat clientul $nume $prenume cu id-ul ".$dbh->lastInsertId();
}

?>




<form method="POST" action="">
    <label for="nume">Nume:</label>
    <input id="nume" type="text" name="nume" value="" required="required"/><br/>
    <label for="prenume">Prenume:</label>
    <input id="prenume" type="text" name="prenume" value="" required="required"/><br/>
    <label for="email">Email:</label>
    <input id="email" type="text" name="email" value="" required="required"/><br/>
    <input type="submit" name="buton" value="TRIMITE"/>
</form>
