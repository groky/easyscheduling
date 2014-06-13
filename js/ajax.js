function getXMLHttp()
{
  var xmlHttp

  try
  {
    //Firefox, Opera 8.0+, Safari
    xmlHttp = new XMLHttpRequest();
  }
  catch(e)
  {
    //Internet Explorer
    try
    {
      xmlHttp = new ActiveXObject("Msxml2.XMLHTTP");
    }
    catch(e)
    {
      try
      {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
      }
      catch(e)
      {
        alert("Your browser does not support AJAX!")
        return false;
      }
    }
  }
  return xmlHttp;
}

/*
 * get the option responders
 */
function getResponders(id)
{
  var xmlHttp = getXMLHttp();
  
  xmlHttp.onreadystatechange = function()
  {
    if(xmlHttp.readyState == 4)
    {
      HandleResponse(xmlHttp.responseText);
    }
  }

  xmlHttp.open("POST", "./webroot/ajax-poll.php", true);
  xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");   
  xmlHttp.send("id="+id);
}

function HandleResponse(response)
{
  document.getElementById('floating-div').innerHTML = response;
}
//end option responders

function getEventInfo(id)
{
  var xmlHttp = getXMLHttp();

  xmlHttp.onreadystatechange = function()
  {
    if(xmlHttp.readyState == 4)
    {
      HandleResponse(xmlHttp.responseText);
    }
  }

  xmlHttp.open("POST", "./webroot/ajax-event.php", true);
  xmlHttp.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");   
  xmlHttp.send("id="+id);
}
