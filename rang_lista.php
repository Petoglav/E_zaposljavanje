<?php

include("zaglavlje.php");

if (!isset($_SESSION['tip']) || ($_SESSION['tip'] != 0 && $_SESSION['tip'] != 1) ) {
    header("Location: index.php");
}

$kor_id = $_SESSION['kor_id'];

echo "<h2 class='naslov'>Rang lista korisnika po broju prijava na natječaje: </h2>";

$sql = "SELECT COUNT(*) AS rang_lista_prijava, k.korisnicko_ime, k.ime, k.prezime 
FROM korisnik k, pristupnik p, natjecaj n
WHERE k.korisnik_id = p.korisnik_id 
AND p.natjecaj_id=n.natjecaj_id 
AND p.status<>'' ";

echo "<form method='POST' action=''>
        <section>
            <label class='polje'>Od datuma: </label>
            <input type='text' name='od' required placeholder='dd.mm.gggg'>
        </section>

        <section>
            <label class='polje'>Do datuma: </label>
            <input type='text' name='do' required placeholder='dd.mm.gggg'>
        </section>

        <section>
            <input type='submit' name='filter' value='Filtriraj'>
        </section>
    </form>
    <br>
    <br>";

if (isset($_POST['filter'])) {
    $od = prikaz_datuma_za_bazu($_POST['od']);
    $do = prikaz_datuma_za_bazu($_POST['do']);

    $sql .= " AND n.datum_isteka BETWEEN '$od' AND '$do'";
}

$sql .= " GROUP BY p.korisnik_id 
    ORDER BY rang_lista_prijava DESC";

$rs = sql($sql);

echo "<table>
<tr>
    <th>Pozicija</th>
    <th>Broj prijavljenih natječaja</th>
    <th>Korisničko ime</th>
    <th>Ime</th>
    <th>Prezime</th>
</tr>";

$counter = 1;

while(list($rang_lista_prijava, $korisnicko_ime, $ime, $prezime) = mysqli_fetch_array($rs, MYSQLI_BOTH)) {
    echo "
    <tr>
        <td>" . $counter++ . ".</td>
        <td><b>$rang_lista_prijava</b></td>
        <td>$korisnicko_ime</td>
        <td>$ime</td>
        <td>$prezime</td>
    </tr>";
}
echo "</table>
<br>
<br>";

include("podnozje.php");
?>
