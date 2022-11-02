<?php
    session_start();
    require 'model/user.php';
    require 'model/tim.php';

    if(isset($_POST['dodajTim'])) {
        $noviTim = array(
                "timID" => findMaxId() + 1,
                "nazivTima" => $_POST['nazivTima'],
                "drzava" => $_POST['drzava'],
                "godinaOsnivanja" => $_POST['godinaOsnivanja'],
                "brojTitula" => $_POST['brojTitula'],
        );
        $_SESSION['timovi'][] = $noviTim;
        header("Location: .");
        exit();
    }
    if(isset($_GET['timID-izbrisi']) && is_numeric($_GET['timID-izbrisi'])) {
        for($i = 0; $i < count($_SESSION['timovi']); $i++) {
            if($_GET['timID-izbrisi'] == $_SESSION['timovi'][$i]['timID']) {
                array_splice($_SESSION['timovi'], $i, 1);
                header("Location: .");
                exit();
            }
        }
    }

    function findMaxId() {
        // $idjevi = [];
        // foreach($_SESSION['timovi'] as $tim) {
        //     $idjevi[] = $tim['timID'];
        // }
        // return max($idjevi);
        $max = 0;
        foreach($_SESSION['timovi'] as $tim) {
            if($tim['timID'] > $max) {
                $max = $tim['timID'];
            }
        }
        return $max;
    }


    if(isset($_POST['username']) && isset($_POST['password'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];

        foreach ($korisnici as $k) {
            if($k['username'] == $username && $k['password'] == $password) {
                $_SESSION['username'] = $username;
                // header("Location: home.php");
                include 'home.php';
                exit();
            }
        }

        // if(login($username, $password)) {
        //     $_SESSION['username'] = $username;
        //     header("Location: home.php");
        //     exit();
        // }
    }

    if(isset($_GET['addTeam'])) {
        include 'addTeam.php';
        exit();
    }

    if(isset($_SESSION['username'])) {
        include 'home.php';
        exit();
    }

    include 'login.php';

    function login($username, $password) {
        global $korisnici;
        foreach($korisnici as $k) {
            if($k['username'] == $username && $k['password'] == $password) {
                return true;
            }
        }
        return false;
    }
?>