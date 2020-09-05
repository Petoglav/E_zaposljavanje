<?php

function prikaz_vremena($datum, $vrijeme) {
    $array = explode("-", $datum);
    return $array[2].".".$array[1].".".$array[0]." ".$vrijeme;
}

function prikaz_tipa_korisnika($tip_id) {
    $sql = "SELECT naziv FROM tip_korisnika WHERE tip_id = '$tip_id'";
    $rs = sql($sql);

    if (mysqli_num_rows($rs) == 0) {
        return "GREŠKA! Tip korisnika " . $tip_id . " ne postoji!";
    }

    list($naziv) = mysqli_fetch_array($rs, MYSQLI_BOTH);
    return $naziv;
}

function prikaz_korisnickog_imena($korisnik_id) {
    
    $sql = "SELECT korisnicko_ime FROM korisnik WHERE korisnik_id='$korisnik_id'";
    $rs = sql($sql);

    if (mysqli_num_rows($rs) == 0) {
        return "GREŠKA! Korisnik sa id-jem " . $korisnik_id . " ne postoji!";
    }

    list($korisnicko_ime) = mysqli_fetch_array($rs, MYSQLI_BOTH);
    return $korisnicko_ime;
}

function prikaz_datuma_za_bazu($datum) {
    $array = explode(".", $datum);
    return $array[2]."-".$array[1]."-".$array[0];
}

function prikazi_status($status) {
    if ($status == "P") {
        return "Prihvaćen";
    }

    if ($status == "Z") {
        return "Zahtjev poslan";
    }
}

function provjeri_natjecaj_traje($datum, $vrijeme) {
    $trenutno = date("Y-m-d H:i:s");
    $trenutno_datum_vrijeme = strtotime($trenutno);

    $istek_datum_vrijeme = strtotime($datum . " " . $vrijeme);
    $istek = date("Y-m-d H:i:s", $istek_datum_vrijeme);

    return $istek_datum_vrijeme > $trenutno_datum_vrijeme;
}

function broj_zaposlenih_kandidata($natjecaj_id) {


    $sql = "SELECT COUNT(korisnik_id) AS broj_prihvacenih FROM pristupnik 
        WHERE natjecaj_id = '$natjecaj_id' 
        AND `status` = 'P'";
    $rs = sql($sql);
    
    list($broj_zaposlenih) = mysqli_fetch_array($rs, MYSQLI_BOTH);

    return $broj_zaposlenih;
}

function prijavljen_na_natjecaj($korisnik_id, $natjecaj_id) {
    
    $sql = "SELECT * FROM pristupnik WHERE korisnik_id='$korisnik_id' AND natjecaj_id='$natjecaj_id'";
    $rs = sql($sql);
    
    if (mysqli_num_rows($rs) == 1) {
        return true;
    } else {
        return false;
    }
}

?>
