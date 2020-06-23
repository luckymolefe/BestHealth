<?php
	
	//bootstrapping
	#$root = $_SERVER['DOCUMENT_ROOT'].'/'.basename(__DIR__).'/';
	$root = $_SERVER['DOCUMENT_ROOT'].'/';
	session_start();
	
	require_once('config/connect.php');
	require_once($root.'model/adminModel.php');
	require_once($root.'model/patientModel.php');
	require_once($root.'model/hcpModel.php');
	require_once($root.'model/messageModel.php');
	require_once($root.'model/helperModel.php');
	require_once($root.'model/reportsModel.php');
	require_once($root.'model/backupModel.php');

?>
