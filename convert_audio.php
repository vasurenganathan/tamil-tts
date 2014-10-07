<?php
function substr_unicode($str, $s, $l = null) {
    return join("", array_slice(
        preg_split("//u", $str, -1, PREG_SPLIT_NO_EMPTY), $s, $l));
}

function mb_str_split( $string ) {
  $split = preg_split('/\b([\(\).,\-\',:!\?;"\{\}\[\]„“»«‘\r\n]*)/u', $string, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);
  return array_filter($split, 'filter');
}

function filter($val) {
  if (trim($val) != '') {
    return trim($val);
  }
  return false;
}
function normalize_syllables($syllables){

  $new_syll = implode("%",$syllables);
  
  //remove all final stops
  $new_syll = preg_replace('/k%space/', 'space', $new_syll);
  $new_syll = preg_replace('/k%space/', 'space', $new_syll);
  $new_syll = preg_replace('/c%space/', 'space', $new_syll);
  $new_syll = preg_replace('/t%space/', 'space', $new_syll);
  $new_syll = preg_replace('/th%space/', 'space',$new_syll);
  $new_syll = preg_replace('/p%space/', 'space', $new_syll);
  //nasal and stop
  $new_syll = preg_replace('/%nnn%h/','%nnn%k',$new_syll);
  $new_syll = preg_replace('/%l%b/','%l%p',$new_syll);
  $new_syll = preg_replace('/%nn%h/','%nn%k',$new_syll);
  $new_syll = preg_replace('/%t%h/','%t%k',$new_syll);
  $new_syll = preg_replace('/%rr%h/','%rr%k',$new_syll);
  $new_syll = preg_replace('/%dhaa%h/','%dhaa%k',$new_syll);
  $new_syll = preg_replace('/stospace/','stop%space',$new_syll);

  
  return explode("%",$new_syll);
}
  
function mergeaudio($myarr){
    
    $audio_file = "";
    
    foreach($myarr as $mp3){
     
     if(!$mfile = file_get_contents($mp3)){
        //echo "<font color=red>" . $mp3 . "</font> ";
     }else{
        $audio_file .= $mfile;
        unset($mfile);
       //echo $mp3 . " ";
     }
    }
    
    $fname = random_string(10);
    $fname = $fname . ".mp3";
    
    file_put_contents("output/$fname",$audio_file);
    
    return $fname;
}

function url_merge_audio($myarr,$filename){
    
    $audio_file = "";
    
    foreach($myarr as $mp3){
     
     if(!$mfile = file_get_contents($mp3)){
        //echo "<font color=red>" . $mp3 . "</font> ";
     }else{
        $audio_file .= $mfile;
        unset($mfile);
       //echo $mp3 . " ";
     }
    }
       $space = file_get_contents("tamilsound/space.mp3");
       $audio_file .= $space;
    
    file_put_contents($filename,$audio_file,FILE_APPEND);
    
    return $filename;

}


function add_mp3_extension($mp3s){
    
    
    for($x=0; $x<count($mp3s);$x++){
        //add extension and prefix the location of sound files
        $mp3s[$x]  = "tamilsound/" . $mp3s[$x] . ".mp3";
        
    }
    
    return $mp3s;
}

function get_syllables($word){
    
    $word = str_replace('0','Œ',$word);

    
    $syl = array();
    $i = 0;

    while($chr = substr_unicode($word,0,1)){
         
        $rem = substr_unicode($word,1);
        
         switch($chr){
            
        case 'அ': $syl[$i++] = "a";
            break;
        case 'ஆ': $syl[$i++] = "aa";
            break;
        case 'இ': $syl[$i++] = "i";
            break;
        case 'ஈ': $syl[$i++] = "ii";
            break;
        case 'உ': $syl[$i++] = "u";
            break;
        case 'ஊ': $syl[$i++] = "uu";
            break;
        case 'எ': $syl[$i++] = "e";
            break;
        case 'ஏ': $syl[$i++] = "ee";
            break;
        case 'ஐ': $syl[$i++] = "ai";
            break;
        case 'ஒ': $syl[$i++] = "o";
            break;
        case 'ஓ': $syl[$i++] = "oo";
            break;
        case 'ஔ': $syl[$i++] = 'au';
            break;
        case 'க': $syl[$i++] = get_syllable("k",$rem);
            break;
        case 'ங': $syl[$i++] = get_syllable("ng",$rem);
            break;
        case 'ஞ': $syl[$i++] = get_syllable("nj",$rem);
            break;
        case 'ச': $syl[$i++] = get_syllable("c",$rem);
            break;
        case 'ட': $syl[$i++] = get_syllable("t",$rem);
            break;
        case 'த': $syl[$i++] = get_syllable("th",$rem);
            break;
        case 'ந': $syl[$i++] = get_syllable("n",$rem);
            break;
        case 'ன': $syl[$i++] = get_syllable("nn",$rem);
            break;
        case 'ப': $syl[$i++] = get_syllable("p",$rem);
            break;
        case 'ம': $syl[$i++] = get_syllable("m",$rem);
            break;
        case 'ய': $syl[$i++] = get_syllable("y",$rem);
            break;
        case 'ர': $syl[$i++] = get_syllable("r",$rem);
            break;
        case 'ல': $syl[$i++] = get_syllable("l",$rem);
            break;
        case 'வ':  $syl[$i++] = get_syllable("v",$rem);
            break;
        case 'ழ': $syl[$i++] = get_syllable("z",$rem);
            break;
        case 'ள': $syl[$i++] = get_syllable("ll",$rem);
            break;
        case 'ற': $syl[$i++] = get_syllable("rr",$rem);
            break;
        case 'ண': $syl[$i++] = get_syllable("nnn",$rem);
            break;
        case 'ஜ': $syl[$i++] = get_syllable("j",$rem);
            break;
        case 'ஷ': $syl[$i++] = get_syllable("sh",$rem);
            break;
        case 'ஹ': $syl[$i++] = get_syllable("h",$rem);
            break;
        case 'ஸ': $syl[$i++] = get_syllable("s",$rem);
            break;
        case 'ஸ்ரீ': $syl[$i++] = "sri";
            break;
        case 'க்ஷ': $syl[$i++] = get_syllable("ksh",$rem);
            break;
       
        default:
            if(preg_match("/[.!;?]$/",$chr)){
            
              $syl[$i++] = 'stop';
            
            }elseif(preg_match("/[0-9,Œ:@#]$/", $chr)){
                  
                 switch($chr){
                     case '1': $syl[$i++] = 'onru';
                     break;
                    case '2': $syl[$i++] = 'irandu';
                     break;
                    case '3': $syl[$i++] = 'muunru';
                     break;
                    case '4': $syl[$i++] = 'naanku';
                     break;
                    case '5': $syl[$i++] = 'ainthu';
                     break;
                    case '6': $syl[$i++] = 'aaru';
                     break;
                    case '7': $syl[$i++] = 'eezu';
                     break;
                    case '8': $syl[$i++] = 'ettu';
                     break;
                    case '9': $syl[$i++] = 'onpathu';
                     break;
                    case 'Œ': $syl[$i++] = 'saiphar';
                     break;
                 }
                 
                //ignore punctuations
            }elseif($chr == ' '){
            
                $syl[$i++] = 'space';
            }
            break;    
         }
         $word = substr_unicode($word,1);
    }
   
    return soften_stops($syl);
}

function get_syllable($chr,$str){
    
    $let = substr_unicode($str,0,1);
    
      switch($let){
        
    case '்': return $chr;  //pure consonant
        break;
    case 'ா': return $chr . "aa";
        break;
    case 'ி': return $chr . "i";
        break;
    case 'ீ': return $chr . "ii";
        break;
    case 'ு': return $chr . "u";
        break;
    case 'ூ': return $chr . "uu";
        break;
    case 'ெ': return $chr . "e";
        break;
    case 'ே': return $chr . "ee";
        break;
    case 'ொ': return $chr . "o";
        break;
    case 'ோ': return $chr . "oo";
        break;
    case 'ை': return $chr . "ai";
        break;
    case 'ௌ': return $chr . "au";
        break;
    
      }
      
     return $chr . "a";
}

function soften_stops($syllables){
    
    //soften intervocalic and after nasal stop consonants
    for($x=0; $x<count($syllables);$x++){
     
      if($x != 0){
     
        if(substr($syllables[$x],0,1) == 'k'){
          
         
            
            if(substr($syllables[$x-1],0,2) == 'ng'){
                
                $syllables[$x] = str_replace('k','ng',$syllables[$x]);
                
            }elseif($syllables[$x] != 'k' && $syllables[$x-1] != 'k' && $syllables[$x-1] != 'space'){
                
                $syllables[$x] = str_replace('k','h',$syllables[$x]);
                
            }
            
          }elseif(substr($syllables[$x],0,1) == 'c'){
          
    
            
            if($syllables[$x-1] == 'nj'){
                
                $syllables[$x] = str_replace('c','j',$syllables[$x]);
                
            }elseif($syllables[$x] != 'c' && $syllables[$x-1] != 'c' && $syllables[$x-1] != 'space'){
                
                $syllables[$x] = str_replace('c','s',$syllables[$x]);
                
            }
            
        
        }elseif(substr($syllables[$x],0,2) == 'th'){
            
            
            if($syllables[$x-1] == 'n'){
                
                $syllables[$x] = str_replace('th','dh',$syllables[$x]);
                
            }elseif($syllables[$x] != 'th' && $syllables[$x-1] != 'th' && $syllables[$x-1] != 'space'){
                
                $syllables[$x] = str_replace('th','dh',$syllables[$x]);
                
            }
            
        }elseif(substr($syllables[$x],0,1) == 't'){
            
            if($syllables[$x-1] == 'nnn'){
                
                $syllables[$x] = str_replace('t','d',$syllables[$x]);
                
            }elseif($syllables[$x] != 't' && $syllables[$x-1] != 't' && $syllables[$x-1] != 'space'){
                
                $syllables[$x] = str_replace('t','d',$syllables[$x]);
                
            }
            
        }elseif(substr($syllables[$x],0,1) == 'p'){
            
            if($syllables[$x-1] == 'm'){
                
                $syllables[$x] = str_replace('p','b',$syllables[$x]);
                
            }elseif($syllables[$x] != 'p' && $syllables[$x-1] != 'p' && $syllables[$x-1] != 'space'){
                
                $syllables[$x] = str_replace('p','b',$syllables[$x]);
                
            }
        }
    }
  } 
    return $syllables;
}

function random_string($length) {
    $key = '';
    $keys = array_merge(range(0, 9), range('a', 'z'));

    for ($i = 0; $i < $length; $i++) {
        $key .= $keys[array_rand($keys)];
    }

    return $key;
}

function sanitize($string = '', $is_filename = FALSE)
{
 // Replace all weird characters with dashes
 $string = preg_replace('/[^\w\-'. ($is_filename ? '~_\.' : ''). ']+/u', '-', $string);

 // Only allow one dash separator at a time (and make string lowercase)
 //strtolower(preg_replace('/--+/u', '-', $string), 'UTF-8');
 return $string;
}
?>
