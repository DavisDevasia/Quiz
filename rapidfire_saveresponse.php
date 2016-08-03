<?php
$team=$_GET['team'];
$teami=$_GET['teami'];
$qset=$_GET['qset'];
$score=$_GET['score'];

$entries=array();
foreach($_POST['q'] as $k=>$v)
{
    array_push($entries,"('$team','$qset','".$v['id']."','".$v['response']."','".$v['response']."','".($v['response']==1?"5":($v['response']=='pass'?'0':'-2'))."')");
}

$mysqli = new mysqli("localhost", "quizmaster", "quiz@aug15", "quiz");
$mysqli->query("INSERT INTO rapidfire_responses (team,qset,questionid,response,credit) VALUES ".implode(',',$entries));
$mysqli->query("INSERT INTO responses (team,round,correct,credit) VALUES ('$team','R','-1','$score')");
$mysqli->query("UPDATE teams SET score=score+$score WHERE id='$team' LIMIT 1");

$jscommand="rapidfire_showsets(teams[teami+1],teami+1);";
if(isset($jscommand))$data['js']=$jscommand;
header('Content-Type: application/json');
echo json_encode($data);
?>