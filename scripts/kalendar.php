<table border='0' class="conn" >
<?php 
    $date = getdate();
     
    $mday = $date['mday'];
    $mon = $date['mon'];
    $wday = $date['wday'];
    $month = $date['month'];
    $year = $date['year'];
     
     
    $dayCount = $wday;
    $day = $mday;
     
    while($day > 0) {
        $days[$day--] = $dayCount--;
        if($dayCount < 0)
            $dayCount = 6;
    }
     
    $dayCount = $wday;
    $day = $mday;
     
    if(checkdate($mon,31,$year))
        $lastDay = 31;
    elseif(checkdate($mon,30,$year))
        $lastDay = 30;
    elseif(checkdate($mon,29,$year))
        $lastDay = 29;
    elseif(checkdate($mon,28,$year))
        $lastDay = 28;
     
    while($day <= $lastDay) {
        $days[$day++] = $dayCount++;
        if($dayCount > 6)
            $dayCount = 0;
    }   

    $zeleni     = array();  
    $narancasti = array();
    $sq_trazi   = "SELECT * FROM kalendar WHERE art_id='$id'";
    $qu_trazi   = mysqli_query($db_conx, $sq_trazi);
    while ($ro_tr = mysqli_fetch_array($qu_trazi, MYSQLI_ASSOC)) {
        $var=$ro_tr['datum'];
        $con=$ro_tr['pending'];
        if($con==1){
            array_push($zeleni, date('d',strtotime($var)));
        }else if($con==0){
            array_push($narancasti, date('d',strtotime($var)));
        }

    }
     
    echo("<tr>");
    echo("<th colspan='7' align='center'>$month $year</th>");
    echo("</tr>");
    echo("<tr>");
        echo("<td class='red bg-yellow'>Ned</td>");
        echo("<td class='bg-yellow'>Pon</td>");
        echo("<td class='bg-yellow'>Uto</td>");
        echo("<td class='bg-yellow'>Sri</td>");
        echo("<td class='bg-yellow'>Cet</td>");
        echo("<td class='bg-yellow'>Pet</td>");
        echo("<td class='bg-yellow'>Sub</td>");
    echo("</tr>");
     
    $startDay = 0;
    $d = $days[1];
     
    echo("<tr>");
    while($startDay < $d) {
        echo("<td></td>");
        $startDay++;
    }
     
    for ($d=1;$d<=$lastDay;$d++) {
        if(in_array( $d, $narancasti)){
            $bg = "bg-orange"; 
            $cl = 'title="Na razmatranju" class="inactiveLink"';
        }elseif (in_array( $d, $zeleni)){
            $bg = "bg-green";
            $cl = 'title="Rezervirano" class="inactiveLink"';
        }else{
            $bg = "bg-white"; 
            $cl = 'title="Rezerviraj"';
        }
        if($d == $mday)
            echo("<td class='bg-blue'><a href='#' $cl onclick='return get_datum($year, $mon, $d)'>$d</a></td>");
        else
            echo("<td class='$bg'><a href='#' $cl onclick='return get_datum($year, $mon, $d)'>$d</a></td>");
     
     
        $startDay++;
        if($startDay > 6 && $d < $lastDay){
            $startDay = 0;
            echo("</tr>");
            echo("<tr>");
        }
    }
    echo("</tr>");
?>
</table>