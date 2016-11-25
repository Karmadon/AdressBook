<?php
	
	/**
	 * Created by PhpStorm.
	 * User: anton
	 * Date: 24.11.16
	 * Time: 16:19
	 */
	class Router
		{
		public function __construct()
		{
			self::route();
		}
		
		public function route()
		{
			$book = new Book();
			$contact = new Contact();
			
			if (array_key_exists('action', $_POST)) {
				$action = $_POST['action'];
			} else {
				$action = array_key_exists('action', $_GET) ? $_GET['action'] : 'list';
			}
			
			
			switch ($action) {
				case 'list':
					$book->listBook();
					break;
				case 'add':
					$contact->addContact();
					break;
				case 'added':
					$contact->addContact();
					break;
				case 'delete':
					array_key_exists('id', $_GET) ? $contact->deleteContact($_GET['id']) : Error::errorWithMessage('Невозможно удалить');
					break;
				case 'deleted':
					Error::errorWithMessage('Запись удалена');
					$book->listBook();
					break;
				case 'edit':
					array_key_exists('id', $_GET) ? $contact->editContact($_GET['id']) : Error::errorWithMessage('Невозможно отредактировать');
					break;
				case 'edited':
					$contact->editContact($_GET['id']);
					break;
				case 'view':
					$contact->viewContact($_GET['id']);
					break;
			}
		}
			
		}