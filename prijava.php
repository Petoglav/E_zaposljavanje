<?php
include("zaglavlje.php");

if (isset($_SESSION['korisnik'])) {
    header("Location: index.php");
}

echo "<h2 class='naslov'>Prijava</h2>";

if (isset($_POST['login'])) {
    $user = $_POST['user'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM korisnik WHERE korisnicko_ime='$user' AND lozinka='$password'";
    $rs = sql($sql);

    if (mysqli_num_rows($rs) == 1) {
        list($korisnik_id, $tip_id, $korisnicko_ime, $lozinka, $ime, $prezime, $email, $slika) = mysqli_fetch_array($rs, MYSQLI_BOTH);
        $_SESSION['korisnik'] = $korisnicko_ime;
        $_SESSION['tip'] = $tip_id;
        $_SESSION['kor_id'] = $korisnik_id;
        $_SESSION['ime'] = $ime;
        $_SESSION['prezime'] = $prezime;
        $_SESSION['slika'] = $slika;
        $_SESSION['email'] = $email;
        
        header("Location: index.php");
    } else {
        echo "<h3 class='naslov error'>Podaci za prijavu nisu točni</h3>";
    }
}

echo "<form method='POST' action=''>
        <section>
            <label class='polje'>Korisničko ime: </label>
            <input type='text' name='user' required>
        </section>

        <section>
            <label class='polje'>Lozinka: </label>
            <input type='password' name='password' required>
        </section>

        <section>
            <input type='submit' name='login' value='Prijava'>
        </section>
    </form>";

include("podnozje.php");
?>