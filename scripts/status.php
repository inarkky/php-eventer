<?php
session_start(); 
include("connect.php");
// zbog ove dvije linije iznad ne moramo na svakoj stranici posebno otvarat session i spajat se sa bazom dovoljno je samo
// da prva naredba u svim ostalim *.php stranicama bude include("scripts/status.php"); ili include_once("scripts/status.php");

//inicijalizacija varijabli
$user_ok = false;
$log_username = "";
$log_password = "";

// funkcija koja prvjerava postoji li korisnik tablici users
// kojem su podaci jednaki parametrima koje funkcija dobiva (u zagradi)
function provjeri($conx, $u, $p) {
    $sql = "SELECT * FROM users WHERE user='$u' AND pass='$p' LIMIT 1";
    $query = mysqli_query($conx, $sql);
    $numrows = mysqli_num_rows($query);
    if ($numrows > 0) {
        return true;
    }
}

// provjerava postoji li session odnosno ako smo se vec prijavili a nismo ugasili browser
// i ako postoji automatski salje korisnika na na iducu stranicu 
if (isset($_SESSION["user"]) && isset($_SESSION["pass"])) {

    //prvi parametar je regex (oznacava sve sto NIJE veliko ili malo slovo ili broj), 
    //drugi parametar je ono s cime cemo zamjeniti oznaceni dio (s nicim - brisemo oznaceno), 
    //treci parametar je string nad kojim se vrsi operacija
    $log_username = preg_replace('#[^a-z0-9]#i', '', $_SESSION['user']);
    $log_password = preg_replace('#[^a-z0-9]#i', '', $_SESSION['pass']);

    $user_ok = provjeri($db_conx, $log_username, $log_password);
}

?>