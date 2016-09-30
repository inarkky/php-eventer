<?php
include_once('scripts/status.php');
if (isset($_SESSION["id"]) && $user_ok == true) { 
    header("location: index.php"); 
    exit();
}

if (isset($_POST["username"])) { //provjeravamo je li forma ispunjena

    //uzimamo variableiz podataka koje nam salje forma
    $username = mysqli_real_escape_string($db_conx, $_POST['username']);
    $password = mysqli_real_escape_string($db_conx, $_POST['password']);  

    //saljemo upit bazi da bi provjerili postoji li takav korisnik
    $sql    = "SELECT * FROM users WHERE user='$username' AND pass='$password' LIMIT 1";
    $query  = mysqli_query($db_conx, $sql);
    $row    = mysqli_fetch_row($query);

    $id     = $row[0];
    $user   = $row[1];
    $pass   = $row[2];
    $lvl    = $row[5];

    if ($password != $pass || $username != $user) {
        echo 'Greska: korisnik ne postoji! ';
        echo '<a href="login.php">Vratite se natrag.</a>';
        exit();
    } else { //ako je sve u redu postavljamo session
        $_SESSION['id']   = $id;
        $_SESSION['user'] = $user;
        $_SESSION['pass'] = $pass;
        $_SESSION['lvl']  = $lvl;
    }

    header("location: index.php"); //i redirektamo korisnika na index.php
    exit();
}
?>
<!doctype html>  
<html lang="hr"> 
<head>   
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>PRIJAVITE SE</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">  
    <link rel="stylesheet" type="text/css" href="style/style.css">
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
          <h3>Dobrodošli na Aplikaciju.. molimo prijavite se kako bi mogli nastaviti pregledavati sadržaj.</h3><hr><br><br>
          <div align="center">
            <form action="login.php" method="POST">
              <label>Username:<input type="text" name="username" required></label><br><br>
              <label>Password: <input type="password" name="password" required></label><br><br>
              <input type="submit" name="ok" value="PRIJAVI SE">
              <span class="pull-left"><a href="reg.php">Niste član? Registrirajte se ovdje.</a></span>
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