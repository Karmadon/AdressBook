<?php
	
	/**
	 * Created by PhpStorm.
	 * User: anton
	 * Date: 24.11.16
	 * Time: 12:01
	 */
	trait Db
		{
		public static $link;
		
		public function __construct()
		{
			self::getLink();
		}
		
		private function getLink()
		{
			if (!self::$link)
				self::$link = new mysqli (DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
			mysqli_set_charset(self::$link, 'utf8');
		}
		
		public static function querry($query)
		{
			if (!self::$link)
				self::getLink();
			
			$result = mysqli_query(self::$link, $query);
			if (!$result) {
				http_response_code(404);
				die(mysqli_error(self::$link));
			} else
				return $result;
		}
		
		public static function qetLastInsertId()
		{
			return mysqli_insert_id(self::$link);
		}
		
		public function __destruct()
		{
			mysqli_close(self::$link);
		}
		}