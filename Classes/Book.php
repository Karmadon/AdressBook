<?php
	
	/**
	 * Created by PhpStorm.
	 * User: anton
	 * Date: 24.11.16
	 * Time: 12:00
	 */
	class Book
		{
		use Db;
		
		public $contact;
		
		public function listBook()
		{
			
			
			$data = Db::querry("SELECT * FROM address ORDER BY name ASC");
			$phpSelf = $_SERVER["PHP_SELF"];
			
			
			$htmlOut = <<<HTML
<h2>Адресная книга</h2><p>
<table border cellpadding=3>
    <tr>
        <th width=100>ФИО</th>
        <th width=100>Телефон</th>
        <th width=200>Почта</th>
        <th width=100
            colspan=2>Упраление
        </th>
    </tr>

HTML;
			
			
			while ($info = mysqli_fetch_array($data)) {
				
				$id = $info['id'];
				$name = $info['name'];
				$phone = $info['phone'];
				$email = $info['email'];
				
				$htmlOut .= <<<HTML
<tr>
    <td>$name</td>
    <td>$phone</td>
    <td><a href=mailto:$email>$email</a></td>
    <td><a href=$phpSelf?id=$id&action=edit>Править</a></td>
    <td><a href=$phpSelf?id=$id&action=delete>Удалить</a></td>
</tr>
HTML;
			}
			
			$htmlOut .= <<<HTML

<td colspan=5 align=right><a type="button" href=$phpSelf?action=add>Новая запись</a></td>

</table>

HTML;
			
			
			echo $htmlOut;
		}
			
			
		}