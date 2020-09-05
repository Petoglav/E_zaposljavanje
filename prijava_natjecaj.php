<?php
include("zaglavlje.php");

if (!isset($_SESSION['korisnik'])) {
    header("Location: index.php");
}

$kor_id = $_SESSION['kor_id'];
$id = $_GET['id'];
$naziv = $_GET['naziv'];

echo "<h2 class='naslov'>Prijava na natječaj: $naziv</h2>";

if (isset($_POST['potvrdi_prijavu'])) {
    $url_slika = $_POST['url_slika'];
    $video = $_POST['video'];

    $sql = "INSERT INTO pristupnik (korisnik_id, natjecaj_id, status, slika, video)
            VALUES ('".$kor_id."', '".$id."', 'Z', '".$url_slika."', '".$video."')";
    sql($sql);

    echo '<script>alert("Prijavljeni ste na natječaj. Rezultate provjerite nakon isteka natječaja.");
    window.location = "registrirani.php";</script>';

}

echo "<form method='POST' action=''>
        <section>
            <label class='polje'>Slika pristupnika (URL): * </label>
            <input type='text' name='url_slika' required>
        </section>

        <section>
            <label class='polje'>Video predstavljanja: </label>
            <input type='text' name='video'>
        </section>

        <section>
            <input type='submit' name='potvrdi_prijavu' value='Potvrdi prijavu'>
        </section>
    </form>";

include("podnozje.php");
?>