<?php

include("zaglavlje.php");

if (!isset($_SESSION['tip']) || $_SESSION['tip'] != 0) {
    header("Location: index.php");
}

echo "<h2 class='naslov'>Pregled svih natječaja</h2>";

$sql = "SELECT * FROM zavod z, natjecaj n WHERE z.zavod_id = n.zavod_id ";

echo "<form method='POST' action=''>
        <section>
            <label class='polje'>Kratica županije: </label>
            <input type='text' name='kratica' required>
        </section>

        <section>
            <input type='submit' name='filter_asc' value='Filtriraj po nazivu zavoda uzlazno (ASC)'>
        </section>

        <section>
            <input type='submit' name='filter_desc' value='Filtriraj po nazivu zavoda silazno (DESC)'>
        </section>
    </form>
    <br>
    <br>";

if (isset($_POST['filter_asc'])) {
    $kratica = $_POST['kratica'];

    $sql .= " AND n.kratica_zupanije LIKE '%$kratica%' ORDER BY z.naziv ASC";
}

if (isset($_POST['filter_desc'])) {
    $kratica = $_POST['kratica'];

    $sql .= " AND n.kratica_zupanije LIKE '%$kratica%' ORDER BY z.naziv DESC";
}

$rs = sql($sql);

echo "<table>
<tr>
    <th>Natječaj</th>
    <th>Kreiran</th>
    <th>Ističe</th>
    <th>Broj radnih mjesta</th>
    <th>Kratica županije</th>
    <th>Zavod</th>
</tr>";

while(list($zavod_id, $moderator_id, $naziv, $opis, $natjecaj_id, $z_id, $n_naziv, $n_datum_kreiranja, $n_vrijeme_kreiranja, $n_datum_isteka, $n_vrijeme_isteka, $n_broj_radnih_mjesta, $n_kratica_zupanije, $n_opis) = mysqli_fetch_array($rs, MYSQLI_BOTH)) {
    echo "
    <tr>
        <td>$n_naziv</td>
        <td>".prikaz_vremena($n_datum_kreiranja, $n_vrijeme_kreiranja)."</td>
        <td>".prikaz_vremena($n_datum_isteka, $n_vrijeme_isteka)."</td>
        <td>$n_broj_radnih_mjesta</td>
        <td>$n_kratica_zupanije</td>
        <td>$naziv</td>
    </tr>";
}
echo "</table>
<br>
<br>";

include("podnozje.php");
?>