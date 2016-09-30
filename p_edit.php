<?php 
include_once("scripts/status.php");
if (isset($_SESSION["id"]) && $user_ok == true) { 
    $uid = preg_replace('#[^0-9]#i', '', $_SESSION['id']);
}else{
    header('location: login.php');
    exit();
}

$id = mysqli_real_escape_string($db_conx, $_POST['id']);

/****************************************************
****** DELETE
****************************************************/
if(isset($_POST['del'])){

    $sql0="DELETE FROM articles WHERE id='$id'";
    $query0=mysqli_query($db_conx, $sql0);

    $sql1="DELETE FROM pogodnosti WHERE art_id='$id'";
    $query1=mysqli_query($db_conx, $sql1);

    $filename='images/' . $id . '.jpg';
    unlink($filename);

    header('location: ponude.php');
    exit();
}

/****************************************************
****** UPDATE
****************************************************/
if(isset($_POST['up'])){
    $naziv  = mysqli_real_escape_string($db_conx, $_POST['naziv']);
    $adresa = mysqli_real_escape_string($db_conx, $_POST['adresa']); 
    $cijena = mysqli_real_escape_string($db_conx, $_POST['cijena']);
    $opis   = mysqli_real_escape_string($db_conx, $_POST['opis']);
    $tagovi = mysqli_real_escape_string($db_conx, $_POST['tagovi']);

    $sql0 = "UPDATE articles SET naziv='$naziv', adresa='$adresa', cijena='$cijena', detalji='$opis', tagovi='$tagovi' WHERE id='$id'";
    $query0 = mysqli_query($db_conx, $sql0);

    $add = 'images/' . $id . '.jpg';
    if (isset($_FILES['slika']['tmp_name'])) {
      move_uploaded_file($_FILES['slika']['tmp_name'], $add);
      $sql_slika = "UPDATE articles SET slika='$add' WHERE id='$id'";
      $query_slika = mysqli_query($db_conx, $sql_slika);
    } 

    $kat1 = mysqli_real_escape_string($db_conx, $_POST['kat1']);
    $kat2 = mysqli_real_escape_string($db_conx, $_POST['kat2']); 
    $kat3 = mysqli_real_escape_string($db_conx, $_POST['kat3']);
    $kat4 = mysqli_real_escape_string($db_conx, $_POST['kat4']);

    $sql1 = "UPDATE pogodnosti SET wifi='$kat1', bazen='$kat2', zrak='$kat3', teretana='$kat4' WHERE art_id='$id'";
    $query1 = mysqli_query($db_conx, $sql1);
 
    header('location: ponude.php');
    exit();

}

/****************************************************
****** OUTPUT
****************************************************/

$op=mysqli_query($db_conx, "SELECT * FROM articles WHERE id='$id' LIMIT 1");
$row=mysqli_fetch_array($op, MYSQLI_ASSOC);
    $ime=$row['naziv'];
    $adr=$row['adresa'];
    $cij=$row['cijena'];
    $det=$row['detalji'];
    $sl=$row['slika'];
    $tagovi=$row['tagovi'];

$op2=mysqli_query($db_conx, "SELECT * FROM pogodnosti WHERE art_id='$id' LIMIT 1");
$row2=mysqli_fetch_array($op2, MYSQLI_ASSOC);
    $kat1=$row2['wifi'];
    $kat2=$row2['bazen'];
    $kat3=$row2['zrak'];
    $kat4=$row2['teretana'];




?>
<!DOCTYPE html>
<html lang="hr">
<head>
<title>Uredi</title>
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
          <h3><?php echo $ime; ?></h3><hr>
          <form id="productForm" action="p_edit.php" method="POST" class="form-horizontal" enctype="multipart/form-data">
    <div class="form-group">
        <label class="col-xs-3 control-label">Naziv</label>
        <div class="col-xs-8">
            <input type="text" class="form-control" name="naziv" value="<?php echo $ime; ?>" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-xs-3 control-label">Adresa</label>
        <div class="col-xs-8">
            <input type="text" class="form-control" name="adresa" value="<?php echo $adr; ?>" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-xs-3 control-label">Detalji</label>
        <div class="col-xs-8">
            <textarea name="opis" class="form-control" rows="5"><?php echo $det; ?></textarea>
        </div>
    </div>

    <div class="form-group">
        <label class="col-xs-3 control-label">Iznos zakupa/dan</label>
        <div class="col-xs-2 inputGroupContainer">
            <div class="input-control">
                <input type="text" class="form-control" name="cijena" value="<?php echo $cij; ?>" />
            </div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-xs-3 control-label">WiFi</label>
        <div class="col-xs-8 selectContainer">
            <select class="form-control" name="kat1">
                <option value="1">Da</option>
                <option value="0">Ne</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-xs-3 control-label">Bazen</label>
        <div class="col-xs-8 selectContainer">
            <select class="form-control" name="kat2">
                <option value="1">Da</option>
                <option value="0">Ne</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-xs-3 control-label">Zabranjeno pušenje</label>
        <div class="col-xs-8 selectContainer">
            <select class="form-control" name="kat3">
                <option value="1">Da</option>
                <option value="0">Ne</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-xs-3 control-label">Teretana</label>
        <div class="col-xs-8 selectContainer">
            <select class="form-control" name="kat4">
                <option value="1">Da</option>
                <option value="0">Ne</option>
            </select>
        </div>
    </div>

    <div class="form-group">
        <label class="col-xs-3 control-label">Slika</label>
        <div class="col-xs-8 selectContainer">
            <span class="btn btn-default btn-file">
                PRETRAŽI <input type="file" name="slika">
            </span><label> </label><span id="sl"><?php echo $sl; ?></span>
        </div>
    </div>

    <div class="form-group">
        <label class="col-xs-3 control-label">Tagovi</label>
        <div class="col-xs-2 inputGroupContainer">
            <div class="input-control">
                <input type="text" class="form-control" name="tagovi" value="<?php echo $tagovi; ?>" />
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-8 col-xs-offset-3"><input type="hidden" name="id" value="<?php echo $id ?>" >
            <button type="submit" name="up" class="btn btn-primary">PROMJENI</button>
        </div>
    </div>
</form>



<br><br>




                    </div>
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
    $(document).on('change', '.btn-file :file', function() {
        var input = $(this),
        numFiles = input.get(0).files ? input.get(0).files.length : 1,
        label = input.val().replace(/\\/g, '/').replace(/.*\//, '');
        input.trigger('fileselect', [numFiles, label]);
    });
    $('.btn-file :file').on('fileselect', function(event, numFiles, label) {
        $( "#sl" ).text( label );
    });
</script>
</body>
</html>