<?php
$de_wikiquote = file_get_contents('http://ru.wikiquote.org/wiki/%D0%97%D0%B0%D0%B3%D0%BB%D0%B0%D0%B2%D0%BD%D0%B0%D1%8F_%D1%81%D1%82%D1%80%D0%B0%D0%BD%D0%B8%D1%86%D0%B0');
$pattern_quotation = '<span style\=\"font\-style\:italic\"\>.*';
$pattern_quotation_for_pure = '<[a-zA-Za-zA-Z0-9\-\=\/\.\#\_\&\%\,\s\ \"\'\;\:\(\)\«\»\?\„]*\>';
$pattern_quotation_for_pure_2 = '&#160;[\s]*';
// $pattern_quotation_for_pure_2 = 'Zitat der Woche[\s]*';
$pure_string = "";
	if (preg_match('/'. $pattern_quotation .'/', $de_wikiquote, $matches))
	{
		$quotation = print_r($matches[0], true);
		$quotation = preg_replace('/'. $pattern_quotation_for_pure .'/', $pure_string, $quotation);
		$quotation = preg_replace('/'. $pattern_quotation_for_pure_2 .'/', $pure_string, $quotation);
	}

$pattern_author = '<div style\=\"float\:right\"\>.*';
$pattern_author_for_pure = '<[a-zA-Za-zA-Z0-9\-\=\/\.\#\_\&\%\,\s\  \"\'\;\:\(\)\«\»\?\„]*\>';
$pattern_author_for_pure2 = '=".*"';

	if (preg_match('/'. $pattern_author .'/', $de_wikiquote, $matches))
	{
		$author = print_r($matches[0], true);
		$author = preg_replace('/'. $pattern_author_for_pure2 .'/', $pure_string, $author);
		$author = preg_replace('/'. $pattern_author_for_pure .'/', $pure_string, $author);
	};
?>