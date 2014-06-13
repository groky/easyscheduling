<?php

?>

<script type="text/javascript">

function getBrowserHeight() {
    var intH = 0;
    var intW = 0;
   
    if(typeof window.innerWidth  == 'number' ) {
       intH = window.innerHeight;
       intW = window.innerWidth;
    } 
    else if(document.documentElement && (document.documentElement.clientWidth || document.documentElement.clientHeight)) {
        intH = document.documentElement.clientHeight;
        intW = document.documentElement.clientWidth;
    }
    else if(document.body && (document.body.clientWidth || document.body.clientHeight)) {
        intH = document.body.clientHeight;
        intW = document.body.clientWidth;
    }

    return { width: parseInt(intW), height: parseInt(intH) };
}  

function setLayerPosition() {
    var shadow = document.getElementById("shadow");
    //var question = document.getElementById("question");

    var bws = getBrowserHeight();
    shadow.style.width = bws.width + "px";
    shadow.style.height = bws.height + "px";

    //question.style.left = parseInt((bws.width - 350) / 2);
    //question.style.top = parseInt((bws.height - 200) / 2);

    shadow = null;
    //question = null;
}

function showLayer() {
    setLayerPosition();

    var shadow = document.getElementById("shadow");
    var warn = document.getElementById("warn");

    shadow.style.display = "block"; 
	if (document.getElementById)
	{
		warn.style.display = "block";
		warn.style.visibility = "visible";
	
	}
	else if (document.all)
	{
		document.all["warn"].style.display = "block";
		document.all["warn"].style.visibility = "visible";
	
	}
	else if (document.layers)
	{
		document.layers["warn"].style.display = "block";
		document.layers["warn"].style.visibility = "visible";
	}

    shadow = null;
    warn = null;             
}

function hideLayer() {
    var shadow = document.getElementById("shadow");
    var warn = document.getElementById("warn");

    shadow.style.display = "none"; 
    warn.style.display = "none";

    shadow = null;
    warn = null; 
}

window.onresize = setLayerPosition;

</script>

<style>
div.topbox {
	/*position:absolute;*/	
	border: 2px solid #2DA6F7;
	background-color: #DAF2F7;
	padding: 1px;
	filter: alpha(opacity = 85);
	opacity: 0.95;
	-moz-opacity: 0.95;
	font-family: verdana;
	letter-spacing: 0px;
	width: 600px;
	color: black;

	margin-left:auto;
	margin-right:auto;
 	
        /*top:0px;
        left:0px;*/
        display:none;
        z-Index:1001;
        text-align:center;
        vertical-align:middle;

}

div.topbox h1 {
	/*margin: 0px;*/
	padding: 10px 0px 0px 10px;
	font-size: 18px;
	font-weight: 700;
}

div.topbox p {
	/*margin: 0px;*/
	padding: 5px 10px 20px 15px;
	font-size: 12px;
	font-weight: 700;
}

div.topbox p a {
	color: #f90;
}

div.opaqueLayer {
	display: none;
	position: absolute;
	top: 0px;
	left: 0px;
	opacity: 0.6;
	filter: alpha(opacity = 60);
	background-color: #DAF2F7;
	z-Index: 1000;
}

</style>


<div id="shadow" class="opaqueLayer"></div>
<div id="warn"
	style="display: block; position: absolute; top: 100px; left: 100px; visibility: hidden;"
	class="topbox">

<div
	style="background-color: #2DA6F7; padding: 5px; text-align: center; font-size: 12px; font-weight: 700;"><a
	href="#" onclick="javascript:hideLayer();return false;"
	style="text-decoration: none; color: #fff;">close</a></div>

<br />
Your message comes here. <br />
<br />

<div
	style="background-color: #2DA6F7; padding: 5px; text-align: center; font-size: 12px; font-weight: 700;"><a
	href="#" onclick="javascript:hideLayer();return false;"
	style="text-decoration: none; color: #fff;">close</a></div>

</div>
