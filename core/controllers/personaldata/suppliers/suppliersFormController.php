<?php

$root = '../../../..';
require_once($root . '/config/config.php');
require_once($root . '/core/mysql.php');
require_once($root . '/core/models/suppliersModel.php');



$db = getMysqlConnection();
$supplierdata = NULL;

if (!isset($_GET['Lieferant'])) {
	$form = array(
		'Name' => '',
		'Strasse' => '',
		'Hausnr' => '',
		'Ort' => '',
		'PLZ' => '',
		'Email' => '',
		'Telefon' => '',
		'Notiz' => ''
	);
}else{
	$supplierdata = Model_Suppliers::getSupplierByName($db, $_GET['Lieferant']);
	
$form = array(
		'Name' => $supplierdata['Name'],
		'Strasse' => $supplierdata['Strasse'],
		'Hausnr' => $supplierdata['Hausnr'],
		'Ort' => $supplierdata['Ort'],
		'PLZ' => $supplierdata['PLZ'],
		'Email' => $supplierdata['Email'],
		'Telefon' => $supplierdata['Telefon'],
		'Notiz' => $supplierdata['Notiz']
	);
}

if(isset($_POST['btnSave']))
{
		$form['Name'] = $_POST['lieferant'];
		$form['Strasse'] = $_POST['strasse'];
		$form['Hausnr'] = $_POST['hausnummer'];
		$form['Ort'] = $_POST['ort'];
		$form['PLZ'] = $_POST['plz'];
		$form['Email'] = $_POST['email'];
		$form['Telefon'] = $_POST['telefon'];
		$form['Notiz'] = $_POST['notiz'];
	

	if (!isset($_GET['Lieferant'])){
	Model_Suppliers::createNewSupplier($db, $form);
	} else{
		Model_Suppliers::updateSuppliers($db, $_GET['Lieferant'], $form);
	}
}

if (isset($_POST['delete']))
{
	$form['Name'] = $_POST['lieferant'];
	Model_Suppliers::disableSupplier($db, $form);
}
	
$view = array(
  'supplierdata' => $supplierdata,
  'rootPath' => $root,
  'form' => $form
  );



require_once($root . '/views/personaldata/suppliers/suppliersFormView.php');
?>
