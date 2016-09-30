<?php 
include_once("scripts/status.php");
if (isset($_SESSION["id"]) && $user_ok == true) { 
    $uid = preg_replace('#[^0-9]#i', '', $_SESSION['id']);
}else{
    header('location: login.php');
    exit();
}

$id = mysqli_real_escape_string($db_conx, $_GET['id']);


/****************************************************
****** REZERVIRAJ
****************************************************/

if(isset($_POST['okok'])){
    $dd     = mysqli_real_escape_string($db_conx, $_POST['dd']);
    $mm     = mysqli_real_escape_string($db_conx, $_POST['mm']);
    $yy     = mysqli_real_escape_string($db_conx, $_POST['yyyy']);
    $po     = mysqli_real_escape_string($db_conx, $_POST['poruka']);
    $kor    = $_SESSION["id"];
    $dat    = $yy . '-' . $mm . '-' . $dd;
    $sql    ="INSERT INTO kalendar (art_id, kupac_id, datum, pending, poruka) VALUES ('$id', '$kor', '$dat', 0, '$po')";
    mysqli_query($db_conx, $sql);
    header('location: art.php?id=' . $id);
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

$output = '';
if($kat1>0) $output .= '<img id="wifi" data-placement="right" data-toggle="tooltip" title="Wi-Fi!">';
if($kat2>0) $output .= '<img id="no_smoke" data-placement="right" data-toggle="tooltip" title="Zabranjeno pušenje!">';
if($kat3>0) $output .= '<img id="gym" data-placement="right" data-toggle="tooltip" title="Teretana!">';
if($kat4>0) $output .= '<img id="pool" data-placement="right" data-toggle="tooltip" title="Bazen!">';

if($output!=''){
    $render='
    <table>
        <tr>
            <td style="padding: 20px 5px"><b>Pogodnosti:</b></td>
            <td style="padding: 20px 5px">' . $output . '</td>
        </tr>
    </table>
    ';
}else{
    $render='';
}


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
                    <table>
                        <tr>
                            <td>
                                <img src="<?php echo $sl; ?>" style="width:400px;height:400px;">
                            </td>
                            <td>
                                <?php echo $render; ?>
                                <table>
                                <tr>
                                    <td style="padding: 20px 5px"><b>Adresa:</b></td>
                                    <td style="padding: 20px 5px"><?php echo $adr; ?></td>
                                </tr>
                                <tr>
                                    <td style="padding: 20px 5px"><b>Opis:</b></td>
                                    <td style="padding: 20px 5px"><?php echo $det; ?></td>
                                </tr>
                                <tr>
                                    <td style="padding: 20px 5px"><b>Tagovi:</b></td>
                                    <td style="padding: 20px 5px"><?php echo $tagovi; ?></td>
                                </tr>
                                <tr>
                                    <td style="padding: 20px 5px"></td>
                                    <td style="padding: 20px 5px"><h3 style="color:red; font-weight:bold"><?php echo $cij; ?> HRK/dan</h3></td>
                                </tr>
                            </table></td>
                        </tr>
                    </table>
                    <hr>
                    <button type="button" class="btn btn-info pull-right" data-toggle="modal" data-target="#kal">ZATRAŽI NAJAM</button>
                    <div id="kal" class="modal fade" role="dialog">
                          <div class="modal-dialog">
                            <form method="POST" action="art.php?id=<?php echo $id; ?>">
                            <div class="modal-content">
                              <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Ugovor o najmu</h4>
                              </div>
                              <div class="modal-body">
                                <div class="pull-right">
                                    <h4 style="color:blue;" align="center">UPUTE</h4><hr>
                                    <ol>
                                        <li>Ukratko opišite razlog najma</li>
                                        <li>Odaberite datum zakupa</li>
                                        <li>Zatražite zajam</li>
                                    </ol>
                                    <ul>
                                        <li>Narančasta boja - Upit se razmatra</li>
                                        <li>Zelena boja - Datum je rezerviran</li>
                                        <li>Plava boja - Današnji datum</li>
                                        <li>Bijela boja - Slobodni termini</li>
                                    </ul>
                                    <textarea name="poruka" style="margin: 0px; width: 289px; height: 73px;" required></textarea>
                                    <input type="hidden" id="yyyy" name="yyyy" value="" />
                                    <input type="hidden" id="mm" name="mm" value="" />
                                    <input type="hidden" id="dd" name="dd" value="" />
                                </div>
                                <div class="kalendar">
                                    <?php include_once('scripts/kalendar.php'); ?>
                                </div>
<br><br><br><br>
                              </div>
                              <div class="modal-footer">
                                <button type="submit" name="okok" class="btn btn-success">ZATRAŽI</button>
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
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip(); 
});
function get_datum(yyyy, mm, dd){
    document.getElementById('yyyy').value = yyyy;
    document.getElementById('mm').value = mm;
    document.getElementById('dd').value = dd;
    return false;
}
$('table.conn a').click(function() {
    $(this).parent().removeClass("bg-white bg-blue").addClass("bg-orange");
    $("table.conn").find("a").each(function () {
        $(this).addClass("inactiveLink");
    });
});
</script> 
</body>
</html>