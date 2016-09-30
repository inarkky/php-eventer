<div id="header_top"></div>
   <div id="header"></div>
   <div id="nav">
    <ul style="margin-top: 14px;">
    <li> <a href="index.php">Naslovna</a> </li>
    <li> <a href="search.php">Pretraga</a> </li>
    <li> <a href="profil.php">Profil</a> </li>
    <?php
    if($_SESSION['lvl'] == 1){ ?>
      <li> <a href="ponude.php">Moje Ponude</a> </li>
    <?php 
      }else{
    ?>
      <li> <a href="rezervacije.php">Moje Rezervacije</a> </li>
    <?php 
      }
    ?>
    <li> <a href="logout.php">Odjava</a> </li>
    </ul>
   </div>
   <div id="header_bottom"></div>