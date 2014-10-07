<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script language=Javascript src="http://www.thetamillanguage.com/sangam/js/lexicon_head.js"></script>
<style type="text/css"> 
div.FAQ { color: #336633; font-weight: bold; font-size: 12px; font-family: Arial, sans-serif; 
background-color: #ffffcc; text-align: center; padding: 10px; border: solid 1px; position: absolute; 
display: none } 
#UNIQUEID { background-color: #ffc; position: relative; display: none }
</style>
<body>
<div id="UNIQUEID" class="FAQ"></div> 
<?php
error_reporting(0);
//ini_set('display_errors', 0);
//ini_set('max_execution_time',1500);
include('portable_utf8.php');
$url_text = $_GET["url"];
$raw_text = file_get_contents($url_text);

if(!$raw_text){
    echo "Problem opening the URL: $url_text. Check to make sure this is a correct and a full URL with the prefix http:// and without leading /";
    exit;
}
//make file          
$utf8_text = strip_tags( $raw_text );
/* Decode HTML entities */
$utf8_text = html_entity_decode( $utf8_text, ENT_NOQUOTES, "UTF-8" );
$utf8_text = preg_replace("/[a-zA-Z0-9=@#$%^&*()_={}\|\"\'\>\<+;\/\:\,\_\-\[\]!]/", "", $utf8_text);
//mb_regex_encoding('UTF-8');
//mb_internal_encoding("UTF-8");
$text_array = preg_split('/\s+/',$utf8_text);
 
$words = array_unique($text_array);

for($x=0;$x<count($words);$x++){
    if(in_array(substr_unicode($words[$x],-2),array("க்","ச்","ட்","த்","ப்","ந்"))){
    $words[$x] = rtrim($words[$x],substr_unicode($words[$x],-2));
    }
    
    $glossed_word = "<a onMouseOver=\"ShowContentLex('UNIQUEID','" . $words[$x] . "'); return true;\" onMouseOut=\"HideContentLex('UNIQUEID'); return true;\" href=\"#\" target=\"_self\">" . $words[$x] . "</a>";
   
    echo $glossed_word . " ";
   // $raw_text = str_replace($words[$x], $glossed_word,$raw_text);
}
exit;
echo $raw_text;

function substr_unicode($str, $s, $l = null) {
    return join("", array_slice(
        preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY), $s, $l));
}
?>

</body>
</html>
