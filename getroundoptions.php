<?php
$round=$_GET['round'];$team=$_GET['team'];$teami=$_GET['teami'];

$mysqli = new mysqli("localhost", "quizmaster", "quiz@aug15", "quiz");
$preq=$mysqli->query("SELECT * FROM responses WHERE round='$round' AND team='$team' LIMIT 1");
while($preq->fetch_assoc())$attempted=true;
if($round=='T')$attempted=false;

$screen='<div id="questionarea"><div style="padding-top:15%;"><h1>Select a question:</h1>';

$mdata=$mysqli->query("SELECT * FROM questions WHERE round='$round' ORDER BY id");

$questions=array();
$number=1;
while($mrow=$mdata->fetch_assoc())
{
   $mrow['options']=array('A'=>$mrow['option_A'],'B'=>$mrow['option_B'],'C'=>$mrow['option_C'],'D'=>$mrow['option_D']);
   array_push($questions,$mrow);
   $dis=empty($mrow['attempted'])?'':' disabled';
   $onc=empty($dis)?' onclick="showquestion('.($number-1).');"':'';
   $screen.='<a'.$onc.' class="button medium'.$dis.'">'.$number.'</a>';
   $number++;
}
if(!empty($attempted))
{
    $screen='<div id="questionarea"><div style="padding-top:30%;"><h2>This team has already answered in this round!</h2><a id="nextbutton" onclick="showselection(round,teams[teami+1],teami+1);" class="button medium">Go to Next Team</a>';
}
$screen.='</div></div><div id="groupinfo">';
$mdata=$mysqli->query("SELECT * FROM teams WHERE id='$team' LIMIT 1");
$mrow=$mdata->fetch_assoc();
$screen.='<h1 style="font-size:75pt;margin:0;">'.$mrow['id'].'</h1><h1 style="margin:0;font-size:35px;">'.$mrow['name'].'</h1>';
$screen.='<div id="timer">20</div>';
/*$tq=$mysqli->query("SELECT id FROM teams ORDER BY id");
$tcount=0;
while($tr=$tq->fetch_assoc())$tcount++;
if($teami<($tcount-1))*/ // This portion is not required as of now!
$screen.='<a id="nextbutton" onclick="showselection(round,teams[teami+1],teami+1);" style="display:none;" class="button medium">Next Team</a>';
$screen.='</div>';

//JS starts here!
$jscommand="questions=data.q;timer=60;teami=$teami;response='junk';";

$data=array();
$data['q']=$questions;
if(isset($screen))$data['containervalue']=$screen;
if(isset($jscommand))$data['js']=$jscommand;
header('Content-Type: application/json');
echo json_encode($data);
?>