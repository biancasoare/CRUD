<?php
/**
 * Created by PhpStorm.
 * User: soarebianca
 * Date: 27/03/2018
 * Time: 15:01
 */


require_once __DIR__ . '/configDb.php';
require_once __DIR__ . '/DatabaseConnection.php';

/** @var PDO $dbh */
$dbh = DatabaseConnection::getConnection($configDb);
//cu functia predefinita setAttribute imi aarata in browser eroarea sql daca exista
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "SELECT
          id,
          nume,
          prenume,
          email
        FROM clienti";

$stmt = $dbh->prepare($sql);

$stmt->execute();

$clienti= $stmt->fetchAll(PDO::FETCH_ASSOC);

//var_dump($clienti);


if (isset($_GET["editeaza"])) {
    $sql = "SELECT
              id,
              nume,
              prenume
            FROM clienti
            WHERE id=:id";
    $stmt = $dbh->prepare($sql);
    $valori = [
        'id' => $_GET['client'],
    ];
    $stmt->execute($valori);
    $client= $stmt->fetchAll(PDO::FETCH_ASSOC);

    //var_dump($client);
    //var_dump($_GET['client']);
    //echo $valori['id'];
}



$erorrs = [];

if (isset($_POST["salveaza"])) {

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
    echo "<p><b>".implode("<br/>", $erorrs)."</b></p>";
}

if (isset($_POST["salveaza"]) && !count($erorrs)) {
    /** @var PDO $dbh */
    $dbh = DatabaseConnection::getConnection($configDb);

    //fara problema de securitate
    $sql = "UPDATE clienti SET nume=:nume, prenume=:prenume, email=:email WHERE id=:id";
    $stmt = $dbh->prepare($sql);
    $valori = [
        'nume' => $_POST['nume'],
        'prenume' => $_POST['prenume'],
        'email' => $_POST['email'],
        'id' => $_GET['client'],
    ];
    $stmt->execute($valori);
    //var_dump($valori);
    echo "<p><b>Datele clientului au fost schimbate.</b></p>";

}


?>

    <form method="GET" action="">

        <label for="client">Clienti:</label>
        <select id="client" name="client">
            <?php foreach ($clienti as $key=>$client) { ?>
                <option value="<?php echo $client["id"] ?>"
                    <?php if (array_key_exists("client",$_GET) && $client["id"] == $_GET["client"]) echo 'selected';?>>
                    <?php echo "nume: ".$client["nume"].", prenume: ".$client["prenume"].", email: ".$client["email"] ?>
                </option>
            <?php } ?>
        </select><br/>

        <input type="submit" name="editeaza" value="editeaza nume"/>
    </form>


<?php if (isset($_GET["editeaza"])) { ?>
    <form method="POST" action="">

        <label for="nume">Nume nou client:</label>
        <input id="nume" type="text" name="nume" value="" required="required"/><br/>
        <label for="prenume">Prenume nou client:</label>
        <input id="prenume" type="text" name="prenume" value="" required="required"/><br/>
        <label for="email">Email nou client:</label>
        <input id="email" type="text" name="email" value="" required="required"/><br/>

        <input type="submit" name="salveaza" value="salveaza"/>
    </form>
<?php } ?>