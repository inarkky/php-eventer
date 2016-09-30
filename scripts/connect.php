<?php
//podaci za spajanje sa bazom
$hostname='localhost';
$username='root';
$password='';
$database='rent_db';
//spajamo se
$db_conx = mysqli_connect($hostname, $username, $password, $database);
//provjeravamo da li radi
if (mysqli_connect_errno()) {
    echo mysqli_connect_error();
    exit();
} else {
// echo "RADIIIIII :D";
}
?>