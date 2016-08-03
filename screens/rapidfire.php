<?php
$screen='
<div style="padding:10px;">
    <h2>Last Hurdle</h2>
    <h1>Rapid Fire</h1>
    <p style="height:300px;">You will have 60 seconds to answer 10 questions!
    <br /><br />
    <br />You get +5 score for a correct answer!
    <br />and -2 score for a wrong answer!</p>
    <a onclick="rapidfire_showsets(teams[0],0);" class="button button-green">START</a>
</div>';

// Javscript starts here!
$mysqli = new mysqli("localhost", "quizmaster", "quiz@aug15", "quiz");
$mdata=$mysqli->query("SELECT id FROM teams");
$teams=array();
while($mrow=$mdata->fetch_assoc())
{
    array_push($teams,$mrow['id']);
}
$c=count($teams);
$r=5;
$arr=array_merge(array_splice($teams,$r,$c-$r),array_splice($teams,0,$r));
$jscommand="teams=['".implode("','",$arr)."'];";
?>