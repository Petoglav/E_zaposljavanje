<?php

include("zaglavlje.php");

if (!isset($_SESSION['tip']) || ($_SESSION['tip'] != 0 && $_SESSION['tip'] != 1) ) {
    header("Location: index.php");
}

if (isset($_GET['prihvati'])) {
    $id = $_GET['id'];

    $sql = "UPDATE pristupnik 
        SET `status`='P' WHERE korisnik_id='$id'";
        sql($sql);

        echo '<script>alert("Pristupnik natječaju je zaposlen!"); 
        window.location = "moderator.php";</script>';
}

include("podnozje.php");
?>
