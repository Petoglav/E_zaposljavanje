<?php
session_start();

include_once("config.php");
conn();

if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
}

require("dodaci/helper.php");
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
        <link href="dodaci/stil.css" rel="stylesheet" type="text/css"/>
        <link href="https://fonts.googleapis.com/css2?family=Ubuntu:wght@400;700&display=swap" rel="stylesheet">
		<title>e-Zapošljavanje</title>
	</head>

	<body>

        <header id="zaglavlje">
            <h1 class="naslov centar">e-Zapošljavanje</h1>
        </header>

        <ul>
            <li><a href="index.php" class="menu">Početna</a></li>
            <li><a href="autor.php" class="menu">O autoru</a></li>

            <?php
            if (isset($_SESSION['korisnik'])) {
                echo "<hr>";
                echo '<li><a href="registrirani.php" class="menu">Registrirani korisnik</a></li>';
            }

            if (isset($_SESSION['tip']) && ($_SESSION['tip'] == 0 || $_SESSION['tip'] == 1 )) {
                echo "<hr>";
                echo '<li><a href="moderator.php" class="menu">Moderator</a></li>';
                echo '<li><a href="zaposleni.php" class="menu">Broj zaposlenih u odabranom razdoblju</a></li>';
                echo '<li><a href="rang_lista.php" class="menu">Rang lista korisnika po broju prijava</a></li>';
            }

            if (isset($_SESSION['tip']) && $_SESSION['tip'] == 0) {
                echo "<hr>";
                echo '<li><a href="korisnici.php" class="menu">Korisnici</a></li>';
                echo '<li><a href="zavodi.php" class="menu">Zavodi</a></li>';
                echo '<li><a href="pregled_natjecaja.php" class="menu">Natječaji</a></li>';
            }
            ?>

            <p>
            <?php
            if (isset($_SESSION['korisnik'])) {
                echo "<hr>";
                echo '<li><a href="zaglavlje.php?logout" class="menu">Odjava: <b>'. $_SESSION['korisnik'] . '</b></a></li>';
            } else {
                echo "<hr>";
                echo '<li><a href="prijava.php" class="menu">Prijava</a></li>';
            }
            ?>
            </p>

        </ul>

		<section id="stranica">
	