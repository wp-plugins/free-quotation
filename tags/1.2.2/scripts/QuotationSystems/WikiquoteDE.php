<?php
$de_wikiquote = file_get_contents('http://de.wikiquote.org/wiki/Hauptseite');
$pattern_quotation = 'Zitat der Woche[\s\S]*<\/td\>\n<td style\=\"vertical\-align\: top\;\"\>';
$pattern_quotation_for_pure = '<[a-zA-Z0-9ÖöẞÜüÄä\-\=\/\.\#\_\&\%\,\s\ \"\'\;\:\(\)\«\»\?\„]*\>';
$pattern_quotation_for_pure_2 = 'Zitat der Woche[\s]*';
$pure_string = "";
	if (preg_match('/'. $pattern_quotation .'/', $de_wikiquote, $matches))
	{
		$quotation = print_r($matches[0], true);
		$quotation = preg_replace('/'. $pattern_quotation_for_pure .'/', $pure_string, $quotation);
		$quotation = preg_replace('/'. $pattern_quotation_for_pure_2 .'/', $pure_string, $quotation);
		
		$quotation = substr($quotation, 0, -1);
	}

$pattern_author = '<td colspan\=\"3\" style\=\"margin-top\: \.5em\; text\-align\: right\;\"\>[a-zA-Z0-9ÖöẞÜüÄä\-\=\/\.\#\_\&\%\,\s\ \"\'\;\:\(\)\«\»\?\„\<\>]*';
$pattern_author_for_pure = '<.*>[\s]*';

	if (preg_match('/'. $pattern_author .'/', $de_wikiquote, $matches))
	{
		$author = print_r($matches[0], true);
		$author = preg_replace('/'. $pattern_author_for_pure .'/', $pure_string, $author);
	};
?>