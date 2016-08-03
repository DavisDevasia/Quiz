<?php

switch($_GET['screenid'])
{
    case 'intro':include('screens/intro.php');break;
    case 'rules':include('screens/rules.php');break;
    case 'round1':$round=1;include('screens/round.php');break;
    case 'round2':$round=2;include('screens/round.php');break;
    case 'round3':$round=3;include('screens/round.php');break;
    case 'round4':$round=4;include('screens/round.php');break;
    case 'round5':$round=5;include('screens/round.php');break;
    case 'round6':$round=6;include('screens/round.php');break;
    case 'rapidfire':include('screens/rapidfire.php');break;
    case 'result':include('screens/result.php');break;
    case 'tiebreak':include('screens/tiebreak.php');break;
}

if(!isset($screen))$screen="No return!";
$data=array('containervalue'=>$screen);
if(isset($jscommand)){$data['js']=$jscommand;}
if(isset($result)){$data['result']=$result;}
header('Content-Type: application/json');
echo json_encode($data);

?>