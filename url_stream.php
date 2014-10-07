<html>
<head>
<body>
<?php
//header('Content-Type: text/plain;charset=utf-8');
error_reporting(0);
//ini_set('display_errors', 0);
//ini_set('max_execution_time',1500);
include('convert_audio.php');
include('portable_utf8.php');
$url_text = $_GET["url"];
$raw_text = file_get_contents($url_text);

if(!$raw_text){
    echo "Problem opening the URL: $url_text. Check to make sure this is a correct and a full URL with the prefix http:// and without leading /";
    exit;
}
//$today = date('Y-m-d');
//$file_name = $url_text . $today;

//$filename = sanitize($file_name);
$filename = random_string(10);
$audio_file = $filename . ".mp3";


$audio_file = "output/" . $audio_file;

//make file          
$utf8_text = strip_tags( $raw_text );
/* Decode HTML entities */
$utf8_text = html_entity_decode( $utf8_text, ENT_NOQUOTES, "UTF-8" );
$utf8_text = preg_replace("/[a-zA-Z0-9=@#$%^&*()_={}\|\"\'\>\<+;\/\:\,\_\-\[\]!]/", "", $utf8_text);
//mb_regex_encoding('UTF-8');
//mb_internal_encoding("UTF-8");
$text_array = preg_split('/\s+/',$utf8_text);

$sliced_array = array_slice($text_array,0,100); //first 100 words
$sliced_content = implode(" ",$sliced_array);
$syllables = get_syllables($sliced_content);
$syllables = normalize_syllables($syllables);
$mp3files = add_mp3_extension($syllables);
$outputfile = url_merge_audio($mp3files,$audio_file);
echo "<center>";
echo "<object width=\"300\" height=\"42\">
    <param name=\"src\" value=\"$outputfile\">
    <param name=\"autoplay\" value=\"false\">
    <param name=\"controller\" value=\"true\">
    <param name=\"bgcolor\" value=\"#FFFFFF\">
    <embed src=\"$outputfile\" autostart=\"true\" loop=\"false\" width=\"300\" height=\"42\" controller=\"true\" bgcolor=\"#FFFFFF\"></embed>
</object>";
echo "</center>";
echo $raw_text;
//stream the rest of the content
for($x=101;$x<count($text_array);$x++){
$syllables = get_syllables($text_array[$x]);
$syllables = normalize_syllables($syllables);
$mp3files = add_mp3_extension($syllables);
$outputfile = url_merge_audio($mp3files,$audio_file);
}


?>
</body>
</html>