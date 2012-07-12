<?php
$link = mysql_connect('localhost', 'username', 'password');
if (!$link) {
	die('Not connected : ' . mysql_error());
}
mysql_select_db('database');

$aProduct[] = array('OXID', 'OXSHOPID', 'OXPARENTID', 'OXACTIVE', 'OXACTIVEFROM', 'OXACTIVETO', 'OXARTNUM', 'OXMPN', 'OXTITLE', 'OXSHORTDESC', 'OXPRICE', 'OXUNITQUANTITY', 'OXPICSGENERATED', 'OXPIC1', 'OXPIC2', 'OXPIC3', 'OXPIC4', 'OXPIC5', 'OXPIC6', 'OXPIC7', 'OXPIC8', 'OXPIC9', 'OXPIC10', 'OXPIC11', 'OXPIC12', 'OXWEIGHT', 'OXSTOCK', 'OXSEARCHKEYS', 'OXISSEARCH', 'OXISCONFIGURABLE', 'OXVARNAME', 'OXVARSELECT', 'OXVARSTOCK', 'OXVARCOUNT', 'OXVARNAME_1', 'OXVARSELECT_1', 'OXTITLE_1', 'OXSHORTDESC_1', 'OXSEARCHKEYS_1', 'OXMANUFACTURERID', 'OXSORT');
$sql = sprintf("select cpe.entity_id, cpe.sku from catalog_category_product ccp, catalog_product_entity cpe where ccp.category_id=53 && ccp.product_id = cpe.entity_id && cpe.type_id = 'configurable'");
$res = mysql_query($sql);
/* Replace all IDs with the matching values from your installation! */
while($f = mysql_fetch_assoc($res)) {
	$aData = array();
	$productid = md5("oxarticles"+$f['entity_id']);
	/* Price */
	$sql = sprintf("select value from catalog_product_entity_decimal where entity_id = %d && attribute_id = 67 && store_id=0", $f['entity_id']);
	$r = mysql_query($sql);
	$row = mysql_fetch_row($r);
	$fPrice = $row[0];
	/* Manufacturer */
	$sql = sprintf("select eaov.value from catalog_product_entity_int cpei, eav_attribute_option eao, eav_attribute_option_value eaov where cpei.entity_id = %d && cpei.attribute_id = 73 && cpei.store_id=0 && cpei.value = eao.option_id && eao.option_id = eaov.option_id && eaov.store_id = 0", $f['entity_id']);
	$r = mysql_query($sql);
	$row = mysql_fetch_row($r);
	$sManu = $row[0];
	/* Name DE */
	$sql = sprintf("select value from catalog_product_entity_varchar where entity_id = %d && attribute_id = 63 && store_id=0", $f['entity_id']);
	$r = mysql_query($sql);
	$row = mysql_fetch_row($r);
	$aName['de'] = $row[0];
	/* Name EN */
	$sql = sprintf("select value from catalog_product_entity_varchar where entity_id = %d && attribute_id = 63 && store_id=3", $f['entity_id']);
	$r = mysql_query($sql);
	$row = mysql_fetch_row($r);
	$aName['en'] = $row[0];
	/* Description DE */
	$sql = sprintf("select value from catalog_product_entity_text where entity_id = %d && attribute_id = 64 && store_id=0", $f['entity_id']);
	$r = mysql_query($sql);
	$row = mysql_fetch_row($r);
	$aText['de'] = $row[0];
	/* Description EN */
	$sql = sprintf("select value from catalog_product_entity_text where entity_id = %d && attribute_id = 64 && store_id=3", $f['entity_id']);
	$r = mysql_query($sql);
	$row = mysql_fetch_row($r);
	$aText['en'] = $row[0];
	/* Keywords DE */
	$sql = sprintf("select value from catalog_product_entity_text where entity_id = %d && attribute_id = 75 && store_id=0", $f['entity_id']);
	$r = mysql_query($sql);
	$row = mysql_fetch_row($r);
	$aKey['de'] = $row[0];
	/* Keywords EN */
	$sql = sprintf("select value from catalog_product_entity_text where entity_id = %d && attribute_id = 75 && store_id=3", $f['entity_id']);
	$r = mysql_query($sql);
	$row = mysql_fetch_row($r);
	$aKey['en'] = $row[0];
	$sql = sprintf("select distinct value from catalog_product_entity_media_gallery where entity_id = %d", $f['entity_id']);
	$r = mysql_query($sql);
	$aImage = array();
	while($row = mysql_fetch_row($r)) {
		$aImage[] = preg_replace("=^/././=", "", $row[0]);
	}

	$aData[] = $productid; // OXID
	$aData[] = 'oxbaseshop'; // OXSHOPID
	$aData[] = ''; // PARENTID
	$aData[] = '1'; // OXACTIVE
	$aData[] = "0000-00-00 00:00:00"; // OXACTIVEFROM
	$aData[] = "0000-00-00 00:00:00"; // OXACTIVETO
	$aData[] = $f['sku']; // OXARTNUM
	$aData[] = str_replace("-", "", substr($f['sku'], 3, strlen($f['sku']))); // OXMPN
	$aData[] = str_replace('"', '""', $aName['de']); // OXTITLE
	$aData[] = $aText['de']; // OXSHORTDESC
	$aData[] = str_replace(".", ",", $fPrice); // OXPRICE
	$aData[] = '1000'; // OXUNITQUANTITY
	$aData[] = '0'; // OXPICSGENERATED
	$aData[] = isset($aImage[0]) ? $aImage[0] : ''; // OXPIC1
	$aData[] = isset($aImage[1]) ? $aImage[1] : ''; // OXPIC2
	$aData[] = isset($aImage[2]) ? $aImage[2] : ''; // OXPIC3
	$aData[] = isset($aImage[3]) ? $aImage[3] : ''; // OXPIC4
	$aData[] = isset($aImage[4]) ? $aImage[4] : ''; // OXPIC5
	$aData[] = isset($aImage[5]) ? $aImage[5] : ''; // OXPIC6
	$aData[] = isset($aImage[6]) ? $aImage[6] : ''; // OXPIC7
	$aData[] = isset($aImage[7]) ? $aImage[7] : ''; // OXPIC8
	$aData[] = isset($aImage[8]) ? $aImage[8] : ''; // OXPIC9
	$aData[] = isset($aImage[9]) ? $aImage[9] : ''; // OXPIC10
	$aData[] = isset($aImage[10]) ? $aImage[10] : ''; // OXPIC11
	$aData[] = isset($aImage[11]) ? $aImage[11] : ''; // OXPIC12
	$aData[] = '0'; // OXWEIGHT
	$aData[] = '1000'; // OXSTOCK
	$aData[] = $aKey['de']; // OXSEARCHKEYS
	$aData[] = '1'; // OXISSEARCH
	$aData[] = '0'; // OXISCONFIGURABLE
	$aData[] = 'Ausführung | Größe'; // OXVARNAME
	$aData[] = ''; // OXVARSELECT
	$aData[] = '1000'; // OXVARSTOCK
	$aData[] = '2'; // OXVARCOUNT
	$aData[] = 'Finish | Size'; // OXVARNAME_1
	$aData[] = ''; // OXVARSELECT_1
	$aData[] = $aName['en']; // OXTITLE_1
	$aData[] = $aText['en']; // OXSHORTDESC_1
	$aData[] = $aKey['en']; // OXSEARCHKEYS_1
	/* Create Manufacturer in your OXID installation and paste the ID here */
	$aData[] = ''; // OXMANUFACTURERID
	$aData[] = ''; // OXSORT
	$aProduct[] = $aData;

	$sql = sprintf("select cpe.entity_id, cpe.sku from catalog_category_product ccp, catalog_product_entity cpe, catalog_product_relation cpr where cpr.parent_id = %s && cpr.child_id = ccp.product_id && ccp.product_id = cpe.entity_id && cpe.type_id = 'simple'", $f['entity_id']);
	$childs = mysql_query($sql);
	while($c = mysql_fetch_assoc($childs)) {
		$aData = array();
		$cproductid = md5("oxarticles"+$c['entity_id']);
		/* Price */
		$sql = sprintf("select value from catalog_product_entity_decimal where entity_id = %d && attribute_id = 67 && store_id=0", $c['entity_id']);
		$r = mysql_query($sql);
		$row = mysql_fetch_row($r);
		$fPrice = $row[0];
		/* Manufacturer */
		$sql = sprintf("select eaov.value from catalog_product_entity_int cpei, eav_attribute_option eao, eav_attribute_option_value eaov where cpei.entity_id = %d && cpei.attribute_id = 73 && cpei.store_id=0 && cpei.value = eao.option_id && eao.option_id = eaov.option_id && eaov.store_id = 0", $c['entity_id']);
		$r = mysql_query($sql);
		$row = mysql_fetch_row($r);
		$sManu = $row[0];
		/* Name DE */
		$sql = sprintf("select value from catalog_product_entity_varchar where entity_id = %d && attribute_id = 63 && store_id=0", $c['entity_id']);
		$r = mysql_query($sql);
		$row = mysql_fetch_row($r);
		$aName['de'] = $row[0];
		/* Name EN */
		$sql = sprintf("select value from catalog_product_entity_varchar where entity_id = %d && attribute_id = 63 && store_id=3", $c['entity_id']);
		$r = mysql_query($sql);
		$row = mysql_fetch_row($r);
		$aName['en'] = $row[0];
		/* Description DE */
		$sql = sprintf("select value from catalog_product_entity_text where entity_id = %d && attribute_id = 64 && store_id=0", $c['entity_id']);
		$r = mysql_query($sql);
		$row = mysql_fetch_row($r);
		$aText['de'] = $row[0];
		/* Description EN */
		$sql = sprintf("select value from catalog_product_entity_text where entity_id = %d && attribute_id = 64 && store_id=3", $c['entity_id']);
		$r = mysql_query($sql);
		$row = mysql_fetch_row($r);
		$aText['en'] = str_replace("theTyrolese", "the Tyrolese", $row[0]);
		/* Keywords DE */
		$sql = sprintf("select value from catalog_product_entity_text where entity_id = %d && attribute_id = 75 && store_id=0", $c['entity_id']);
		$r = mysql_query($sql);
		$row = mysql_fetch_row($r);
		$aKey['de'] = $row[0];
		/* Keywords EN */
		$sql = sprintf("select value from catalog_product_entity_text where entity_id = %d && attribute_id = 75 && store_id=3", $c['entity_id']);
		$r = mysql_query($sql);
		$row = mysql_fetch_row($r);
		$aKey['en'] = $row[0];
		$sql = sprintf("select distinct value from catalog_product_entity_media_gallery where entity_id = %d", $c['entity_id']);
		$r = mysql_query($sql);
		$aImage = array();
		while($row = mysql_fetch_row($r)) {
			$aImage[] = preg_replace("=^/././=", "", $row[0]);
		}
		/* Attribute Ausführung */
		$sql = sprintf("select eaov.value from catalog_product_entity_int cpei, eav_attribute_option_value eaov where cpei.entity_id = %s && cpei.attribute_id = 132 && cpei.value = eaov.option_id && eaov.store_id=2", $c['entity_id']);
		$r = mysql_query($sql);
		$row = mysql_fetch_row($r);
		$aAttr[0]['de'] = $row[0];
		$sql = sprintf("select eaov.value from catalog_product_entity_int cpei, eav_attribute_option_value eaov where cpei.entity_id = %s && cpei.attribute_id = 132 && cpei.value = eaov.option_id && eaov.store_id=3", $c['entity_id']);
		$r = mysql_query($sql);
		$row = mysql_fetch_row($r);
		$aAttr[0]['en'] = $row[0];

		/* Attribute Ausführung */
		$sql = sprintf("select eaov.value from catalog_product_entity_int cpei, eav_attribute_option_value eaov where cpei.entity_id = %s && cpei.attribute_id = 134 && cpei.value = eaov.option_id && eaov.store_id=2", $c['entity_id']);
		$r = mysql_query($sql);
		$row = mysql_fetch_row($r);
		$aAttr[1]['de'] = $row[0];
		$sql = sprintf("select eaov.value from catalog_product_entity_int cpei, eav_attribute_option_value eaov where cpei.entity_id = %s && cpei.attribute_id = 134 && cpei.value = eaov.option_id && eaov.store_id=3", $c['entity_id']);
		$r = mysql_query($sql);
		$row = mysql_fetch_row($r);
		$aAttr[1]['en'] = $row[0];

		$aData[] = $cproductid; // OXID
		$aData[] = 'oxbaseshop'; // OXSHOPID
		$aData[] = $productid; // PARENTID
		$aData[] = '1'; // OXACTIVE
		$aData[] = "0000-00-00 00:00:00"; // OXACTIVEFROM
		$aData[] = "0000-00-00 00:00:00"; // OXACTIVETO
		$aData[] = $c['sku']; // OXARTNUM
		$aData[] = str_replace("-", "", substr($c['sku'], 3, strlen($c['sku']))); // OXMPN
		$aData[] = str_replace('"', '""', $aName['de']); // OXTITLE
		$aData[] = $aText['de']; // OXSHORTDESC
		$aData[] = str_replace(".", ",", $fPrice); // OXPRICE
		$aData[] = '1000'; // OXUNITQUANTITY
		$aData[] = '0'; // OXPICSGENERATED
		$aData[] = '';
		$aData[] = '';
		$aData[] = '';
		$aData[] = '';
		$aData[] = '';
		$aData[] = '';
		$aData[] = '';
		$aData[] = '';
		$aData[] = '';
		$aData[] = '';
		$aData[] = '';
		$aData[] = '';
		$aData[] = '0'; // OXWEIGHT
		$aData[] = '1000'; // OXSTOCK
		$aData[] = $aKey['de']; // OXSEARCHKEYS
		$aData[] = '1'; // OXISSEARCH
		$aData[] = '0'; // OXISCONFIGURABLE
		$aData[] = ''; // OXVARNAME
		$aData[] = sprintf('%s | %s', $aAttr[0]['de'], $aAttr[1]['de']); // OXVARSELECT
		$aData[] = '1000'; // OXVARSTOCK
		$aData[] = '2'; // OXVARCOUNT
		$aData[] = ''; // OXVARNAME_1
		$aData[] = sprintf('%s | %s', $aAttr[0]['en'], $aAttr[1]['en']); // OXVARSELECT_1
		$aData[] = $aName['en']; // OXTITLE_1
		$aData[] = $aText['en']; // OXSHORTDESC_1
		$aData[] = $aKey['en']; // OXSEARCHKEYS_1
		$aData[] = 'otc58f21cf7a46b53f98bf0c13b58041'; // OXMANUFACTURERID
		$aSort = array("lasiert" => 100, "natur" => 200, "gebeizt" => 300, "mehrfach gebeizt" => 400, "gold" => 500, "Naturholz gewachst mit Goldrand" => 600, "farbig" => 700);
		$aData[] = $aSort[$aAttr[0]['de']].str_replace(array(" cm", "-"), array("", ""), $aAttr[1]['de']); // OXSORT
		$aProduct[] = $aData;
	}

}

$sData = generateCsv($aProduct, ";");
header("Content-Type: application/octet-stream");
header("Content-Disposition: attachment; filename=\"export.csv\"");
echo $sData;

function generateCsv($aData, $sDelimiter = ',', $sEnclosure = '"') {
	$hHandle = fopen('php://temp', 'r+');
	foreach($aData as $aLine) {
		fputcsv($hHandle, $aLine, $sDelimiter, $sEnclosure);
	}
	rewind($hHandle);


	$sContents = '';
	while(!feof($hHandle)) {
		$sContents .= fread($hHandle, 8192);
	}
	fclose($hHandle);
	return $sContents;
}