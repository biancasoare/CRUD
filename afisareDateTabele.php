<?php
/**
 * Created by PhpStorm.
 * User: soarebianca
 * Date: 27/03/2018
 * Time: 15:55
 */


require_once __DIR__ . '/configDb.php';
require_once __DIR__ . '/DatabaseConnection.php';

/** @var PDO $dbh */
$dbh = DatabaseConnection::getConnection($configDb);
//cu functia predefinita setAttribute imi aarata in browser eroarea sql daca exista
$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$dbh = DatabaseConnection::getConnection($configDb);

$sql = "SELECT * FROM clienti c LEFT JOIN comenzi co ON c.id = co.clienti_id
LEFT JOIN produse p ON co.produse_id = p.id ORDER BY clienti_id ASC;";


$stmt = $dbh->prepare($sql);
$stmt->execute();
$rez = $stmt->fetchAll(PDO::FETCH_ASSOC);
//var_dump($rez);

?>


<table border="1">
    <tr>
        <th>client</th>
        <th>produs</th>
        <th>comanda</th>
    </tr>
s
    <?php foreach($rez as $key=>$value) { ?>
    <tr>
        <td><?php echo $value["nume"]." ".$value["prenume"] ?> </td>
        <td><?php echo $value["denumire"] ?> </td>
        <td><?php echo $value["comanda"] ?> </td>
    </tr>
    <?php }  ?>
</table>
