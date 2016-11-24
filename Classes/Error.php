<?php
	
	/**
	 * Created by PhpStorm.
	 * User: anton
	 * Date: 24.11.16
	 * Time: 15:15
	 */
	class Error
		{
		public static function errorWithMessage($message = '')
		{
			echo '<script language="javascript">';
			echo "alert(\"$message\");";
			echo '</script>';
		}
			
		}