<?php
include_once('scripts/status.php');
if (isset($_SESSION["id"]) && $user_ok == true) { 
    $uid = preg_replace('#[^0-9]#i', '', $_SESSION['id']);
} else {
    header("location: login.php");
    exit();
}

/******************************************
*** ZA SISTEM TAGIRANJA
******************************************/
$all_tags = array();
$tagovi='';
$tag_q = "SELECT tagovi FROM articles";
$result = mysqli_query($db_conx, $tag_q);
 
while($tag_rows = mysqli_fetch_array($result)){
    $tags = $tag_rows['tagovi'];
    $row_tags = explode(", ", $tags);
    $all_tags = array_merge($all_tags, $row_tags);
}
 
$all_tags = array_unique($all_tags);
sort($all_tags);
 
foreach($all_tags as $value){
    $tagovi .= '<a href="search.php?tag=' . $value . '" class="btn btn-default" style="margin:2px;">' . $value . '</a>';
}

/******************************************
*** ZA SKRACIVANJE OPISA AKO JE PREDUGACAK
******************************************/
function skrati($text, $maxchar, $end='...') {
    if (strlen($text) > $maxchar || $text == '') {
        $words = preg_split('/\s/', $text);      
        $out = '';
        $i      = 0;
        while (1) {
            $length = strlen($out)+strlen($words[$i]);
            if ($length > $maxchar) {
                break;
            } 
            else {
                $out .= " " . $words[$i];
                ++$i;
            }
        }
        $out .= $end;
    } 
    else {
        $out = $text;
    }
    return $out;
}

/******************************************
*** RENDANJE LISTE NAJNOVIJIH PONUDA
******************************************/

if(isset($_GET['tag'])){
  $k=mysqli_real_escape_string($db_conx, $_GET['tag']);
  $k_tag=mysqli_fetch_array(mysqli_query($db_conx, "SELECT * FROM articles WHERE concat(' ', tagovi, ',') LIKE '%$k%'"));
}elseif(!isset($_GET['tag'])){
  $k_tag=mysqli_fetch_array(mysqli_query($db_conx, "SELECT * FROM articles ORDER BY id DESC"));
}
  
  if(count($k_tag)<1){
    $output = 'Na zalost trenutno nema proizvoda u ovoj kategoriji!';
  }else{

  $rez_p_page=6;
  if (isset($_GET['page'])) {
    $page = mysqli_real_escape_string($db_conx, $_GET['page']);
  } else {
    $page=1;
  }
  $start = ($page-1) * $rez_p_page;


  $output='';
if(isset($_GET['tag'])){
  $sql="SELECT * FROM articles WHERE concat(' ', tagovi, ',') LIKE '%$k%' LIMIT $start, $rez_p_page";
}elseif(!isset($_GET['tag'])){
   $sql="SELECT * FROM articles ORDER BY id DESC LIMIT $start, $rez_p_page";
}
  $query=mysqli_query($db_conx, $sql);
  while($row=mysqli_fetch_array($query)){
      $i=$row['id'];
      $ime=$row['naziv'];
      $opis=$row['detalji'];
      $slika=$row['slika'];

      if(!$slika){
        $slika='images/default.jpg';
      }
      
      $s="SELECT * FROM pogodnosti WHERE art_id='$i' LIMIT 1";
      $q=mysqli_query($db_conx, $s);
      $r=mysqli_fetch_array($q);

      $a=$r['wifi'];
      $b=$r['bazen'];
      $c=$r['zrak'];
      $d=$r['teretana'];

      $output .= '
                    <li><a href="art.php?id=' . $i . '">
                      <table><tr>
                          <td style="width:70%;border:solid 1px white;"><img src="' . $slika . '" alt="slika" style="width:220px;height:240px;"/><td>
                          <td style="border:solid 1px white;">
                            ';
                            if($a>0) $output .= '<li id="wifi" title="Wi-Fi"></li>';
                            if($b>0) $output .= '<li id="no_smoke" title="Zabranjeno pušenje"></li>';
                            if($c>0) $output .= '<li id="gym" title="Teretana"></li>';
                            if($d>0) $output .= '<li id="pool" title="Bazen"></li>';
                           
                      $output .= '</td>
                      </tr></table>
                      <h3>' . $ime . '</h3>
                      <p>' . skrati($opis, 80) . '...</p>
                      </a>
                    </li>
      ';
  }
}


if($output==''){
    $output='<li>Na zalost trenutno nema proizvoda u ovoj kategoriji!</li>';
  }

?>
<!doctype html>  
<html lang="hr"> 
<head>   
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>APLIKACIJA EVIDENCIJA IZNAJMLJIVANJA OBJEKATA </title>
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1"> 
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script> 
    <link rel="stylesheet" type="text/css" href="style/style.css">
</head>  
<body>
<div class="wrapper">
   <?php include_once('header.php'); ?>
   
<section id="content">
  <div class="wrap-content text">
    <div class="row box1">
      <div class="co1umn">
        <div class="wraptext">
          <h1>Filtriraj rezultate ponuda!</h1>
          <p><?php echo $tagovi; ?></p>
        </div>
      </div>
      <div class="line"></div>
    </div>
    <div class="row box2">
      <div class="co1umn">
        <div class="wraptext">
          <ul class="rig columns-3">
            <?php echo $output; ?>
          </ul>
        </div>
      </div>
      <div class="line"></div>
    </div>
  </div>

<?php
if(isset($_GET['tag'])){
  $page_sql = "SELECT * FROM articles WHERE concat(' ', tagovi, ',') LIKE '%$k%'";
}elseif(!isset($_GET['tag'])){
  $page_sql = "SELECT * FROM articles ORDER BY id DESC";
}
$result = mysqli_query($db_conx, $page_sql);
$rows_total = mysqli_num_rows($result);
$pages_total = ceil($rows_total / $rez_p_page);

if(isset($_GET['tag'])){
  $link_page="search.php?tag=" . $k . "&page";
}elseif(!isset($_GET['tag'])){
  $link_page="search.php?page";
}
echo "<center><a class='btn btn-default' href='" . $link_page . "=1'>Prva</a> ";
for ($i=1; $i<=$pages_total; $i++) {
  echo "<a class='btn btn-default' href='" . $link_page . "=" . $i . "'>" . $i . "</a> ";
};
echo "<a class='btn btn-default' href='" . $link_page . "=" . $pages_total . "'>Zadnja</a></center> ";
?>

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