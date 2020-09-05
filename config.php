<?php 
    $server = "127.0.0.1";
    $user = "iwa_2016";
    $password = "foi2016";
    $db = "iwa_2016_sk_projekt";

    $conn = mysqli_connect($server, $user, $password, $db);

    function conn() {

        global $conn;
        global $server;
        global $user;
        global $password;
        global $db;

        if (mysqli_connect_errno()) {
            error(mysqli_connect_error());
            exit();
        }

        if (!mysqli_set_charset($conn, "utf8")) {
            error(mysqli_error($conn));
            exit();
        }
    }

    function error($pogreska) {

        echo "<h3>$pogreska</h3>";
    }

    function sql($sql) {

        global $conn;

        $rs = mysqli_query($conn, $sql);
        if (!$rs) {
            error(mysqli_error($conn));
        }
        return $rs;
    }
?>
