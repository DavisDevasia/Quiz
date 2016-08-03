<?php
$team=$_GET['team'];
$response=$_GET['response'];
$qid=$_GET['questionid'];
$round=$_GET['round'];

$mysqli = new mysqli("localhost", "quizmaster", "quiz@aug15", "quiz");
$mdata=$mysqli->query("SELECT answer FROM questions WHERE id='$qid' LIMIT 1");
$mrow=$mdata->fetch_assoc();

if($mrow['answer']==$response){$correct='1';$credit='10';}
else{$correct='0';$credit='0';}
$mysqli->query("INSERT INTO responses (team,round,correct,credit) VALUES('$team','$round','$correct','$credit')");
$mysqli->query("UPDATE teams SET score=score+$credit WHERE id='$team' LIMIT 1");

$data=array();
$data['answer']=$mrow['answer'];
if(!empty($_GET['hasoptions']))$jscommand="verify(data.answer);";
else $jscommand="showselection(round,teams[teami+1],teami+1);";
if(isset($screen))$data['containervalue']=$screen;
if(isset($jscommand))$data['js']=$jscommand;
header('Content-Type: application/json');
echo json_encode($data);
?>