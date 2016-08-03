<?php
$team=$_GET['team'];$teami=$_GET['teami'];

$mysqli = new mysqli("localhost", "quizmaster", "quiz@aug15", "quiz");
$preq=$mysqli->query("SELECT * FROM rapidfire_responses WHERE team='$team' LIMIT 1");
while($preq->fetch_assoc())$attempted=true;

$screen='<div id="questionarea"><div style="padding-top:15%;"><h1>Select your set:</h1>';

$mdata=$mysqli->query("SELECT * FROM rapidfire_qsets ORDER BY qset");

$rf_qsets=array();
$number=1;
while($mrow=$mdata->fetch_assoc())
{
   array_push($rf_qsets,$mrow);
   $dis=empty($mrow['attempted'])?'':' disabled';
   $onc=empty($dis)?' onclick="rapidfire_start('.$mrow['qset'].');"':'';
   $screen.='<a'.$onc.' class="button medium'.$dis.'">'.$number.'</a>';
   $number++;
}
if(isset($attempted))
{
    $screen='<div id="questionarea"><div style="padding-top:30%;"><h2>This team has already answered in this round!</h2><a id="nextbutton" onclick="rapidfire_showsets(teams[teami+1],teami+1);" class="button medium">Go to Next Team</a>';
}
$screen.='</div></div><div id="groupinfo">';
$mdata=$mysqli->query("SELECT * FROM teams WHERE id='$team' LIMIT 1");
$mrow=$mdata->fetch_assoc();
$screen.='<h1 style="font-size:75pt;margin:0;">'.$mrow['id'].'</h1><h1 style="margin:0;font-size:35px;">'.$mrow['name'].'</h1>';
$screen.='<div id="timer">60</div>';

//JS starts here!
$jscommand="timer=60;teami=$teami;round='rapidfire';response='junk';";

$data=array();
if(isset($screen))$data['containervalue']=$screen;
if(isset($jscommand))$data['js']=$jscommand;
header('Content-Type: application/json');
echo json_encode($data);
?>