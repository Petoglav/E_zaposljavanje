<?php

include("zaglavlje.php");

if (!isset($_SESSION['tip']) || ($_SESSION['tip'] != 0 && $_SESSION['tip'] != 1) ) {
    header("Location: index.php");
}

if (isset($_GET['azuriranje'])) {
    $id = $_GET['id'];
    $naziv_nat = $_GET['naziv'];

    echo "<h2 class='naslov'>Uredi natječaj: $naziv_nat</h2>";

    $sql = "SELECT * FROM natjecaj WHERE natjecaj_id='$id';";
    $rs = sql($sql);

    list($natjecaj_id, $z_id, $n_naziv, $n_datum_kreiranja, $n_vrijeme_kreiranja, $n_datum_isteka, $n_vrijeme_isteka, $n_broj_radnih_mjesta, $n_kratica_zupanije, $n_opis) = mysqli_fetch_array($rs, MYSQLI_BOTH);

    if (isset($_POST['azuriraj'])) {
        $naziv = $_POST['naziv'];
        $broj_radnih_mjesta = $_POST['broj_radnih_mjesta'];
        $kratica_zupanije = $_POST['kratica_zupanije'];
        $opis = $_POST['opis'];
    
        $sql = "UPDATE natjecaj 
        SET naziv='$naziv', broj_radnih_mjesta='$broj_radnih_mjesta', kratica_zupanije='$kratica_zupanije', opis='$opis' 
        WHERE natjecaj_id='$id'";
        sql($sql);

        echo '<script>alert("Ažuriranje natječaja uspješno!"); 
        window.location = "moderator.php";</script>';
    }

    echo "<form method='POST' action=''>
        <section>
            <label class='polje'>Naziv natječaja: * </label>
            <input type='text' name='naziv' required value='$n_naziv'>
        </section>

        <section>
            <label class='polje'>Broj radnih mjesta: * </label>
            <input type='text' name='broj_radnih_mjesta' required value='$n_broj_radnih_mjesta'>
        </section>

        <section>
            <label class='polje'>Kratica županije: * </label>
            <input type='text' name='kratica_zupanije' required value='$n_kratica_zupanije'>
        </section>

        <section>
            <label class='polje'>Opis: </label>
            <input type='text' name='opis' value='$n_opis'>
        </section>

        <section>
            <input type='submit' name='azuriraj' value='Ažuriraj'>
        </section>
    </form>";
}


if (isset($_GET['unesi'])) {

    if (isset($_POST['unos'])) {
        $naziv = $_POST['naziv'];
        $broj_radnih_mjesta = $_POST['broj_radnih_mjesta'];
        $kratica_zupanije = $_POST['kratica_zupanije'];
        $opis = $_POST['opis'];
        $zavod = $_POST['zavod'];
        $datum_kreiranja = prikaz_datuma_za_bazu($_POST['datum_kreiranja']);
        $vrijeme_kreiranja = $_POST['vrijeme_kreiranja'];
    
        $sql = "INSERT INTO natjecaj (zavod_id, naziv, datum_kreiranja, vrijeme_kreiranja, datum_isteka, vrijeme_isteka, broj_radnih_mjesta, kratica_zupanije, opis)
        VALUES ('".$zavod."', '".$naziv."', '".$datum_kreiranja."', '".$vrijeme_kreiranja."', DATE_ADD('".$datum_kreiranja."', INTERVAL 30 DAY), '".$vrijeme_kreiranja."', '".$broj_radnih_mjesta."', '".$kratica_zupanije."', '".$opis."')";
        sql($sql);

        echo '<script>alert("Unos natječaja uspješan!"); 
        window.location = "moderator.php";</script>';
    }

    echo "<h2 class='naslov'>Unesi najtečaj za jedan od svojih zavoda:</h2>";
    
    $kor_id = $_SESSION['kor_id'];

    echo "<form method='POST' action=''>

        <section>
            <label class='polje'>Zavod: * </label>
            <select name='zavod' required>
                <option disabled selected>Odaberite:</option>
            ";
            $sql = "SELECT zavod_id, naziv FROM zavod WHERE moderator_id='$kor_id'";
            $rs = sql($sql);
            while (list($zavod_id, $zavod_naziv) = mysqli_fetch_array($rs, MYSQLI_BOTH)) {
                echo "<option value='$zavod_id'>$zavod_naziv</option>";
            }
            echo "
            </select>
        </section>

        <section>
            <label class='polje'>Naziv natječaja: * </label>
            <input type='text' name='naziv' required>
        </section>

        <section>
            <label class='polje'>Datum kreiranja: * </label>
            <input type='text' name='datum_kreiranja' required placeholder='dd.mm.gggg'>
        </section>

        <section>
            <label class='polje'>Vrijeme kreiranja: * </label>
            <input type='text' name='vrijeme_kreiranja' required placeholder='hh:mm:ss'>
        </section>

        <section>
            <label class='polje'>Broj radnih mjesta: * </label>
            <input type='text' name='broj_radnih_mjesta' required>
        </section>

        <section>
            <label class='polje'>Kratica županije: * </label>
            <input type='text' name='kratica_zupanije' required>
        </section>

        <section>
            <label class='polje'>Opis: </label>
            <input type='text' name='opis'>
        </section>

        <section>
            <input type='submit' name='unos' value='Unesi'>
        </section>
    </form>";
}

include("podnozje.php");
?>