<?php
	/**
	 * Created by PhpStorm.
	 * User: anton
	 * Date: 24.11.16
	 * Time: 13:55
	 */
	
	
	define('DB_NAME', 'ADRRBOOK');
	define('DB_USER', 'root');
	define('DB_PASSWORD', 'mysql');
	define('DB_HOST', 'localhost'); // Only for testing
	
	require_once('Classes/DB.php');
	require_once('Classes/Contact.php');
	require_once('Classes/Book.php');
	require_once('Classes/Error.php');
	require_once('Classes/Router.php');