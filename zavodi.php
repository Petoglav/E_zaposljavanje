<?php

include("zaglavlje.php");

if (!isset($_SESSION['tip']) || $_SESSION['tip'] != 0) {
    header("Location: index.php");
}

echo "<h2 class='naslov'>Zavodi</h2>";

echo "<p><a href='zavod.php?unesi'>Unesi zavod</a></p>";

$sql = "SELECT * FROM zavod;";

$rs = sql($sql);

echo "<table>
<tr>
    <th>Naziv</th>
    <th>Opis</th>
    <th>Moderator</th>
    <th>Ažuriranje</th>
</tr>";

while(list($zavod_id, $moderator_id, $naziv, $opis) = mysqli_fetch_array($rs, MYSQLI_BOTH)) {

    echo "
    <tr>
        <td>$naziv</td>
        <td>$opis</td>
        <td>" . prikaz_korisnickog_imena($moderator_id) . "</td>
        <td><a href='zavod.php?azuriranje&id=$zavod_id&naziv=$naziv'>Ažuriraj</a></td>
    </tr>";
}
echo "</table>
<br>
<br>";

include("podnozje.php");
?>