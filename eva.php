<?php 
include_once("scripts/status.php");
if (isset($_SESSION["id"]) && $user_ok == true && $_SESSION['lvl'] == 1) { 
    $uid = preg_replace('#[^0-9]#i', '', $_SESSION['id']);
}else{
    header('location: login.php');
    exit();
}

/****************************************************
****** ODOBRI
****************************************************/
if(isset($_POST['odobri'])){
    $id_art = mysqli_real_escape_string($db_conx, $_POST['id_art']);
    $dt_art = mysqli_real_escape_string($db_conx, $_POST['dt_art']);
    $id_kal = mysqli_real_escape_string($db_conx, $_POST['id_kal']);

    $qc = mysqli_query($db_conx, "SELECT id FROM kalendar WHERE art_id='$id_art' AND datum='$dt_art'");
    while($counter = mysqli_fetch_array($qc)){
        $odbij = mysqli_query($db_conx, "UPDATE kalendar SET pending='2' WHERE art_id='$id_art' AND datum='$dt_art'");
    }
    $odobri  =mysqli_query($db_conx, "UPDATE kalendar SET pending='1' WHERE id='$id_kal'");

    header("location: eva.php?id=$id_art");
    exit();
}

/****************************************************
****** ODBIJ
****************************************************/
if(isset($_POST['odbij'])){
    $id_art = mysqli_real_escape_string($db_conx, $_POST['id_art']);
    $id_kal = mysqli_real_escape_string($db_conx, $_POST['id_kal']);
    $odbij  = mysqli_query($db_conx, "UPDATE kalendar SET pending='2' WHERE id='$id_kal'");
    header("location: eva.php?id=$id_art");
    exit();
}


/****************************************************
****** RENDER
****************************************************/
if(isset($_GET['id'])){ 
    $id_artikla = mysqli_real_escape_string($db_conx, $_GET['id']);
    $sq_ponude=mysqli_query($db_conx, " SELECT  a.naziv IME,
                                                k.id KAL,
                                                k.datum DAT, 
                                                k.poruka POR,
                                                u.ime KUP,
                                                u.prezime AC
                                        FROM    articles a, kalendar k, users u
                                        WHERE   k.art_id='$id_artikla' 
                                            AND a.id='$id_artikla' 
                                            AND k.kupac_id=u.id
                                            AND k.pending=0
                                        "
                            );
    $rend="";
    $i=1;
    while($pon_row=mysqli_fetch_array($sq_ponude, MYSQLI_ASSOC)){
        $kal    =$pon_row['KAL'];
        $zgr    =$pon_row['IME'];
        $dat    =$pon_row['DAT'];
        $por    =$pon_row['POR'];
        $kup    =$pon_row['KUP'] . " " . $pon_row['AC'];

        $rend .= '<tr>
                    <td>' . $i . '</td>
                    <td>' . $kup . '</td>
                    <td>' . $dat . '</td>
                    <td>' . $por . '.</td>
                    <td>
                        <form method="POST" action="eva.php">
                            <input type="hidden" name="id_kal" value="' . $kal . '">
                            <input type="hidden" name="id_art" value="' . $id_artikla . '">
                            <input type="hidden" name="dt_art" value="' . $dat . '">
                            <button type="submit" name="odobri" class="btn btn-success">ODOBRI</button>&nbsp;&nbsp;&nbsp;&nbsp;
                            <button type="submit" name="odbij" class="btn btn-danger">ODBIJ</button>
                        </form>
                    </td>
                </tr>'; 
        $i++;
    }

}else{
    $rend="Nema ponuda za ovu lokaciju";
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
          <h3>Poude za <?php echo $zgr; ?></h3><hr>
              <div class="table-responsive"><table class="table table-hover table-condensed">
                                        <thead>
                                          <tr>
                                            <th>#</th>
                                            <th>KUPAC</th>
                                            <th>DATUM</th>
                                            <th>PORUKA</th>
                                            <th>AKCIJE</th>
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