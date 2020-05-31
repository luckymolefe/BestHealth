<?php
	
	//bootstrapping
	$root = $_SERVER['DOCUMENT_ROOT'].'/'.basename(__DIR__).'/';
	session_start();
	
	require_once($root.'config/connect.php');
	require_once($root.'model/adminModel.php');
	require_once($root.'model/patientModel.php');
	require_once($root.'model/hcpModel.php');
	require_once($root.'model/messageModel.php');
	require_once($root.'model/helperModel.php');
	require_once($root.'model/reportsModel.php');
	require_once($root.'model/backupModel.php');

?>