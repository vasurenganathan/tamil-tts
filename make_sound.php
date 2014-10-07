<?php
error_reporting(0);
ini_set('display_errors', 0);
include('convert_audio.php');
$inptxt = $_POST["INPTXT"];
$syllables = get_syllables($inptxt);

$syllables = normalize_syllables($syllables);

$mp3files = add_mp3_extension($syllables);
$outputfile = mergeaudio($mp3files);
echo "<br>";
echo "<object width=\"300\" height=\"42\">
    <param name=\"src\" value=\"output/$outputfile\">
    <param name=\"autoplay\" value=\"false\">
    <param name=\"controller\" value=\"true\">
    <param name=\"bgcolor\" value=\"#FFFFFF\">
    <embed src=\"output/$outputfile\" autostart=\"true\" loop=\"false\" width=\"300\" height=\"42\" controller=\"true\" bgcolor=\"#FFFFFF\"></embed>
</object>";

echo "<center><a href=\"output/$outputfile\">Download this file</a>
      <br>(You can right click your mouse on this link and use the option 'save link as' to save this file in your system).</center>";

exit;

?>
