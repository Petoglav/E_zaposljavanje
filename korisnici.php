<?php

include("zaglavlje.php");

if (!isset($_SESSION['tip']) || $_SESSION['tip'] != 0) {
    header("Location: index.php");
}

echo "<h2 class='naslov'>Korisnici</h2>";

echo "<p><a href='korisnik.php?unesi'>Unesi korisnika</a></p>";

$sql = "SELECT * FROM korisnik;";

$rs = sql($sql);

echo "<table>
<tr>
    <th>Korisnik</th>
    <th>Tip korisnika</th>
    <th>Ime</th>
    <th>Prezime</th>
    <th>Slika</th>
    <th>Email</th>
    <th>Ažuriranje</th>
</tr>";

while(list($k_korisnik_id, $k_tip_id, $k_korisnicko_ime, $k_lozinka, $k_ime, $k_prezime, $k_email, $k_slika) = mysqli_fetch_array($rs, MYSQLI_BOTH)) {

    echo "
    <tr>
        <td>$k_korisnicko_ime</td>
        <td>" . prikaz_tipa_korisnika($k_tip_id) . "</td>
        <td>$k_ime</td>
        <td>$k_prezime</td>
        <td><img src='$k_slika' height='55px' alt='Korisnikova slika'></td>
        <td><i>$k_email</i></td>
        <td><a href='korisnik.php?azuriranje&id=$k_korisnik_id&korisnik=$k_korisnicko_ime'>Ažuriraj</a></td>
    </tr>";
}
echo "</table>
<br>
<br>";

include("podnozje.php");
?>