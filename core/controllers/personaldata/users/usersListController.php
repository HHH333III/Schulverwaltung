<?php

$root = '../../../..';
$user=array(
	array(
		'Name' => 'Klaus',
		'Gruppe' => 'Mitarbeiter'),
	array(
		'Name' => 'Hans',
		'Gruppe' => 'Mitarbeiter'),


	);

$view = array(
  'user' => $user
);


require_once($root . '/views/personaldata/users/usersListView.php');
?>