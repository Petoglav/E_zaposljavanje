<?php

include("zaglavlje.php");

if (!isset($_SESSION['korisnik'])) {
    header("Location: index.php");
}

$kor_id = $_SESSION['kor_id'];

echo "<h2 class='naslov'>Registrirani korisnik - popis otvorenih natječaja</h2>";

$sql = "SELECT * FROM zavod z, natjecaj n
WHERE z.zavod_id = n.zavod_id 
AND n.datum_isteka > CURDATE() OR (n.datum_isteka = CURDATE() AND n.vrijeme_isteka > CURTIME())
ORDER BY n.datum_isteka DESC;";

$rs = sql($sql);

echo "<table>
<tr>
    <th>Natječaj</th>
    <th>Kreiran</th>
    <th>Ističe</th>
    <th>Broj radnih mjesta</th>
    <th>Kratica županije</th>
    <th>Zavod</th>
    <th>Prijavi se</th>
</tr>";

while(list($zavod_id, $moderator_id, $naziv, $opis, $natjecaj_id, $z_id, $n_naziv, $n_datum_kreiranja, $n_vrijeme_kreiranja, $n_datum_isteka, $n_vrijeme_isteka, $n_broj_radnih_mjesta, $n_kratica_zupanije, $n_opis) = mysqli_fetch_array($rs, MYSQLI_BOTH)) {

    echo "
    <tr>
        <td><a href='registrirani.php?detalji&id=$natjecaj_id&naziv=$n_naziv&opis=$n_opis'>$n_naziv</a></td>
        <td>".prikaz_vremena($n_datum_kreiranja, $n_vrijeme_kreiranja)."</td>
        <td>".prikaz_vremena($n_datum_isteka, $n_vrijeme_isteka)."</td>
        <td>$n_broj_radnih_mjesta</td>
        <td>$n_kratica_zupanije</td>
        <td>$naziv</td>";

        if (prijavljen_na_natjecaj($kor_id, $natjecaj_id)) {
            echo "<td>Već ste prijavljeni</td>";
        } else {
            echo "<td><a href='prijava_natjecaj.php?natjecaj&id=$natjecaj_id&naziv=$n_naziv'>Prijava</a></td>";
        }
    echo "</tr>";
}
echo "</table>
<br>
<br>";

if (isset($_GET['detalji'])) {
    
    $id = $_GET['id'];
    $naziv = $_GET['naziv'];
    $opis = $_GET['opis'];

    echo "<h3 class='naslov'>Natječaj: $naziv</h3>
    
    <h5 class='naslov'>Opis: $opis</h5>";

    $sql2 = "SELECT * FROM pristupnik WHERE pristupnik.natjecaj_id = '$id' AND pristupnik.status = 'Z'";
    $rs2 = sql($sql2);
    
    echo "<table>
    <tr>
        <th>Pristupnik</th>
        <th>Ime</th>
        <th>Prezime</th>
        <th>Slika</th>
        <th>Video</th>
    </tr>";
    
    while(list($korisnik_id, $natjecaj_id, $status, $slika, $video) = mysqli_fetch_array($rs2, MYSQLI_BOTH)) {
    
        $sql3 = "SELECT * FROM korisnik WHERE korisnik_id='$korisnik_id'";
        $rs3 = sql($sql3);
    
        list($k_korisnik_id, $k_tip_id, $k_korisnicko_ime, $k_lozinka, $k_ime, $k_prezime, $k_email, $k_slika) = mysqli_fetch_array($rs3, MYSQLI_BOTH);
    
        echo "
        <tr>
            <td><b>$k_korisnicko_ime</b></td>
            <td>$k_ime</td>
            <td>$k_prezime</td>
            <td><img height='55px' src='$slika' alt='[pristupnikova slika]'></td>
            <td><a href='$video'>Link</a></td>
        </tr>";
    }
    
    echo "</table>";
}

include("podnozje.php");
?>