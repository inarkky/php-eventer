<?php
include_once('scripts/status.php');

if (isset($_SESSION["id"]) && $user_ok == true) { 
    $uid = preg_replace('#[^0-9]#i', '', $_SESSION['id']);
} else {
    header("location: login.php");
    exit();
}

/****************************************************
****** UPDATE
****************************************************/
if(isset($_POST['ok'])){
    $ime=mysqli_real_escape_string($db_conx, $_POST['ime']);
    $prezime=mysqli_real_escape_string($db_conx, $_POST['prezime']);

    $sql="UPDATE users SET ime='$ime', prezime='$prezime' WHERE id='$uid'";
    $query=mysqli_query($db_conx, $sql);

    header('location: profil.php');
    exit();
}

/****************************************************
****** RENDER
****************************************************/
$sql="SELECT * FROM users WHERE id = '$uid' LIMIT 1";
$query=mysqli_query($db_conx, $sql);

$row=mysqli_fetch_array($query, MYSQLI_ASSOC);
$ime=$row['ime'];
$prezime=$row['prezime'];

?>
<!doctype html>  
<html lang="hr"> 
<head>   
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>PROFIL</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">  
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    <link rel="stylesheet" type="text/css" href="style/style.css">
    <style type="text/css">
#productForm .selectContainer .form-control-feedback,
#productForm .inputGroupContainer .form-control-feedback {
    right: -15px;
}
</style>
</head>  
<body>
<div class="wrapper">
   <?php include_once('header.php'); ?>
   
<section id="content">
  <div class="wrap-content text">
    <div class="row box1">
      <div class="co1umn">
        <div class="wraptext">
          <h3>Ovdje možete pregledati i promjeniti informacije o sebi.</h3><hr><br><br>
          <div align="center">

            <form id="update" action="profil.php" method="POST" class="form-horizontal">
                <div class="form-group">
                    <label class="col-xs-3 control-label">Ime</label>
                    <div class="col-xs-8">
                        <input type="text" class="form-control" name="ime" id="ime" value="<?php echo $ime ?>" required />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-3 control-label">Prezime</label>
                    <div class="col-xs-8">
                        <input type="text" class="form-control" name="prezime" id="prezime" value="<?php echo $prezime ?>" required />
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-xs-8 col-xs-offset-3">
                        <button type="submit" name="ok" class="btn btn-default">PRIMJENI</button>
                    </div>
                </div>
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