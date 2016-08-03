<?php

$mysqli = new mysqli("localhost", "quizmaster", "quiz@aug15", "quiz");

$mdata=$mysqli->query("SELECT * FROM rounds WHERE id=$round LIMIT 1");
$mrow=$mdata->fetch_assoc();

$screen='
<div style="padding:10px;">
    <h2>Round '.$round.'</h2>
    <h1>'.$mrow['name'].'</h1>
    <p style="height:300px;">'.$mrow['description'].'</p>
    <a onclick="showselection('.$round.',teams[0],0);" class="button button-green">START ROUND</a>
</div>';

// Javscript starts here!
$mdata=$mysqli->query("SELECT id FROM teams");
$teams=array();
while($mrow=$mdata->fetch_assoc())
{
    array_push($teams,$mrow['id']);
}
$c=count($teams);
$r=$round-1;
$arr=array_merge(array_splice($teams,$r,$c-$r),array_splice($teams,0,$r));
$jscommand="teams=['".implode("','",$arr)."'];round=$round;";
?>