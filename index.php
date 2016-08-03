<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>QUIZ 2015</title>
  <link href="style.css" rel="stylesheet" />
  <script src="jquery.min.js"></script>
  <script src="javascript.js"></script>
</head>
<body>
  <div id="title">INDEPENDENCE DAY QUIZ 2015</div>
  <div id="container">
    <video src="/vandemataram.mp4" width="100%" height="100%" controls="true"></video>
  </div>
  <div id="controllermain">
        <a onclick="loadscreen('intro',this);" class="button small">Intro</a>
        <a onclick="loadscreen('rules',this);" class="button small">Rules</a>
        <a onclick="loadscreen('round1',this);" class="button small">Round 1</a>
        <a onclick="loadscreen('round2',this);" class="button small">Round 2</a>
        <a onclick="loadscreen('round3',this);" class="button small">Round 3</a>
        <a onclick="loadscreen('round4',this);" class="button small">Round 4</a>
        <a onclick="loadscreen('round5',this);" class="button small">Round 5</a>
        <a onclick="loadscreen('rapidfire',this);" class="button small">Rapid Fire</a>
        <a onclick="loadscreen('result',this);" class="button small">Result</a>
        <audio id="sound"></audio>
        <audio id="timersound"></audio>
  </div>
</body>
</html>
