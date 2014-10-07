///////////////////////////
/*Script name: ajax.js
Include this script in your PHP file as below:
<script language='Javascript' src='ajax.js'></script>

This script can be used for update and add routines
call the function postit('uniquefieldname','uniquefieldvalue','scriptname')
It also requires a div element in your HTML/PHP file to be called outMsg as below:
<div> <span id="outMsg"></span> </div>
This script builds post string from form elements and sends it to the script
PHP script receives this poststring as $_POST[] array
This script works with all of form elements including
text,radio,pull-down and check boxes.
/////////////////////////////
*/

//Constant variable for AJAX object 
var xmlHttp

//function to get values of radiobuttons
function get_radio_value(q){
//if there is only one radiobutton use the function get_one_radio_value()
 if(eval("!document.form1."+q+".length")){
		  return get_one_radio_value(q);
	}else{
	
			for(x=0;x<eval("document.form1."+q+".length");x++){
				if (eval("document.form1."+q+"[x].checked == true")){
		   			return eval("document.form1."+q+"[x].value");
			}
	}
	return "";

 }
}

//if there is only one radio button, use this function to get value
//As there won't be an array for just one radio form element, we need
//to get the value without array object
function get_one_radio_value(q){

   if(eval("document.form1."+q+".checked==true")){
		 return eval("document.form1."+q+".value");
	 }else{
		 return "";
	 }
}

//Get values from checkbox.  All the checked values are separated by comma
//function to get values of checkboxes
function get_checkbox_value(q){
//if there is only one radiobutton use the function get_one_radio_value()
 if(eval("!document.form1."+q+".length")){
		  return get_one_checkbox_value(q);
	}else{
	
	   var outstr = "";
	   
			for(x=0;x<eval("document.form1."+q+".length");x++){
				if (eval("document.form1."+q+"[x].checked == true")){
		   			outstr += eval("document.form1."+q+"[x].value") + ", ";
			}
			
			return outstr;
	}
	return "";

 }
}

//if there is only one radio button, use this function to get value
//As there won't be an array for just one radio form element, we need
//to get the value without array object
function get_one_checkbox_value(q){

   if(eval("document.form1."+q+".checked==true")){
		 return eval("document.form1."+q+".value");
	 }else{
		 return "";
	 }
}




//makes an unique array removing all duplicates
function unique(a) {
   var r = new Array();
   o:for(var i = 0, n = a.length; i < n; i++) {
      for(var x = 0, y = r.length; x < y; x++)
         if(r[x]==a[i]) continue o;
      r[r.length] = a[i];
   }
   return r;
}


//*********************************************************************
//Main function that builds Post string
//Call this function with unique field name, its value and script name
//The div outMsg displays the output message from the script
//*********************************************************************
function postit(scriptname)
{

 document.getElementById("speakid").innerHTML= "<center><font color=red>Please wait.... </font><img src='ajax-loader.gif'></center>"; 
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null)
  {
  alert ("Your browser does not support AJAX!");
  return;
  } 
 
 poststr = "INPTXT="+document.form1.inptxt.value;
//build url
var url=scriptname;
xmlHttp.onreadystatechange=displayUpdate;
xmlHttp.open("POST",url,true);
xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xmlHttp.setRequestHeader("Content-length", poststr.length);
xmlHttp.setRequestHeader("Connection", "close");
xmlHttp.send(poststr);

} 
//function that displays output message from the script
function displayUpdate() 
{ 

if (xmlHttp.readyState==4)
{ 
document.getElementById("speakid").innerHTML=xmlHttp.responseText;
}
}


function playit(scriptname)
{

 document.getElementById("speakid").innerHTML= "<font color=red>Please wait..... </font><img src='ajax-loader.gif'></blink>";
 	
  
xmlHttp=GetXmlHttpObject();
if (xmlHttp==null)
  {
  alert ("Your browser does not support AJAX!");
  return;
  } 
 
 poststr = "INPTXT="+document.form1.inptxt.value;
//build url
var url=scriptname;
xmlHttp.onreadystatechange=playMyfile;
xmlHttp.open("POST",url,true);
xmlHttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
xmlHttp.setRequestHeader("Content-length", poststr.length);
xmlHttp.setRequestHeader("Connection", "close");
xmlHttp.send(poststr);

}

//function that plays audio
function playMyfile() 
{ 

if (xmlHttp.readyState==4)
{

document.getElementById("speakid").innerHTML="<embed src='"+xmlhttp.responseText+"' hidden='true' autostart='true' loop='false' />"; 

}
}

//******************************************
//function to create object based on browser
//******************************************
function GetXmlHttpObject()
{
var xmlHttp=null;
try
  {
  // Firefox, Opera 8.0+, Safari
  xmlHttp=new XMLHttpRequest();
  }
catch (e)
  {
  // Internet Explorer
  try
    {
    xmlHttp=new ActiveXObject("Msxml2.XMLHTTP");
    }
  catch (e)
    {
    xmlHttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
  }
return xmlHttp;
}

