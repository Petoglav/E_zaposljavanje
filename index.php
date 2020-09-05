<?php
include("zaglavlje.php");

echo "<h2 class='naslov'>Početna - popis zavoda</h2>";

$sql = "SELECT zavod_id, naziv, opis FROM zavod";
$rs = sql($sql);

echo "<table>
    <tr>
        <th>Zavod</th>
    </tr>";
    
    while(list($zav_id, $zav_naziv, $zav_opis) = mysqli_fetch_array($rs, MYSQLI_BOTH)) {
    
        echo "
        <tr>
            <td><a href='index.php?detalji&id=$zav_id&naziv=$zav_naziv&opis=$zav_opis'>$zav_naziv</a></td>
        </tr>";
    }
    
echo "</table>";

echo "<br><br>";

if (isset($_GET['detalji'])) {


    $id = $_GET['id'];
    $naziv = $_GET['naziv'];
    $opis = $_GET['opis'];

    echo "<h3 class='naslov'>Zavod: $naziv - Opis: $opis</h3>";

    $sql2 = "SELECT * FROM zavod z, natjecaj n
            WHERE z.zavod_id = n.zavod_id AND z.zavod_id = '$id'
            AND n.datum_isteka < CURDATE() OR (n.datum_isteka = CURDATE() AND n.vrijeme_isteka > CURTIME())
            ORDER BY n.datum_isteka DESC;";
    $rs2 = sql($sql2);

    echo "<table>
    <tr>
        <th>Zatvoreni natječaji</th>
    </tr>";
    
    while(list($zavod_id, $moderator_id, $naziv, $opis, $natjecaj_id, $z_id, $n_naziv, $n_datum_kreiranja, $n_vrijeme_kreiranja, $n_datum_isteka, $n_vrijeme_isteka, $n_broj_radnih_mjesta, $n_kratica_zupanije, $n_opis) = mysqli_fetch_array($rs2, MYSQLI_BOTH)) {
    
        echo "
        <tr>
            <td><a href='natjecaj_pristupnik.php?id=$natjecaj_id'>$n_naziv</a></td>
        </tr>";
    }
    
    echo "</table>";
}


include("podnozje.php");
?>