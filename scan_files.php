<?php
$dir    = 'output';

$files = scandir($dir,1);

echo "<center><table border=2>";
foreach($files as $key => $val){
    
   
    echo "<tr><td>" . "<a href='output/" . $val . "'>" . $val . "</a><td><td>" . date("F d Y H:s.",filemtime('output/' . $val)) . "</td></tr>";
    
}
echo "</table></center>";

?>
