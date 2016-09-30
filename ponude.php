<?php 
include_once("scripts/status.php");
if (isset($_SESSION["id"]) && $user_ok == true) { 
    $uid = preg_replace('#[^0-9]#i', '', $_SESSION['id']);
}else{
    header('location: login.php');
    exit();
}

/****************************************************
****** INSERT
****************************************************/
if(isset($_POST['dodaj'])){
    $naziv = mysqli_real_escape_string($db_conx, $_POST['naziv']);
    $adresa = mysqli_real_escape_string($db_conx, $_POST['adresa']); 
    $cijena = mysqli_real_escape_string($db_conx, $_POST['cijena']);
    $opis = mysqli_real_escape_string($db_conx, $_POST['opis']);
    $tagovi = mysqli_real_escape_string($db_conx, $_POST['tagovi']);

    $sql0 = "INSERT INTO articles (naziv, adresa, cijena, detalji, vlasnik_id, tagovi) VALUES ('$naziv', '$adresa', '$cijena', '$opis', '$uid', '$tagovi')";
    $query0 = mysqli_query($db_conx, $sql0);
    $novi=mysqli_insert_id($db_conx);

    $add = 'images/' . $novi . '.jpg';
    if (isset($_FILES['slika']['tmp_name'])) {
      move_uploaded_file($_FILES['slika']['tmp_name'], $add);
      $sql_slika = "UPDATE articles SET slika='$add' WHERE id='$novi'";
      $query_slika = mysqli_query($db_conx, $sql_slika);
    } 

    $kat1 = mysqli_real_escape_string($db_conx, $_POST['kat1']);
    $kat2 = mysqli_real_escape_string($db_conx, $_POST['kat2']); 
    $kat3 = mysqli_real_escape_string($db_conx, $_POST['kat3']);
    $kat4 = mysqli_real_escape_string($db_conx, $_POST['kat4']);

    $sql1 = "INSERT INTO pogodnosti (art_id, wifi, bazen, zrak, teretana) VALUES ('$novi', '$kat1', '$kat2', '$kat3', '$kat4')";
    $query1 = mysqli_query($db_conx, $sql1);
 
    header('location: ponude.php');
    exit();

}

/****************************************************
****** RENDER
****************************************************/
$rend="";
$i = 1;
$op=mysqli_query($db_conx, "SELECT * FROM articles WHERE vlasnik_id='$uid'");
while($row=mysqli_fetch_array($op, MYSQLI_ASSOC)){
    $id=$row['id'];
    $ime=$row['naziv'];

    $rend .= '
    <tr><form action="p_edit.php" method="POST"><input type="hidden" name="id" value="' . $id . '">
        <td>' . $i . '.</td>
        <td>' . $ime . '</td>
        <td><input class="btn btn-success" type="submit" name="edit" value="UREDI"></td>
        <td><input class="btn btn-danger" type="submit" name="del" value="OBRISI"></td>
    '; 
    $penn=mysqli_query($db_conx, "SELECT k.id FROM kalendar k WHERE k.art_id='$id' AND k.pending=0");
    if($br=mysqli_num_rows($penn)){
        $rend .= '<td><a href="eva.php?id=' . $id . '" class="btn btn-info" name="mod">' . $br . ' PONUDE</a></td>';
    }else{
        $rend .= '<td></td>';
    }
    $rend .= '</form></tr>'; 
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
          <h3>Novi objekt.</h3><hr>
          <form id="productForm" action="ponude.php" method="POST" class="form-horizontal" enctype="multipart/form-data">
    <div class="form-group">
        <label class="col-xs-3 control-label">Naziv</label>
        <div class="col-xs-8">
            <input type="text" class="form-control" name="naziv" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-xs-3 control-label">Adresa</label>
        <div class="col-xs-8">
            <input type="text" class="form-control" name="adresa" />
        </div>
    </div>

    <div class="form-group">
        <label class="col-xs-3 control-label">Detalji</label>
        <div class="col-xs-8">
            <textarea name="opis" class="form-control" rows="5"></textarea>
        </div>
    </div>

    <div class="form-group">
        <label class="col-xs-3 control-label">Iznos zakupa/dan</label>
        <div class="col-xs-2 inputGroupContainer">
            <div class="input-control">
                <input type="text" class="form-control" name="cijena" />
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
            </span><label> </label><span id="sl"></span>
        </div>
    </div>

    <div class="form-group">
        <label class="col-xs-3 control-label">Tagovi</label>
        <div class="col-xs-2 inputGroupContainer">
            <div class="input-control">
                <input type="text" class="form-control" name="tagovi" required />
            </div>
        </div>
    </div>

    <div class="form-group">
        <div class="col-xs-8 col-xs-offset-3">
            <button type="submit" name="dodaj" class="btn btn-primary">DODAJ</button>
        </div>
    </div>
</form>



<br><br>



        <div class="wraptext">
          <h3>Moji objekti u ponudi.</h3><hr>
              <div class="table-responsive"><table class="table table-hover table-condensed">
                                        <thead>
                                          <tr>
                                            <th>#</th>
                                            <th>NASLOV</th>
                                            <th colspan="3" halign="center">AKCIJE</th>
                                          </tr>
                                        </thead>
                    <?php echo $rend; ?></table>
                </div>
                </div>


                        <div id="kal" class="modal fade" role="dialog">
                          <div class="modal-dialog">
                            <form method="POST" action="art.php?id=<?php echo $id; ?>">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Zahtjevi za: <?php echo $ime; ?></h4>
                              </div>
                              <div class="modal-body">
                                <form action="ponude.php" method="POST">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Osoba</th>
                                            <th>Datum</th>
                                            <th>Poruka</th>
                                            <th>Akcije</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php echo $moda; ?>
                                    </tbody>
                                </table>
                                </form>
                              </div>
                              <div class="modal-footer">
                                <button type="button" class="btn btn-warning" data-dismiss="modal">ODUSTANI</button>
                              </div>
                            </div>
                            </form>
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