<?php
$en_wikiquote = file_get_contents('http://en.wikiquote.org/wiki/Main_Page');
$pattern_quotation = 'Quote of the day[\s\S]*<\/p\>\n<\/td\>\n<\/tr\>';
$pattern_quotation_for_pure = '<[a-zA-Z0-9\-\=\/\.\#\_\&\%\,\s\ \"\'\;\:\(\)\«\»\?]*\>';
$pattern_quotation_for_pure_2 = '&#160;[\s\n]*';
$pattern_quotation_for_pure_3 = 'Quote of the day[\s]*';
$pure_string = "";
	if (preg_match('/'. $pattern_quotation .'/', $en_wikiquote, $matches))
	{
		$quotation = print_r($matches[0], true);
		$quotation = preg_replace('/'. $pattern_quotation_for_pure .'/', $pure_string, $quotation);
		$quotation = preg_replace('/'. $pattern_quotation_for_pure_2 .'/', $pure_string, $quotation);
		$quotation = preg_replace('/'. $pattern_quotation_for_pure_3 .'/', $pure_string, $quotation);
		$quotation = substr($quotation, 0, -2);
	}

$pattern_author = '<\/p\>\n<\/td\>\n<\/tr\>\n<tr\>[\s\S\d\D]*\~<\/td\>\n<\/tr\>\n<\/table\>\n<br \/\>';
$pattern_author_for_pure = '<\/p\>\n<\/td\>\n<\/tr\>\n<tr\>[\s]*';
$pattern_author_for_pure2 = '~<\/td\>\n<\/tr\>\n<\/table\>\n<br \/\>[\s]*';
$pattern_author_for_pure3 = '~';
$pattern_author_for_pure4 = '<[a-zA-Z0-9\-\=\/\.\#\_\&\%\,\s\ \"\'\;\:\(\)\s]*\>[\s]*';

	if (preg_match('/'. $pattern_author .'/', $en_wikiquote, $matches))
	{
		$author = print_r($matches[0], true);
		$author = preg_replace('/'. $pattern_author_for_pure .'/', $pure_string, $author);
		$author = preg_replace('/'. $pattern_author_for_pure2 .'/', $pure_string, $author);
		$author = preg_replace('/'. $pattern_author_for_pure3 .'/', $pure_string, $author);
		$author = preg_replace('/'. $pattern_author_for_pure4 .'/', $pure_string, $author);
	};
?>