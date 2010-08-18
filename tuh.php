<?php
/**
 * A Tiny, UTF-8 valid HTML Parser in PHP
 *
 * Copyright 2010 David Pennington http://xeoncross.com
 */
class tuh 
{
	public static function parse($t, $d = TRUE)
	{
		$t=preg_split('/<code>(.+?)<\/code>/is',$t,-1,2);$c=$s='';foreach($t as$p)if($c=1-$c){if($p=trim($p)){$p=preg_replace(array("/\r/","/\n\n+/"),array('',"\n\n"),$p);$s.=self::text($p,$d);}}else$s.=self::code($p)."\n\n";return$s;
	}
	
	public static function code($t)
	{
		$s=$e=0;if(strpos($t,'<?php')===FALSE){$s=1;$t='<?php'.$t;}if(strpos($t,'?>')===FALSE){$e=1;$t.='?>';}$t=highlight_string(trim($t),TRUE);if($s)$t=str_replace('&lt;?php','',$t);if($e)$t=str_replace('?&gt;','',$t);return$t;
	}
	
	public static function text($t, $d = TRUE)
	{
		$s='';foreach(explode("\n\n",$t)as$l){$l=self::quote($l);if($d)$l=self::link(self::decode(self::decode(self::h($l))));$s.=(preg_match('/^<([a-z][a-z0-9]+)\b[^>]*>.*?<\/\1>$/is',$l)?$l:nl2br("<p>$l</p>"))."\n\n";}return$s;
	}
	
	public static function decode($t)
	{
		return preg_replace('/(&lt;(b|i|em|ul|li|ol|pre|blockquote)&gt;)(.{1,5000}?)(&lt;\/\2&gt;)/is','<\2>\3</\2>',$t);
	}
	
	public static function unparse($t, $d = TRUE)
	{
		$t=preg_split('/<code>(.+?)<\/code>/is',$t,-1,2);$c=$s='';foreach($t as$p)if($c=1-$c)$s.=str_replace(array('<p>','</p>','<br />'),array('','',"\n"),($d?self::unh($p):$p));else$s.=self::uncode($p);return$s;
	}
	
	public static function uncode($t)
	{
		return "<code>\n".self::unh(trim(str_replace('&nbsp;',' ',str_ireplace('<br />', "\n",strip_tags($t)))))."\n</code>";
	}
	
	public static function h($t)
	{
		return htmlspecialchars($t,ENT_QUOTES,'UTF-8');
	}
	
	public static function unh($t)
	{
		return htmlspecialchars_decode($t,ENT_QUOTES);
	}
	
	public static function to_utf8($t)
	{
		if(!preg_match('/[^\x00-\x7F]/S',$t)){$e=error_reporting(~E_NOTICE);$t=iconv('UTF-8','UTF-8//IGNORE',$t);error_reporting($e);}return$t;
	}
	
	public static function link($t, $d = TRUE)
	{
		return preg_replace('/[a-z]+:\/\/(([a-z0-9-]{1,70}\.){1,4}([a-z]{2,4})(:\d{2,4})?(\/[\w\/.\-?=&;%]{1,200})?)/i', '<a href="$0" '.($d?' rel="nofollow"':'').'>$0</a>',$t);
	}
	
	public static function quote($t)
	{
		return preg_replace('/^"([^"]{20,1000})"( +- +[a-z0-9 ]+)?$/i','<blockquote>$1$2</blockquote>',$t);
	}
}