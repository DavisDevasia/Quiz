<?php
$qset=$_GET['qset'];

$mysqli = new mysqli("localhost", "quizmaster", "quiz@aug15", "quiz");
$mysqli->query("UPDATE rapidfire_qsets SET attempted=1 WHERE qset='$qset' LIMIT 1");
$mdata=$mysqli->query("SELECT * FROM rapidfire_questions WHERE qset='$qset' ORDER BY id");

$rf_q=array();
while($mrow=$mdata->fetch_assoc())
{
   $mrow['response']='pass';
   array_push($rf_q,$mrow);
}

//JS starts here!
$jscommand="questions=data.q;rapidfire_qset=$qset;rapidfire_init();";

$data=array();
$data['q']=$rf_q;
if(isset($screen))$data['containervalue']=$screen;
if(isset($jscommand))$data['js']=$jscommand;
header('Content-Type: application/json');
echo json_encode($data);
?>