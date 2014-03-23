<?php
$es_wikiquote = file_get_contents('http://es.wikiquote.org/wiki/Portada');
$pattern_quotation = 'Cita del día[\s\S]*<\/font\><\/strong\><\/div\>\n<\/td\>';
$pattern_quotation_for_pure = '<[a-zA-Z0-9áóñíéç\-\=\/\.\#\_\&\%\,\s\ \"\'\;\:\(\)\s\«\»\?]*\>[\n]*';
$pattern_quotation_for_pure_2 = 'Cita del día';
$pure_string = "";
	if (preg_match('/'. $pattern_quotation .'/', $es_wikiquote, $matches))
	{
		$quotation = print_r($matches[0], true);
		$quotation = preg_replace('/'. $pattern_quotation_for_pure .'/', $pure_string, $quotation);
		$quotation = preg_replace('/'. $pattern_quotation_for_pure_2 .'/', $pure_string, $quotation);
	}

$pattern_author = '<td colspan\=\"3\" height\=\"100\%\" bgcolor\=\"\#F4F4F5\"\>[\s\S]*<\/table\>\n<\/div\>\n<\/div\>';
$pattern_author_for_pure = '<td colspan\=\"3\" height\=\"100\%\" bgcolor\=\"\#F4F4F5\"\>[\n]*';
$pattern_author_for_pureX = '&amp;';
$pattern_author_for_pure2 = 'small.*small';
$pattern_author_for_pure3 = '<[a-zA-Z0-9áóñíé\-\=\/\.\#\_\&\%\,\s\ \"\'\;\:\(\)\s\«\»\?]*\>[\n]*';

	if (preg_match('/'. $pattern_author .'/', $es_wikiquote, $matches))
	{
		$author = print_r($matches[0], true);
		$author = preg_replace('/'. $pattern_author_for_pure .'/', $pure_string, $author);
		$author = preg_replace('/'. $pattern_author_for_pureX .'/', $pure_string, $author);
		$author = preg_replace('/'. $pattern_author_for_pure2 .'/', $pure_string, $author);
		$author = preg_replace('/'. $pattern_author_for_pure3 .'/', $pure_string, $author);
	};
?>