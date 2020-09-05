<?php

include("zaglavlje.php");

if (!isset($_SESSION['tip']) || $_SESSION['tip'] != 0) {
    header("Location: index.php");
}

if (isset($_GET['azuriranje'])) {
    $id = $_GET['id'];
    $korisnik = $_GET['korisnik'];

    echo "<h2 class='naslov'>Uredi korisnika: $korisnik</h2>";

    $sql = "SELECT * FROM korisnik WHERE korisnik_id='$id';";
    $rs = sql($sql);

    list($k_korisnik_id, $k_tip_id, $k_korisnicko_ime, $k_lozinka, $k_ime, $k_prezime, $k_email, $k_slika) = mysqli_fetch_array($rs, MYSQLI_BOTH);

    if (isset($_POST['azuriraj'])) {
        $ime = $_POST['ime'];
        $prezime = $_POST['prezime'];
        $slika = $_POST['slika'];
        $email = $_POST['email'];
        $tip_korisnika = $_POST['tip_korisnika'];
    
        $sql = "UPDATE korisnik 
        SET ime='$ime', prezime='$prezime', slika='$slika', email='$email', tip_id='$tip_korisnika' 
        WHERE korisnik_id='$id'";
        sql($sql);

        echo '<script>alert("Ažuriranje korisnika uspješno!"); 
        window.location = "korisnici.php";</script>';
    }

    echo "<form method='POST' action=''>
        <section>
            <label class='polje'>Korisničko ime: </label>
            <input type='text' name='korisnicko_ime' disabled value='$k_korisnicko_ime'>
        </section>

        <section>
            <label class='polje'>Lozinka: </label>
            <input type='text' name='lozinka' disabled value='$k_lozinka'>
        </section>

        <section>
            <label class='polje'>Ime: </label>
            <input type='text' name='ime' required value='$k_ime'>
        </section>

        <section>
            <label class='polje'>Prezime: </label>
            <input type='text' name='prezime' required value='$k_prezime'>
        </section>

        <section>
            <label class='polje'>Slika: </label>
            <input type='text' name='slika' required value='$k_slika'>
        </section>

        <section>
            <label class='polje'>Email: </label>
            <input type='text' name='email' required value='$k_email'>
        </section>

        <section>
            <label class='polje'>Tip korisnika: </label>
            <select name='tip_korisnika' required>
                <option disabled selected>Odaberite:</option>
            ";
            $sql = "SELECT * FROM tip_korisnika";
            $rs = sql($sql);
            while (list($tip_id, $naziv) = mysqli_fetch_array($rs, MYSQLI_BOTH)) {
                if ($tip_id == $k_tip_id) {
                    echo "<option selected value='$tip_id'>$naziv</option>";
                } else {
                    echo "<option value='$tip_id'>$naziv</option>";
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
        $korisnicko_ime = $_POST['korisnicko_ime'];
        $lozinka = $_POST['lozinka'];
        $ime = $_POST['ime'];
        $prezime = $_POST['prezime'];
        $slika = $_POST['slika'];
        $email = $_POST['email'];
        $tip_korisnika = $_POST['tip_korisnika'];
    
        $sql = "INSERT INTO korisnik (tip_id, korisnicko_ime, lozinka, ime, prezime, email, slika)
        VALUES ('".$tip_korisnika."', '".$korisnicko_ime."', '".$lozinka."', '".$ime."', '".$prezime."', '".$email."', '".$slika."')";
        sql($sql);

        echo '<script>alert("Unos korisnika uspješan!"); 
        window.location = "korisnici.php";</script>';
    }

    echo "<h2 class='naslov'>Unesi korisnika:</h2>";

    echo "<form method='POST' action=''>
        <section>
            <label class='polje'>Korisničko ime: </label>
            <input type='text' name='korisnicko_ime' required>
        </section>

        <section>
            <label class='polje'>Lozinka: </label>
            <input type='text' name='lozinka' required>
        </section>

        <section>
            <label class='polje'>Ime: </label>
            <input type='text' name='ime' required>
        </section>

        <section>
            <label class='polje'>Prezime: </label>
            <input type='text' name='prezime' required>
        </section>

        <section>
            <label class='polje'>Slika: </label>
            <input type='text' name='slika' required>
        </section>

        <section>
            <label class='polje'>Email: </label>
            <input type='text' name='email' required>
        </section>

        <section>
            <label class='polje'>Tip korisnika: </label>
            <select name='tip_korisnika' required>
                <option disabled selected>Odaberite:</option>
            ";
            $sql = "SELECT * FROM tip_korisnika";
            $rs = sql($sql);
            while (list($tip_id, $naziv) = mysqli_fetch_array($rs, MYSQLI_BOTH)) {
                echo "<option value='$tip_id'>$naziv</option>";
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