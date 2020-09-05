<?php
include("zaglavlje.php");

$id = $_GET['id'];

$sql1 = "SELECT naziv FROM natjecaj WHERE natjecaj_id = '$id'";
$rs1 = sql($sql1);

list($nat_naziv) = mysqli_fetch_array($rs1, MYSQLI_BOTH);

echo "<h2 class='naslov'>Zaposleni pristupnici na natječaj: $nat_naziv</h2>";

$sql = "SELECT * FROM pristupnik WHERE pristupnik.natjecaj_id = '$id' AND pristupnik.status = 'P'";
$rs = sql($sql);

echo "<table>
<tr>
    <th>Pristupnik</th>
    <th>Ime</th>
    <th>Prezime</th>
    <th>Slika</th>
    <th>Video</th>
</tr>";

while(list($korisnik_id, $natjecaj_id, $status, $slika, $video) = mysqli_fetch_array($rs, MYSQLI_BOTH)) {

    $sql2 = "SELECT * FROM korisnik WHERE korisnik_id='$korisnik_id'";
    $rs2 = sql($sql2);

    list($k_korisnik_id, $k_tip_id, $k_korisnicko_ime, $k_lozinka, $k_ime, $k_prezime, $k_email, $k_slika) = mysqli_fetch_array($rs2, MYSQLI_BOTH);

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


include("podnozje.php");
?>