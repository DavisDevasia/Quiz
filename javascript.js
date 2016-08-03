var teams=[];
var teami=0;
var round=0;
var questions=[];
var questioni=0;
var response='junk';
var forcetimerstop=false;
var rapidfire_i=0;
var rapidfire_qset=0;
var finalresult='';

function loadnprocess(address)
{
    $.ajax({
        url: address, 
        type:'get',
        success: function(data,status)
        {
            if(data.containervalue)
            document.getElementById('container').innerHTML=data.containervalue;
            if(data.js)eval(data.js);
        }
    });
}
function loadscreen(screenid,btn)
{
    loadnprocess('getscreen.php?screenid='+screenid);
    btn.classList.add('button-green');
}
function showselection(r,t,i)
{
    if(i<teams.length) loadnprocess('getroundoptions.php?round='+r+'&team='+t+'&teami='+i);
    else document.getElementById('container').innerHTML='<h1>This round is over!</h2>';
}
function showquestion(id)
{
    document.getElementById("questionarea").innerHTML=questions[id].question+'<br/><br/><br/><a class="button small" onclick="showoption('+id+',this);">Show Options!</a>';
    loadnprocess('markattempted.php?questionid='+questions[id]['id']);
    questioni=id;
}
function showoption(id,t)
{
    
    forcetimerstop=false;
    runtimer(21);//start timer!!
    timerStart(20);
    
    t.outerHTML=null;
    if(questions[id].hasoptions==1)
    {
    var temp='<div id="options">';
    $.each(questions[id].options,function(i,v){
        var fontsize=v.length>20?'12px':'18px';
        temp+='<a class="button" id="option_'+i+'" style="font-size:'+fontsize+';" onclick="select_option(\''+i+'\');">'+v+'</a>';
    });
    temp+='<br/><a id="checkbutton" style="display:none;" class="button button-green small" onclick="checkresponse(this);">Check</a></div>';
    }
    else var temp='<div id="options"><a class="button button-green" id="option_CORRECT" onclick="response=\'A\';checkresponse(null);">Correct</a><a class="button button-red" id="option_INCORRECT" onclick="response=\'B\';checkresponse(null);">Incorrect</a></div>'
    document.getElementById('container').innerHTML+=temp;
}
function select_option(i)
{
    var keys=['option_A','option_B','option_C','option_D'];
    $.each(keys,function(index,v){
        document.getElementById(v).classList.remove('button-yellow');
    });
    document.getElementById('option_'+i).classList.add('button-yellow');
    response=i;
    document.getElementById('checkbutton').style.display="inline-block";
}
function checkresponse(i){
    if(i!=null)i.outerHTML=null;
    forcetimerstop=true;
    loadnprocess('checkresponse.php?team='+teams[teami]+'&round='+round+'&questionid='+questions[questioni].id+'&response='+response+'&hasoptions='+questions[questioni].hasoptions);
}

function runtimer(time) // This function runs the timer and performs timeout tasks!!
{
    time=parseInt(time)-1;
    document.getElementById('timer').innerHTML=time;
    if(time>0)
    {
        if(!forcetimerstop)setTimeout('runtimer('+time+');',1000);
        else runtimer(1);
    }
    else
    {
        timerStop();
        if(!forcetimerstop)playSound('/audio/timer_timeout.mp3');
        if(round!='rapidfire'); // Round is 1-5 // Disabling feature is disabled!
        {
        if(questions[questioni].hasoptions==1)
           
        {
            //var keys=['option_A','option_B','option_C','option_D'];
            if(!forcetimerstop)document.getElementById('checkbutton').style.display="inline-block";
        }/*
        else var keys=['option_CORRECT'];
        $.each(keys,function(index,v){
            if(response=='junk')document.getElementById(v).classList.add('disabled');
            document.getElementById(v).removeAttribute('onclick');
        });
        }*/
        else // Round is rapidfire
        {
            if(!forcetimerstop)rapidfire_summary('timeout');
        }
    }
}
function verify(ans)
{
    if(response!='junk'){
        var rese=document.getElementById('option_'+response);
        rese.classList.remove('disabled');
        rese.classList.remove('button-yellow');
        rese.classList.add('button-red');
    }
    var anse=document.getElementById('option_'+ans);
    anse.classList.remove('disabled');
    anse.classList.remove('button-yellow');
    anse.classList.remove('button-red');
    anse.classList.add('button-green');
    if(document.getElementById('nextbutton'))document.getElementById('nextbutton').style.display='inline-block';
}

// RapidFire Functions
function rapidfire_showsets(team,teami)
{
    if(teami<teams.length)
        loadnprocess('rapidfire_getsets.php?team='+team+'&teami='+teami);
    else
        document.getElementById('container').innerHTML='<div id="questionarea"><h1>Round Complete!</h1><p>Rapid Fire round has been completed for all teams!</p></div>';
}

function rapidfire_start(qset)
{
    loadnprocess('rapidfire_start.php?qset='+qset);
}

function rapidfire_init()
{
    rapidfire_i=0;
    forcetimerstop=false;
    runtimer(61);timerStart(60);
    rapidfire_showq(0);
    document.getElementById('container').innerHTML+='<div id="options"><a class="button button-green" onclick="rapidfire_respond(1);">Correct</a><a class="button button-red" onclick="rapidfire_respond(0);">Incorrect</a><a class="button button-yellow" onclick="rapidfire_respond(\'pass\');">PASS</a>';
}

function rapidfire_showq(i)
{
    var j=0;
    var qlen=questions.length;
    i=i%qlen;
    while(questions[i].response!='pass'&&j<30){i=(++i)%qlen;j++}if(j>30){alert("Some cyclic error occurred!"); rapidfire_summary('unknown');}
    document.getElementById("questionarea").innerHTML=questions[i].question;
    questioni=i;
}
function rapidfire_respond(res)
{
    questions[questioni].response=res;
    if(res!='pass')rapidfire_i++;
    if(rapidfire_i<questions.length)rapidfire_showq(questioni+1);
    else{rapidfire_summary('complete');}
}
function rapidfire_summary(fcase)
{
    forcetimerstop=true;
    if(fcase=='complete')var msg="You have answered all questions!";
    else if(fcase=='timeout')var msg="You have run out of time!";
    else var msg="An expected error occured!";
    var summ='<table border="1" style="font-size:14px;margin-left:20px;border-radius:7px;"><tr><th>Question</th><th>Reponse</th><th>Score</th></tr>';
    var totcredit=0;
    $.each(questions,function(index,v){
        if(v['response']==1)
        {
            v['correct']=1;v['credit']="+5";
        }
        else{
            v['correct']=0;
            if(v['response']=='pass')v['credit']="0";else v['credit']="-2";
        }
        totcredit+=parseInt(v['credit']);
        summ+='<tr><td>'+v['question']+'</td><td>'+(v['response']=='1'?"Correct":(v['response']=='0'?"Wrong":"PASS"))+'</td><td '+(v['credit']>0?'class="button-green"':'')+(v['credit']<0?'class="button-red"':'')+'>'+v['credit']+'</td></tr>';
    });
    summ+='<tr><td colspan="2">TOTAL SCORE</td><td>'+totcredit+'</td></tr></table>'
    
    document.getElementById("questionarea").innerHTML="<h3 style='padding-top:50px;'>"+msg+"</h3>"+summ+'<br/><a class="button" onclick="rapidfire_saveresponse('+totcredit+');">Go to next team</a>';
    document.getElementById('options').outerHTML=null;
}
function rapidfire_saveresponse(credit)
{
    $.ajax({
        url: 'rapidfire_saveresponse.php?teami='+teami+'&team='+teams[teami]+'&score='+credit+'&qset='+rapidfire_qset, 
        type:'post',
        data:{'q':questions},
        success: function(data,status)
        {
            if(data.containervalue)
            document.getElementById('container').innerHTML=data.containervalue;
            if(data.js)eval(data.js);
        }
    });
}

// Result announcement functions!
function announce_result()
{
    document.getElementById('container').innerHTML='<div id="congrats" style="text-align:center;width:100%;">Congratulations!</div><table id="result"><tr><td><img src="/result/first.png" /></td><td id="result_1st"></td></tr><tr><td><img src="/result/second.png" /></td><td id="result_2nd"></td></tr><tr><td><img src="/result/third.png" /></td><td id="result_3rd"></td></tr></table>';
    playSound('/audio/applause.mp3');
    setTimeout("showup('result_3rd',finalresult[2].name+' ['+finalresult[2].score+' points]')",0);
    setTimeout("showup('result_2nd',finalresult[1].name+' ['+finalresult[1].score+' points]')",2000);
    setTimeout("showup('result_1st',finalresult[0].name+' ['+finalresult[0].score+' points]')",5000);
}
function showup(ele,val)
{
    document.getElementById(ele).innerHTML='<div style="animation: fadeIn 2s linear 0s 1 normal;">'+val+'</div>';
}

// Sound functions
function playSound(file)
{
    stopSound();
    sound.src=file;
    sound.play();
}
function stopSound()
{
    sound.pause();
    sound.currentTime=0;
}
function timerStart(sec)
{
    timerStop();
    timersound.src='/audio/timer_'+sec+'.mp3';
    timersound.play();
}
function timerStop()
{
    timersound.pause();
    timersound.currentTime=0;
}
$(document).bind('DOMSubtreeModified', function () {
   $.each(document.getElementsByClassName("button"),function(i,v){
    v.onmouseover=function(){playSound('/audio/button_mouseover.mp3');}
    v.onmousedown=function(){playSound('/audio/button_mousedown.mp3');}
    });
});
