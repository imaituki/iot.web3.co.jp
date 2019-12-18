<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// --------------------------------------------------------------------

/**
 * USER_AGENTを元にアクセス元を取得します。
 */
function get_client()
{
	$platform = 'PC';

	//携帯UA取得
	$agent = $_SERVER["HTTP_USER_AGENT"];

	if(preg_match("/iPhone|iPad|iPod/i", $agent))
	{
    	$platform = "S-iphone";// iPhone
	}
	elseif(preg_match("/Android/i", $agent))
	{
    	$platform = "S-android";// Android
	}
	elseif(preg_match("/Windows Phone/i", $agent))
	{
    	$platform = "S-windowsphone";// Windows Phone
	}
	elseif(preg_match("/BlackBerry/i", $agent))
	{
    	$platform = "S-blackberry";// BlackBerry
	}
	elseif(preg_match("/^PDXGW/i", $agent) || preg_match("/(DDIPOCKET|WILLCOM);/i", $agent))
	{
    	$platform = "S-willcom";// willcom
	} 
	elseif(preg_match("/^DoCoMo\/[12]\.0.*?c([0-9]+)/i", $agent, $match))
	{
		if($match[1]<500)
		{
			$platform = "K-imode1";// i-mode1.0
		}
		else
		{
			$platform = "K-imode2";// i-mode2.0
		}
	}
	elseif(preg_match("/^(J\-PHONE|Vodafone|MOT\-[CV]980|SoftBank)\//i", $agent))
	{
    	$platform = "K-softbank";// softbank
	}
	elseif(preg_match("/^KDDI\-/i", $agent) || preg_match("/UP\.Browser/i", $agent))
	{
    	$platform = "K-ezweb";// ezweb
	}
	else
	{
    	$platform = "PC";// PC
	}

	return $platform;
}


// --------------------------------------------------------------------

/**
 * fgetcsv()の不具合を解消したCSVの読み込み関数
 * 
 * @param unknown_type $handle
 * @param unknown_type $length
 * @param unknown_type $d
 * @param unknown_type $e
 */
function fgetcsv_reg (&$handle, $length = null, $d = ',', $e = '"')
{
	$d = preg_quote($d);
	$e = preg_quote($e);
	$_line = "";

	$eof = false;

	while ($eof != true) 
	{
		$_line .= (empty($length) ? fgets($handle) : fgets($handle, $length));
		$itemcnt = preg_match_all('/'.$e.'/', $_line, $dummy);

		if ($itemcnt % 2 == 0) 
		{
			$eof = true;
		}
	}

	$_csv_line = preg_replace('/(?:\r\n|[\r\n])?$/', $d, trim($_line));
	$_csv_pattern = '/('.$e.'[^'.$e.']*(?:'.$e.$e.'[^'.$e.']*)*'.$e.'|[^'.$d.']*)'.$d.'/';

	preg_match_all($_csv_pattern, $_csv_line, $_csv_matches);
	$_csv_data = $_csv_matches[1];

	for($_csv_i=0; $_csv_i<count($_csv_data); $_csv_i++)
	{
		$_csv_data[$_csv_i]=preg_replace('/^'.$e.'(.*)'.$e.'$/s','$1',$_csv_data[$_csv_i]);
		$_csv_data[$_csv_i]=str_replace($e.$e, $e, $_csv_data[$_csv_i]);
	}

	return empty($_line) ? false : $_csv_data;
}


// --------------------------------------------------------------------

/**
 * Converts PHP variable or array into a "JSON" (JavaScript value expression
 * or "object notation") string.
 *
 * @compat
 *    Output seems identical to PECL versions. "Only" 20x slower than PECL version.
 * @bugs
 *    Doesn't take care with unicode too much - leaves UTF-8 sequences alone.
 *
 * @param  $var mixed  PHP variable/array/object
 * @return string      transformed into JSON equivalent
 */
if (!function_exists("json_encode")) {
   function json_encode($var, /*emu_args*/$obj=FALSE) {
   
      #-- prepare JSON string
      $json = "";
      
      #-- add array entries
      if (is_array($var) || ($obj=is_object($var))) {

         #-- check if array is associative
         if (!$obj) foreach ((array)$var as $i=>$v) {
            if (!is_int($i)) {
               $obj = 1;
               break;
            }
         }

         #-- concat invidual entries
         foreach ((array)$var as $i=>$v) {
            $json .= ($json ? "," : "")    // comma separators
                   . ($obj ? ("\"$i\":") : "")   // assoc prefix
                   . (json_encode($v));    // value
         }

         #-- enclose into braces or brackets
         $json = $obj ? "{".$json."}" : "[".$json."]";
      }

      #-- strings need some care
      elseif (is_string($var)) {
         if (!utf8_decode($var)) {
            $var = utf8_encode($var);
         }
         $var = str_replace(array("\\", "\"", "/", "\b", "\f", "\n", "\r", "\t"), array("\\\\", '\"', "\\/", "\\b", "\\f", "\\n", "\\r", "\\t"), $var);
         $json = '"' . $var . '"';
         //@COMPAT: for fully-fully-compliance   $var = preg_replace("/[\000-\037]/", "", $var);
      }

      #-- basic types
      elseif (is_bool($var)) {
         $json = $var ? "true" : "false";
      }
      elseif ($var === NULL) {
         $json = "null";
      }
      elseif (is_int($var) || is_float($var)) {
         $json = "$var";
      }

      #-- something went wrong
      else {
         trigger_error("json_encode: don't know what a '" .gettype($var). "' is.", E_USER_ERROR);
      }
      
      #-- done
      return($json);
   }
}



/**
 * Parses a JSON (JavaScript value expression) string into a PHP variable
 * (array or object).
 *
 * @compat
 *    Behaves similar to PECL version, but is less quiet on errors.
 *    Now even decodes unicode \uXXXX string escapes into UTF-8.
 *    "Only" 27 times slower than native function.
 * @bugs
 *    Might parse some misformed representations, when other implementations
 *    would scream error or explode.
 * @code
 *    This is state machine spaghetti code. Needs the extranous parameters to
 *    process subarrays, etc. When it recursively calls itself, $n is the
 *    current position, and $waitfor a string with possible end-tokens.
 *
 * @param   $json string   JSON encoded values
 * @param   $assoc bool    pack data into php array/hashes instead of objects
 * @return  mixed          parsed into PHP variable/array/object
 */
if (!function_exists("json_decode")) {
   function json_decode($json, $assoc=FALSE, $limit=512, /*emu_args*/$n=0,$state=0,$waitfor=0) {

      #-- result var
      $val = NULL;
      static $lang_eq = array("true" => TRUE, "false" => FALSE, "null" => NULL);
      static $str_eq = array("n"=>"\012", "r"=>"\015", "\\"=>"\\", '"'=>'"', "f"=>"\f", "b"=>"\b", "t"=>"\t", "/"=>"/");
      if ($limit<0) return /* __cannot_compensate */;

      #-- flat char-wise parsing
      for (/*n*/; $n<strlen($json); /*n*/) {
         $c = $json[$n];

         #-= in-string
         if ($state==='"') {

            if ($c == '\\') {
               $c = $json[++$n];
               // simple C escapes
               if (isset($str_eq[$c])) {
                  $val .= $str_eq[$c];
               }

               // here we transform \uXXXX Unicode (always 4 nibbles) references to UTF-8
               elseif ($c == "u") {
                  // read just 16bit (therefore value can't be negative)
                  $hex = hexdec( substr($json, $n+1, 4) );
                  $n += 4;
                  // Unicode ranges
                  if ($hex < 0x80) {    // plain ASCII character
                     $val .= chr($hex);
                  }
                  elseif ($hex < 0x800) {   // 110xxxxx 10xxxxxx 
                     $val .= chr(0xC0 + $hex>>6) . chr(0x80 + $hex&63);
                  }
                  elseif ($hex <= 0xFFFF) { // 1110xxxx 10xxxxxx 10xxxxxx 
                     $val .= chr(0xE0 + $hex>>12) . chr(0x80 + ($hex>>6)&63) . chr(0x80 + $hex&63);
                  }
                  // other ranges, like 0x1FFFFF=0xF0, 0x3FFFFFF=0xF8 and 0x7FFFFFFF=0xFC do not apply
               }

               // no escape, just a redundant backslash
               //@COMPAT: we could throw an exception here
               else {
                  $val .= "\\" . $c;
               }
            }

            // end of string
            elseif ($c == '"') {
               $state = 0;
            }

            // yeeha! a single character found!!!!1!
            else/*if (ord($c) >= 32)*/ { //@COMPAT: specialchars check - but native json doesn't do it?
               $val .= $c;
            }
         }

         #-> end of sub-call (array/object)
         elseif ($waitfor && (strpos($waitfor, $c) !== false)) {
            return array($val, $n);  // return current value and state
         }
         
         #-= in-array
         elseif ($state===']') {
            list($v, $n) = json_decode($json, $assoc, $limit, $n, 0, ",]");
            $val[] = $v;
            if ($json[$n] == "]") { return array($val, $n); }
         }

         #-= in-object
         elseif ($state==='}') {
            list($i, $n) = json_decode($json, $assoc, $limit, $n, 0, ":");   // this allowed non-string indicies
            list($v, $n) = json_decode($json, $assoc, $limit, $n+1, 0, ",}");
            $val[$i] = $v;
            if ($json[$n] == "}") { return array($val, $n); }
         }

         #-- looking for next item (0)
         else {
         
            #-> whitespace
            if (preg_match("/\s/", $c)) {
               // skip
            }

            #-> string begin
            elseif ($c == '"') {
               $state = '"';
            }

            #-> object
            elseif ($c == "{") {
               list($val, $n) = json_decode($json, $assoc, $limit-1, $n+1, '}', "}");
               
               if ($val && $n) {
                  $val = $assoc ? (array)$val : (object)$val;
               }
            }

            #-> array
            elseif ($c == "[") {
               list($val, $n) = json_decode($json, $assoc, $limit-1, $n+1, ']', "]");
            }

            #-> comment
            elseif (($c == "/") && ($json[$n+1]=="*")) {
               // just find end, skip over
               ($n = strpos($json, "*/", $n+1)) or ($n = strlen($json));
            }

            #-> numbers
            elseif (preg_match("#^(-?\d+(?:\.\d+)?)(?:[eE]([-+]?\d+))?#", substr($json, $n), $uu)) {
               $val = $uu[1];
               $n += strlen($uu[0]) - 1;
               if (strpos($val, ".")) {  // float
                  $val = (float)$val;
               }
               elseif ($val[0] == "0") {  // oct
                  $val = octdec($val);
               }
               else {
                  $val = (int)$val;
               }
               // exponent?
               if (isset($uu[2])) {
                  $val *= pow(10, (int)$uu[2]);
               }
            }

            #-> boolean or null
            elseif (preg_match("#^(true|false|null)\b#", substr($json, $n), $uu)) {
               $val = $lang_eq[$uu[1]];
               $n += strlen($uu[1]) - 1;
            }

            #-- parsing error
            else {
               // PHPs native json_decode() breaks here usually and QUIETLY
              trigger_error("json_decode: error parsing '$c' at position $n", E_USER_WARNING);
               return $waitfor ? array(NULL, 1<<30) : NULL;
            }

         }//state
         
         #-- next char
         if ($n === NULL) { return NULL; }
         $n++;
      }//for

      #-- final result
      return ($val);
   }
}

// php 5.2以下用

if ( !function_exists('sys_get_temp_dir')) { 
  function sys_get_temp_dir() { 
    if (!empty($_ENV['TMP'])) { return realpath($_ENV['TMP']); } 
    if (!empty($_ENV['TMPDIR'])) { return realpath( $_ENV['TMPDIR']); } 
    if (!empty($_ENV['TEMP'])) { return realpath( $_ENV['TEMP']); } 
    $tempfile=tempnam(__FILE__,''); 
    if (file_exists($tempfile)) { 
      unlink($tempfile); 
      return realpath(dirname($tempfile)); 
    } 
    return null; 
  } 
} 

if ( !function_exists('array_fill_keys')) { 
function array_fill_keys($target, $value = '') {
    if(is_array($target)) {
        foreach($target as $key => $val) {
            $filledArray[$val] = is_array($value) ? $value[$key] : $value;
        }
    }
    return $filledArray;
}
}
