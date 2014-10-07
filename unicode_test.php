<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body>
<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$txt = "இது தமிழ்";


echo substr_uni($txt,6,1);


function substr_uni($str, $s, $l= null){
    
    return mb_substr($str,$s,$l,'UTF-8');
    
}

function substr_unicode($str, $s, $l = null) {
    return join("", array_slice(
        preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY), $s, $l));
}

?>
</body>
</html>