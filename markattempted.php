<?php
$id=$_GET['questionid'];

$mysqli = new mysqli("localhost", "quizmaster", "quiz@aug15", "quiz");
$mdata=$mysqli->query("UPDATE questions SET attempted = '1' WHERE id='$id' LIMIT 1");
header('Content-Type: application/json');
echo json_encode(array());
?>