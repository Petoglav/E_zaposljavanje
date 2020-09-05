<?php

include("zaglavlje.php");

if (!isset($_SESSION['tip']) || ($_SESSION['tip'] != 0 && $_SESSION['tip'] != 1) ) {
    header("Location: index.php");
}

$kor_id = $_SESSION['kor_id'];

echo "<h2 class='naslov'>Moderator - popis mojih natječaja sortirano po datumu isteka natječaja</h2>";

echo "<p><a href='natjecaj.php?unesi'>Unesi natječaj</a></p>";

$sql = "SELECT * FROM zavod z, natjecaj n 
WHERE z.moderator_id = '$kor_id' 
AND z.zavod_id = n.zavod_id 
ORDER BY n.datum_isteka DESC;";
$rs = sql($sql);

if (mysqli_num_rows($rs) < 1) {
    echo "<h3 class='naslov error'>Nema natječaja ili niste moderator za nijedan zavod</h3>";
}

echo "<table>
<tr>
    <th>Natječaj</th>
    <th>Kreiran</th>
    <th>Ističe</th>
    <th>Broj radnih mjesta</th>
    <th>Kratica županije</th>
    <th>Zavod</th>
    <th>Ažuriranje</th>
</tr>";

while(list($zavod_id, $moderator_id, $naziv, $opis, $natjecaj_id, $z_id, $n_naziv, $n_datum_kreiranja, $n_vrijeme_kreiranja, $n_datum_isteka, $n_vrijeme_isteka, $n_broj_radnih_mjesta, $n_kratica_zupanije, $n_opis) = mysqli_fetch_array($rs, MYSQLI_BOTH)) {
    echo "
    <tr>
        <td><a href='moderator.php?detalji&id=$natjecaj_id&naziv=$n_naziv&opis=$n_opis&datum=$n_datum_isteka&vrijeme=$n_vrijeme_isteka&br=$n_broj_radnih_mjesta'>$n_naziv</a></td>
        <td>".prikaz_vremena($n_datum_kreiranja, $n_vrijeme_kreiranja)."</td>
        <td>".prikaz_vremena($n_datum_isteka, $n_vrijeme_isteka)."</td>
        <td>$n_broj_radnih_mjesta</td>
        <td>$n_kratica_zupanije</td>
        <td>$naziv</td>
        <td><a href='natjecaj.php?azuriranje&id=$natjecaj_id&naziv=$n_naziv'>Ažuriraj</a></td>
    </tr>";
}
echo "</table>
<br>
<br>";

if (isset($_GET['detalji'])) {
    
    $id = $_GET['id'];
    $naziv = $_GET['naziv'];
    $opis = $_GET['opis'];
    $datum = $_GET['datum'];
    $vrijeme = $_GET['vrijeme'];
    $br_mjesta_ukupno = $_GET['br'];

    $br_zaposlenih = broj_zaposlenih_kandidata($id);
    $natjecaj_traje = provjeri_natjecaj_traje($datum, $vrijeme);

    $zaposljavanje_moguce = $br_zaposlenih < $br_mjesta_ukupno;

    echo "<h3 class='naslov'>Natječaj: $naziv</h3>
    
    <h5 class='naslov'>Opis: $opis</h5>";

    $sql2 = "SELECT * FROM pristupnik WHERE pristupnik.natjecaj_id = '$id'";
    $rs2 = sql($sql2);

    if (mysqli_num_rows($rs2) < 1) {
        echo "<h3 class='naslov error'>Nema pristupnika ovom natječaju</h3>";
    }

    if ($natjecaj_traje) {
        echo "<h3 class='naslov'>Natječaj u tijeku pa se ne mogu prihvaćati kandidati</h3>";
    } else if (!$natjecaj_traje && $zaposljavanje_moguce) {
        echo "<h3 class='naslov'>Natječaj je gotov pa se mogu zaposliti kandidati - UKUPNO [$br_mjesta_ukupno] - ZAPOSLENO [$br_zaposlenih]</h3>";
    } else if (!$natjecaj_traje && !$zaposljavanje_moguce) {
        echo "<h3 class='naslov'>Natječaj je gotov i zaposlen je maksimalni broj kandidata - UKUPNO [$br_mjesta_ukupno]</h3>";
        echo "<h3 class='naslov'>Daljnje zapošljavanje nije moguće</h3>";
    }
    
    echo "<table>
    <tr>
        <th>Pristupnik</th>
        <th>Ime</th>
        <th>Prezime</th>
        <th>Slika</th>
        <th>Video</th>
        <th>Status</th>
        <th>Prihvati pristupnika</th>
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
            <td>".prikazi_status($status)."</td>
            <td>";
            if (!$natjecaj_traje && $status != "P" && $zaposljavanje_moguce) { 
                echo "<a href='prihvati_pristupnika.php?prihvati&id=$k_korisnik_id'>Prihvati/Zaposli</a>"; 
            } else if ($natjecaj_traje) {
                echo "Natječaj nije završio";
            } else {
                echo "-";
            }
        echo "</td>
        </tr>";
    }
    
    echo "</table>";
}

include("podnozje.php");
?>
