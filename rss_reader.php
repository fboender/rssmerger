<?
/*
	rss_reader.php

	Example RSS reader which has been especially written to take advantage of
	the extra features offered by rssmerger.py

*/
?>
<html>
	<head>
		<title>RSS Merged Feed Reader</title>
		<style>
			body { font-family: verdana, arial, helvetica, sans-serif; font-size: small; }
			td { font-family: verdana, arial, helvetica, sans-serif; font-size: small; }
			a { text-decoration: none; }
		</style>
	</head>
	<body>
		<?
		$data = implode("", file("merged.rss"));
		
		$parser = xml_parser_create();
		
		xml_parser_set_option($parser,XML_OPTION_CASE_FOLDING,0);
		xml_parser_set_option($parser,XML_OPTION_SKIP_WHITE,1);

		/* Read XML tree into PHP array's */
		xml_parse_into_struct($parser,$data,$values,$tags);
		xml_parser_free($parser);

		$current_item = 0;

		/* Walk through XML tree and find any <item> tags */
		for ($i=0; $i < count($values); $i++) {
			if ($values[$i]["tag"] == "item" && $values[$i]["type"] == "open") {
				$current_item++;
			}
			
			switch ($values[$i]["tag"]) {
				case "rm:publisher" : $items[$current_item]["publisher"]   = $values[$i]["value"]; break;
				case "title"        : $items[$current_item]["title"]       = $values[$i]["value"]; break;
				case "link"         : $items[$current_item]["link"]        = $values[$i]["value"]; break;
				case "description"  : $items[$current_item]["description"] = $values[$i]["value"]; break;
				case "date"         : $items[$current_item]["date"]        = strtotime($values[$i]["value"]); break;
				default: break;
			}
		}
		?>
		<table>
			<?
				for ($i = 1; $i < count($items); $i++) {
					$item = $items[$i];
					
					/* If item has a description, show it as [?] text */
					if ($item["description"] != "") {
						$desc_avail = "[?]";
					} else {
						$desc_avail = "";
					}
					/* If items span multiple days, show date above items */
					if (date ("dMY", $item["date"]) != $prev_date) {
						?><tr><td colspan="4"><b><?=date("d M Y", $item["date"])?></b></td></tr><?
						$prev_date = date("dMY", $item["date"]);
					}
					
					/* Show item */
					?>
					<tr valign="top">
						<td><b><?=$item["publisher"]?></b></td>
						<td><?=date("H:i",$item["date"])?></td>
						<td><?=$item["category"]?></td>
						<td><?=$desc_avail?>&nbsp;</td>
						<td><a href="<?=$item["link"]?>" title="<?=htmlspecialchars($item["description"])?>"><?=$item["title"]?></a></td>
					</tr>
					<?
				}
			?>
		</table>
	</body>
</html>
