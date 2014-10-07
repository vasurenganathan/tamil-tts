<?php
error_reporting(0);
ini_set('display_errors', 0);
ini_set('max_execution_time',1500);
include('convert_audio.php');

//$url_text = "http://www.dinamani.com";
$url_text = $_POST["INPTXT"];

$raw_text = file_get_contents($url_text);

if(!$raw_text){
    echo "Problem opening the URL: $url_text. Check to make sure this is a correct and a full URL with the prefix http://";
    exit;
}
$today = date('Y-m-d');
$file_name = $url_text . $today;

$filename = sanitize($file_name);
$audio_file = $filename . "." . "mp3";

$audio_file = "output/" . $audio_file;

//is this file already made?
if(!file_exists($audio_file)){
//make file          
$utf8_text = strip_tags( $raw_text );
/* Decode HTML entities */
$utf8_text = html_entity_decode( $utf8_text, ENT_NOQUOTES, "UTF-8" );
$utf8_text = preg_replace("/[a-zA-Z0-9=@#$%^&*()_={}\|\"\'\>\<+;\/\:\,\_\-\[\]!]/", "", $utf8_text);

$syllables = get_syllables($utf8_text);

$syllables = normalize_syllables($syllables);
$mp3files = add_mp3_extension($syllables);

$outputfile = url_merge_audio($mp3files,$audio_file);

}else{
    $outputfile = $audio_file;
}
echo "<br>";
echo "<object width=\"300\" height=\"42\">
    <param name=\"src\" value=\"$outputfile\">
    <param name=\"autoplay\" value=\"false\">
    <param name=\"controller\" value=\"true\">
    <param name=\"bgcolor\" value=\"#FFFFFF\">
    <embed src=\"$outputfile\" autostart=\"true\" loop=\"false\" width=\"300\" height=\"42\" controller=\"true\" bgcolor=\"#FFFFFF\"></embed>
</object>";
echo "<center><a href=\"$outputfile\">Download this file</a>
      <br>(You can right click your mouse on this link and use the option 'save link as' to save this file in your system).</center>";
echo $raw_text;
exit;

?>