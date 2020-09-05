<?php

include("zaglavlje.php");

if (!isset($_SESSION['tip']) || ($_SESSION['tip'] != 0 && $_SESSION['tip'] != 1) ) {
    header("Location: index.php");
}

$kor_id = $_SESSION['kor_id'];

echo "<h2 class='naslov'>Broj zaposlenih na natječajima u odabranom razdoblju: </h2>";

$sql = "SELECT COUNT(*) AS broj_zaposlenih_u_razdoblju 
FROM pristupnik, natjecaj
WHERE pristupnik.natjecaj_id=natjecaj.natjecaj_id
AND pristupnik.status='P' ";

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
    $unos_od = $_POST['od'];
    $unos_do = $_POST['do'];

    $od = prikaz_datuma_za_bazu($unos_od);
    $do = prikaz_datuma_za_bazu($unos_do);

    $sql .= " AND natjecaj.datum_isteka BETWEEN '$od' AND '$do'";

    echo "<h3 class='naslov'>Razdoblje:  $unos_od - $unos_do</h3>";
}

$rs = sql($sql);



list($broj_zaposlenih_u_razdoblju) = mysqli_fetch_array($rs, MYSQLI_BOTH);
    echo "
    <label class='polje'>Zaposlenih: </label> $broj_zaposlenih_u_razdoblju
    <br>
    <br>";

include("podnozje.php");
?>
