<?php


$root = '../../..';
require_once($root . '/config/config.php');
require_once($root . '/core/mysql.php');
require_once($root . '/core/models/maincomponentsModel.php');



$maincomponent = new Model_Maincomponents();


$db = getMysqlConnection();
$maincomponent = $maincomponent::getAllMaincomponents($db);



$view = array(
  'maincomponent' => $maincomponent
);


require_once($root . '/views/maincomponents/maincomponentsListView.php');
?>