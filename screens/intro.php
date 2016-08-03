<?php
$mysqli = new mysqli("localhost", "quizmaster", "quiz@aug15", "quiz");
$intro=$mysqli->query("SELECT * FROM teams ORDER BY id");
$teams='';$ti=2;
while($v=$intro->fetch_assoc())
{
    $teams.='<div id="introdiv_'.$ti.'" style="display:none;">
<img src="/teamphotos/'.$v['id'].'.jpg"width="600" height="350">
<h3>'.$v['participants'].'</h3>
<h2>'.$v['id'].' - '.$v['name'].'</h2>
</div>';
$ti++;
}
$screen='
<div style="font-weight:bold;padding-bottom:25px;font-size:35px;">Welcome to the Quiz!</div>
<div id="introdiv_1" style="display:block;">
The department of Electronics & Communication welcomes all of you to the Independence Day Quiz 2015!
</div>
'.$teams.'
<div style="position:fixed;bottom:50px;width:90%;text-align:center;">
<a class="button small button-green" onclick="introdiv_1.style.display=\'block\';">Welcome</a>
<a class="button small" onclick="this.classList.add(\'button-green\');introdiv_1.style.display=\'none\';introdiv_2.style.display=\'block\';">Group 1</a>
<a class="button small" onclick="this.classList.add(\'button-green\');introdiv_2.style.display=\'none\';introdiv_3.style.display=\'block\';">Group 2</a>
<a class="button small" onclick="this.classList.add(\'button-green\');introdiv_3.style.display=\'none\';introdiv_4.style.display=\'block\';">Group 3</a>
<a class="button small" onclick="this.classList.add(\'button-green\');introdiv_4.style.display=\'none\';introdiv_5.style.display=\'block\';">Group 4</a>
<a class="button small" onclick="this.classList.add(\'button-green\');introdiv_5.style.display=\'none\';introdiv_6.style.display=\'block\';">Group 5</a>
<a class="button small" onclick="this.classList.add(\'button-green\');introdiv_6.style.display=\'none\';introdiv_7.style.display=\'block\';">Group 6</a>
</div>';
?>