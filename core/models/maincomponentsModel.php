<?php

class Model_Maincomponents {

	static function createNewMaincomponent($db, $maincomponentdata){
		$mysqlResult = null;

		$sql = "
			INSERT INTO komponente (Beschreibung, Hersteller, Notiz, Einkaufsdatum, Gewaehrleistungsdauer, FK_Lieferant, FK_Komponentenart, FK_Raum, Seriennummer)
			VALUES (
				'" . $maincomponentdata['txtDescription'] . "',
				'" . $maincomponentdata['txtManufacturer'] . "',
				'" . $maincomponentdata['txtNote'] . "',
				'" . $maincomponentdata['txtBuyDate'] . "',
				" . $maincomponentdata['txtWarrantyYears'] . ",
				'" . $maincomponentdata['cmbSupplierID'] . "',
				'" . $maincomponentdata['cmbComponentType'] . "',
				'" . $maincomponentdata['cmbRoomNumber'] . "',
				'" . $maincomponentdata['txtSerialNumber'] . "'
			)
			;
		";

		$mysqlResult = $db->query($sql);

		if ($mysqlResult === false) {
			die("sql query failed: (" . $db->errno . ") " . $db->error);
		}

		return true;
	}

	static function getAllMaincomponents($db, $orderBy = 'k.PK_ID') {
		$mysqlResult = null;
		$maincomponents = array();
		$sql = '
			SELECT kart.Bezeichnung as Komponentenart, k.Seriennummer, k.Beschreibung, k.Hersteller, k.Einkaufsdatum, k.Gewaehrleistungsdauer, k.Einkaufsdatum + INTERVAL k.Gewaehrleistungsdauer YEAR as Ablaufdatum, k.Notiz, k.FK_Lieferant, k.FK_Raum, l.Name
			FROM komponente as k, komponentenart as kart, lieferant as l
			WHERE k.FK_Lieferant = l.PK_ID
			AND k.FK_Komponentenart = kart.PK_ID
			AND (k.FK_Komponentenart = 1
			OR k.FK_Komponentenart = 14
			OR k.FK_Komponentenart = 16
			OR k.FK_Komponentenart = 17
			OR k.FK_Komponentenart = 18
			OR k.FK_Komponentenart = 19)
			ORDER BY ' . $orderBy . '
		';

		$mysqlResult = $db->query($sql);

		if ($mysqlResult === false) {
			die("sql query failed: (" . $db->errno . ") " . $db->error);
		}

		$mysqlResult->data_seek(0);
		while ($row = $mysqlResult->fetch_assoc()) {
			array_push($maincomponents, $row);
		}

		return $maincomponents;
	}

	static function getMaincomponentsByRoomNumber($db, $roomNumber, $orderBy = 'k.PK_ID') {
		$mysqlResult = null;
		$maincomponents = array();
		$sql = '
			SELECT kart.Bezeichnung as Komponentenart, k.Seriennummer, k.Beschreibung, k.Hersteller, k.Einkaufsdatum, k.Gewaehrleistungsdauer, k.Einkaufsdatum + INTERVAL k.Gewaehrleistungsdauer YEAR as Ablaufdatum, k.Notiz, k.FK_Lieferant, k.FK_Raum, l.Name
			FROM komponente as k, komponentenart as kart, lieferant as l
			WHERE k.FK_Lieferant = l.PK_ID
			AND k.FK_Komponentenart = kart.PK_ID
			AND (k.FK_Komponentenart = 1
			OR k.FK_Komponentenart = 14
			OR k.FK_Komponentenart = 16
			OR k.FK_Komponentenart = 17
			OR k.FK_Komponentenart = 18
			OR k.FK_Komponentenart = 19)
			AND k.FK_Raum = ' . $roomNumber . '
			ORDER BY ' . $orderBy . '
		';

		$mysqlResult = $db->query($sql);

		if ($mysqlResult === false) {
			die("sql query failed: (" . $db->errno . ") " . $db->error);
		}

		$mysqlResult->data_seek(0);
		while ($row = $mysqlResult->fetch_assoc()) {
			array_push($maincomponents, $row);
		}

		return $maincomponents;
	}

	static function getMaincomponentBySerialNumber($db, $serialNumber) {
		$mysqlResult = null;
		$maincomponent = null;
		$sql = "
			SELECT k.FK_Komponentenart, kart.Bezeichnung as Komponentenart, k.Seriennummer, k.Beschreibung, k.Hersteller, k.Einkaufsdatum, k.Gewaehrleistungsdauer, k.Einkaufsdatum + INTERVAL k.Gewaehrleistungsdauer YEAR as Ablaufdatum, k.Notiz, k.FK_Lieferant, k.FK_Raum, l.Name
			FROM komponente as k, komponentenart as kart, lieferant as l
			WHERE k.FK_Lieferant = l.PK_ID
			AND k.FK_Komponentenart = kart.PK_ID
			AND (k.FK_Komponentenart = 1
			OR k.FK_Komponentenart = 19)
			AND k.Seriennummer = '" . $serialNumber . "'
		";

		$mysqlResult = $db->query($sql);
		if ($mysqlResult === false) {
			die("sql query failed: (" . $db->errno . ") " . $db->error);
		}

		$mysqlResult->data_seek(0);
		$maincomponent = $mysqlResult->fetch_assoc();

		return $maincomponent;
	}

	static function getMaincomponentTypes($db, $orderBy = 'PK_ID') {
		$mysqlResult = null;
		$maincomponentTypes = array();

		$sql = "
			SELECT *
			FROM komponentenart
			WHERE Bezeichnung IN ('PC', 'Switch', 'Router', 'Hub', 'Accesspoint', 'Drucker')
			ORDER BY ' . $orderBy . '
		";
		$mysqlResult = $db->query($sql);
		if ($mysqlResult === false) {
			die("sql query failed: (" . $db->errno . ") " . $db->error);
		}

		$mysqlResult->data_seek(0);
		while ($row = $mysqlResult->fetch_assoc()) {
			array_push($maincomponentTypes, $row);
		}

		return $maincomponentTypes;
	}

	static function GetSearchMaincomponents($db, $searchdata, $orderBy = 'k.PK_ID') {
		$mysqlResult = null;
		$maincomponents = array();
		$sql = "
			SELECT kart.Bezeichnung as Komponentenart, k.Seriennummer, k.Beschreibung, k.Hersteller, k.Einkaufsdatum, k.Gewaehrleistungsdauer, k.Einkaufsdatum + INTERVAL k.Gewaehrleistungsdauer YEAR as Ablaufdatum, k.Notiz, k.FK_Lieferant, k.FK_Raum, l.Name
			FROM komponente as k, komponentenart as kart, lieferant as l
			WHERE k.FK_Lieferant = l.PK_ID
			AND k.FK_Komponentenart = kart.PK_ID
			AND (k.FK_Komponentenart = 1
			OR k.FK_Komponentenart = 14
			OR k.FK_Komponentenart = 16
			OR k.FK_Komponentenart = 17
			OR k.FK_Komponentenart = 18
			OR k.FK_Komponentenart = 19)
		";
		if(isset($searchdata['txtDescription']))
		$sql .= "AND k.Beschreibung LIKE '%".$searchdata['txtDescription']."%'";
	
		if(isset($searchdata['seriennummer']))
		$sql .= "AND k.Seriennummer LIKE '%".$searchdata['seriennummer']."%'";

			if(isset($searchdata['komponentenart']))
		$sql .= "AND kart.Bezeichnung  LIKE '%".$searchdata['komponentenart']."%'";
	
			if(isset($searchdata['raum']))
		$sql .= "AND k.FK_Raum LIKE '%".$searchdata['raum']."'";
	
			if(isset($searchdata['einkaufdatum']))
		$sql .= "AND k.Einkaufsdatum LIKE '%".$searchdata['einkaufdatum']."%'";
	
			if(isset($searchdata['hersteller']))
		$sql .= "AND k.Hersteller LIKE '%".$searchdata['hersteller']."%'";
	
			if(isset($searchdata['lieferant']))
		$sql .= "AND l.Name LIKE '%".$searchdata['lieferant']."%'";

				if(isset($searchdata['notiz']))
		$sql .= "AND k.Notiz LIKE '%".$searchdata['notiz']."%'";

		$sql .= "ORDER BY '" . $orderBy . "'";
		
		$mysqlResult = $db->query($sql);

		if ($mysqlResult === false) {
			die("sql query failed: (" . $db->errno . ") " . $db->error);
		}

		$mysqlResult->data_seek(0);
		while ($row = $mysqlResult->fetch_assoc()) {
			array_push($maincomponents, $row);
		}

		return $maincomponents;
	}

	static function updateMaincomponent($db, $serialNumber, $maincomponentdata){
		$mysqlResult = null;

		$sql = "
			UPDATE komponente
			SET
				Beschreibung = '" . $maincomponentdata['txtDescription'] . "',
				Hersteller = '" . $maincomponentdata['txtManufacturer'] . "',
				Notiz = '" . $maincomponentdata['txtNote'] . "',
				Einkaufsdatum = '" . $maincomponentdata['txtBuyDate'] . "',
				Gewaehrleistungsdauer = ".$maincomponentdata['txtWarrantyYears'].",
				FK_Lieferant = '" . $maincomponentdata['cmbSupplierID'] . "',
				FK_Komponentenart = '" . $maincomponentdata['cmbComponentType'] . "',
				FK_Raum = " . $maincomponentdata['cmbRoomNumber'] . "
			WHERE
				Seriennummer = '" . $maincomponentdata['txtSerialNumber'] . "'
			;
		";

		$mysqlResult = $db->query($sql);

		if ($mysqlResult === false) {
			die("sql query failed: (" . $db->errno . ") " . $db->error);
		}

		return true;
	}
}
