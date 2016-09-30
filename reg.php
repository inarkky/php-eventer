<?php
include_once("scripts/connect.php"); 
?>
<?php
if (isset($_POST["username"])) {

    $username = mysqli_real_escape_string($db_conx, $_POST['username']);
    $password = mysqli_real_escape_string($db_conx, $_POST['password']); 
    $ime = mysqli_real_escape_string($db_conx, $_POST['ime']);
    $prezime = mysqli_real_escape_string($db_conx, $_POST['prezime']); 
    $radio = mysqli_real_escape_string($db_conx, $_POST['radio']);  

        $sql = "INSERT INTO users(user, pass, ime, prezime, lvl) VALUES ('$username', '$password', '$ime', '$prezime', '$radio')";
        $query = mysqli_query($db_conx, $sql);

    header("location: login.php");
    exit();
}
?>

<!doctype html>  
<html lang="hr"> 
<head>   
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>REGISTRACIJA</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">  
    <link rel="stylesheet" type="text/css" href="style/style.css">
    <script>
        function test() {
            var a = true;
            var x = document.forms["reg"]["password"].value;
            var y = document.forms["reg"]["pass2"].value;
            if (x != y) {
                alert("Lozinke se ne podudaraju!");
                a = false;
            }
            return a;
        }
    </script>
</head>  
<body>
<div class="wrapper">
   <div id="header_top"></div>
   <div id="header"></div>
   <div id="header_bottom"></div>
   
<section id="content">
  <div class="wrap-content text">
    <div class="row box1">
      <div class="co1umn">
        <div class="wraptext">
          <h3>Molimo upišite svoje podatke kako bi stvorili račun.</h3><hr><br><br>
          <div align="center">
            <form name="reg" action="reg.php" method="POST" onsubmit="return test()">
                <table>
                    <tr>
                        <td><label for="username">Korisničko ime:</label></td><td><input type="text" name="username" id="username" required></td>
                    </tr>
                    <tr>
                        <td><label for="password">Lozinka:</label></td><td><input type="password" name="password" id="password" required></td>
                    </tr>
                    <tr>
                        <td><label for="pass2">Ponovno lozinka:</label></td><td><input type="password" name="pass2" id="pass2" required></td>
                    </tr>
                    <tr>
                        <td><label for="ime">Ime:</label></td><td><input type="text" name="ime" id="ime" required></td>
                    </tr>
                    <tr>
                        <td><label for="prezime">Prezime:</label></td><td><input type="text" name="prezime" id="prezime" required></td>
                    </tr>
                    <tr>
                        <td>Registriraj se kao:</td>
                        <td>
                            <label class="radio-inline"><input type="radio" name="radio" checked>Klijent</label>
                            <label class="radio-inline"><input type="radio" name="radio">Poslužitelj</label>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" align="right"><input type="submit" name="ok" value="POTVRDI"></td>
                    </tr>
                </table>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<footer>
    <div class="wrap-footer">
        <div class="ftr">
            <p>footer</p>
        </div>
    </div>
</footer>
  </div>  
   
</body>
</html>
