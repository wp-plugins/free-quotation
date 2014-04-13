<?php
$pl_wikiquote = file_get_contents('http://pl.wikiquote.org/wiki/Strona_g%C5%82%C3%B3wna');
$pattern_quotation = '<i><b>[\s\S]*';
$pattern_quotation_for_pure = '<\/b><\/i>[\s\S]*';
$pattern_quotation_for_pure_2 = '<i><b>';
$pattern_quotation_for_pure_3 = '&#160;[\s\n]*';
$pure_string = "";
	if (preg_match('/'. $pattern_quotation .'/', $pl_wikiquote, $matches))
	{
		$quotation = print_r($matches[0], true);
		$quotation = preg_replace('/'. $pattern_quotation_for_pure .'/', $pure_string, $quotation);
		$quotation = preg_replace('/'. $pattern_quotation_for_pure_2 .'/', $pure_string, $quotation);
		$quotation = preg_replace('/'. $pattern_quotation_for_pure_3 .'/', $pure_string, $quotation);
	}
$pattern_author = '<td align="right"><a href="\/wiki\/[a-zA-Z\ ęóąśłżźćńĘÓĄŚŁŻŹĆŃ\,\.\_]*" title="[a-zA-Z\ ęóąśłżźćńĘÓĄŚŁŻŹĆŃ\,\.\ ]*">[a-zA-Z\ ęóąśłżźćńĘÓĄŚŁŻŹĆŃ\,\.\ ]*<\/a><\/td>';
$pattern_author_for_pure = '<td align="right"><a href="\/wiki\/[a-zA-Z\ ęóąśłżźćńĘÓĄŚŁŻŹĆŃ\,\.\_]*" title="[a-zA-Z\ ęóąśłżźćńĘÓĄŚŁŻŹĆŃ\,\.\ ]*">';
$pattern_author_for_pure2 = '<\/a><\/td>';
	if (preg_match('/'. $pattern_author .'/', $pl_wikiquote, $matches))
	{
		$author = print_r($matches[0], true);
		$author = preg_replace('/'. $pattern_author_for_pure .'/', $pure_string, $author);
		$author = preg_replace('/'. $pattern_author_for_pure2 .'/', $pure_string, $author);
	};
?>