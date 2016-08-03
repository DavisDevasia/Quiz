<?php
$mysqli = new mysqli("localhost", "quizmaster", "quiz@aug15", "quiz");
$mq=$mysqli->query("SELECT * FROM teams ORDER BY score DESC");
$result=array();
while($mr=$mq->fetch_assoc())
{
    array_push($result,$mr);
}

// Check for ties
$c=count($result);
$tiedteams=array();
//Check tie for first place!
for($i=1;$i<$c;$i++)if($result[0]['score']==$result[$i]['score'])array_push($tiedteams,$result[$i]);
if(!empty($tiedteams))array_unshift($tiedteams,$result[0]);

//Checks for second place
if(empty($tiedteams)){
for($i=2;$i<$c;$i++)if($result[1]['score']==$result[$i]['score'])array_push($tiedteams,$result[$i]);
if(!empty($tiedteams))array_unshift($tiedteams,$result[1]);
}

//Checks for third place
if(empty($tiedteams)){
for($i=3;$i<$c;$i++)if($result[2]['score']==$result[$i]['score'])array_push($tiedteams,$result[$i]);
if(!empty($tiedteams))array_unshift($tiedteams,$result[2]);
}

// Display message for tie
if(empty($tiedteams))
{
    $msg="No tie encountered for first, second or third places!";
    $onclick='onclick="announce_result();"';
    $btnmsg="Announce Results";
    $jscommand="finalresult=data.result;";
}
else
{
    $msg="Tie encountered!!<br/><br/>";
    $temp=array();$temp2=array();
    foreach($tiedteams as $k=>$v){array_push($temp,$v['name']);array_push($temp2,$v['id']);}
    $msg.=implode("<br/>",$temp);
    $jscommand="teams=['".implode("','",$temp2)."'];round='T';";unset($result);
    $onclick='onclick="showselection(\'T\',teams[0],0);"';
    $btnmsg="Launch Tie Braker!";
}
$screen='
<div style="padding:10px;">
    <h2>Tie Checking...</h2>
    <p style="height:300px;">'.$msg.'</p>
    <a '.$onclick.' class="button button-green">'.$btnmsg.'</a>
</div>';

?>