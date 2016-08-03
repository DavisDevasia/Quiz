<?php
$screen='
<div style="font-weight:bold;padding-bottom:25px;">Rules of the Quiz!</div>
<div id="rulediv_1" style="display:block;text-align:left;">
1. Theme of the quiz is "Independent India"<br/><br/>
2. Each team will be referred to by their names.<br/><br/>
3. The quiz comprises of 5 rounds + Rapid Fire round<br/><br/>
</div>
<div id="rulediv_2" style="display:none;text-align:left;">
4. Each team can randomly select 1 question out of available choices in each round.<br/><br/>
5. In the first five rounds, for each correct answer, the team will be awarded "+10" points. However, there will be no negative points for a wrong answer.<br/><br/>
6. Teams have 20 seconds to answer a question in first five rounds.<br/><br/>
7. Time to answer a question starts once the quizmaster has completed reading the question and the options are displayed.<br/><br/>
8. Unattempted questions will be passed to the audience.<br/><br/>
</div>
<div id="rulediv_3" style="display:none;text-align:left;">
9. Rapid Fire round consits of 15 questions to each team to be answered within 60 seconds each.<br/><br/>
10. In this round, for each correct answer, the team wil be awarded "+5" points. Each wrong answer would give a  pentaly of "-2" points<br/><br/>
11. Teams can pass any question which can be attempted later if time permits.<br/><br/>
</div>
<div id="rulediv_4" style="display:none;text-align:left;">
12. Any of the team members can give the answer. The first response from the team will be considered final.<br/><br/>
13. Audience is requested to maintain the decorem of the quiz and to avoid prompting teams.<br/><br/>
14. Results will be announced at the end of the quiz.<br/><br/>
15. In any situation, the decision of the quizmaster will be final.
</div>
<div style="position:fixed;bottom:50px;width:90%;text-align:center;">
<a class="button small button-green" onclick="rulediv_1.style.display=\'block\';">Page 1</a>
<a class="button small" onclick="this.classList.add(\'button-green\');rulediv_1.style.display=\'none\';rulediv_2.style.display=\'block\';">Page 2</a>
<a class="button small" onclick="this.classList.add(\'button-green\');rulediv_2.style.display=\'none\';rulediv_3.style.display=\'block\';">Page 3</a>
<a class="button small" onclick="this.classList.add(\'button-green\');rulediv_3.style.display=\'none\';rulediv_4.style.display=\'block\';">Page 4</a></div>';
?>