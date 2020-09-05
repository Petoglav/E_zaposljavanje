<?php

include("zaglavlje.php");

if (!isset($_SESSION['tip']) || $_SESSION['tip'] != 0) {
    header("Location: index.php");
}

if (isset($_GET['azuriranje'])) {
    $id = $_GET['id'];
    $naziv = $_GET['naziv'];

    echo "<h2 class='naslov'>Uredi zavod: $naziv</h2>";

    $sql = "SELECT * FROM zavod WHERE zavod_id='$id';";
    $rs = sql($sql);

    list($zav_id, $zav_moderator, $zav_naziv, $zav_opis) = mysqli_fetch_array($rs, MYSQLI_BOTH);

    if (isset($_POST['azuriraj'])) {
        $moderator = $_POST['moderator'];
        $naziv = $_POST['naziv'];
        $opis = $_POST['opis'];
       
        $sql = "UPDATE zavod 
        SET naziv='$naziv', opis='$opis', moderator_id='$moderator' 
        WHERE zavod_id='$id'";
        sql($sql);

        echo '<script>alert("Ažuriranje zavoda uspješno!"); 
        window.location = "zavodi.php";</script>';
    }

    echo "<form method='POST' action=''>

        <section>
            <label class='polje'>Naziv: </label>
            <input type='text' name='naziv' required value='$zav_naziv'>
        </section>

        <section>
            <label class='polje'>Opis: </label>
            <input type='text' name='opis' required value='$zav_opis'>
        </section>

        <section>
            <label class='polje'>Moderator: </label>
            <select name='moderator' required>
                <option disabled selected>Odaberite:</option>
            ";
            $sql = "SELECT korisnik_id, korisnicko_ime FROM korisnik WHERE tip_id='0' OR tip_id='1'";
            $rs = sql($sql);
            while (list($korisnik_id, $korisnicko_ime) = mysqli_fetch_array($rs, MYSQLI_BOTH)) {
                if ($zav_moderator == $korisnik_id) {
                    echo "<option selected value='$korisnik_id'>$korisnicko_ime</option>";
                } else {
                    echo "<option value='$korisnik_id'>$korisnicko_ime</option>";
                }
            }
            echo "
            </select>
        </section>

        <section>
            <input type='submit' name='azuriraj' value='Ažuriraj'>
        </section>
    </form>";
}


if (isset($_GET['unesi'])) {

    if (isset($_POST['unos'])) {
        $moderator = $_POST['moderator'];
        $naziv = $_POST['naziv'];
        $opis = $_POST['opis'];
       
        $sql = "INSERT INTO zavod (moderator_id, naziv, opis)
        VALUES ('".$moderator."', '".$naziv."', '".$opis."')";
        sql($sql);

        echo '<script>alert("Unos zavoda uspješan!"); 
        window.location = "zavodi.php";</script>';
    }

    echo "<h2 class='naslov'>Unesi zavod:</h2>";

    echo "<form method='POST' action=''>

         <section>
            <label class='polje'>Naziv: </label>
            <input type='text' name='naziv' required>
        </section>

        <section>
            <label class='polje'>Opis: </label>
            <input type='text' name='opis' required>
        </section>

        <section>
            <label class='polje'>Moderator: </label>
            <select name='moderator' required>
                <option disabled selected>Odaberite:</option>
            ";
            $sql = "SELECT korisnik_id, korisnicko_ime FROM korisnik WHERE tip_id='0' OR tip_id='1'";
            $rs = sql($sql);
            while (list($korisnik_id, $korisnicko_ime) = mysqli_fetch_array($rs, MYSQLI_BOTH)) {
                echo "<option value='$korisnik_id'>$korisnicko_ime</option>";
            }
            echo "
            </select>
        </section>

        <section>
            <input type='submit' name='unos' value='Unesi'>
        </section>
    </form>";
}

include("podnozje.php");
?>