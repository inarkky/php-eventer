<?php 
include_once("scripts/status.php");
if (isset($_SESSION["id"]) && $user_ok == true) { 
    $uid = preg_replace('#[^0-9]#i', '', $_SESSION['id']);
}else{
    header('location: login.php');
    exit();
}


/****************************************************
****** RENDER
****************************************************/
$rend="";
$i = 1;
$kid=$_SESSION['id'];
$op=mysqli_query($db_conx, "SELECT a.id ID, a.naziv IME, a.cijena HRK, k.datum DAT, k.pending PEN, k.poruka POR FROM articles a, kalendar k WHERE k.art_id=a.id AND k.kupac_id='$kid'");
while($row=mysqli_fetch_array($op, MYSQLI_ASSOC)){
    $id     =$row['ID'];
    $ime    =$row['IME'];
    $cijena =$row['HRK'];
    $datum  =$row['DAT'];
    $pending=$row['PEN'];
    $poruka =$row['POR'];

    if($pending==1){
        $pen='<span class="glyphicon glyphicon-ok" style="color:green" data-placement="right" data-toggle="tooltip" title="Odobreno!"></span>';
    }else if($pending==2){
        $pen='<span class="glyphicon glyphicon-remove" style="color:red" data-placement="right" data-toggle="tooltip" title="Odbijeno!"></span>';
    }else{
        $pen='<span class="glyphicon glyphicon-hourglass" style="color:orange" data-placement="right" data-toggle="tooltip" title="Na razmatranju!"></span>';
    }

    $rend .= '
    <tr>
        <td>' . $pen . '</td>
        <td><a href="art.php?id=' . $id . '">' . $ime . '</a></td>
        <td>' . $cijena . ' HRK/dan</td>
        <td>' . $datum . '</td>
        <td>' . $poruka . '.</td>
    </tr>
    '; 
    $i++;
}
?>
<!DOCTYPE html>
<html lang="hr">
<head>
<title>Ponude</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="style/style.css" type="text/css" charset="utf-8">
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
          <h3>Moji zakupi.</h3><hr>
              <div class="table-responsive"><table class="table table-hover table-condensed">
                                        <thead>
                                          <tr>
                                            <th>STATUS</th>
                                            <th>NEKRETNINA</th>
                                            <th>CIJENA</th>
                                            <th>DATUM</th>
                                            <th>PORUKA</th>
                                          </tr>
                                        </thead>
                    <?php echo $rend; ?></table>
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


<script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});
</script>
</body>
</html>