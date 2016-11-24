<?php
	
	/**
	 * Created by PhpStorm.
	 * User: anton
	 * Date: 24.11.16
	 * Time: 12:00
	 */
	class Contact
		{
		use Db;
		public $name, $phone, $email, $id;
		
		public function editContact($contactId)
		{
			$phpSelf = $_SERVER["PHP_SELF"];
			self::getInfoById($contactId);
			
			$htmlOut = <<<HTML
<h2>Редактирование контакта</h2>
<form action=$phpSelf method=post>
    <table>
        <tr>
            <td>Имя контакта:</td>
            <td><input type="text" value="$this->name" name="name"/></td>
        </tr>
        <tr>
            <td>Телефон:</td>
            <td><input type="text" value="$this->phone" name="phone"/></td>
        </tr>
        <tr>
            <td>Почта:</td>
            <td><input type="text" value="$this->email" name="email"/></td>
        </tr>
        <tr>
            <td colspan="2" align="center"><input type="submit"/></td>
        </tr>
        <input type=hidden name=action value=edited> <input type=hidden name=id value=$this->id;>
    </table>
</form>
<br>


HTML;
			
			if ($_POST) {
				self::getInfoFromPOST();
				Db::querry("UPDATE address SET name = '$this->name', phone = '$this->phone', email = '$this->email' WHERE id = $this->id");
				header("Location: $phpSelf?action=list");
			}
			
			echo $htmlOut;
		}
		
		private function getInfoById($id)
		{
			$datas = Db::querry("SELECT * FROM address WHERE id = '$id'");
			
			$data = $datas->fetch_assoc();
			
			$this->name = $data['name'];
			$this->phone = $data['phone'];
			$this->email = $data['email'];
			$this->id = $data['id'];
			
		}
		
		private function getInfoFromPOST()
		{
			if ($_POST) {
				$this->name = $_POST['name'];
				$this->phone = $_POST['phone'];
				$this->email = $_POST['email'];
				$this->id = $_POST['id'];
			}
		}
		
		public function addContact()
		{
			$phpSelf = $_SERVER["PHP_SELF"];
			
			$htmlOut = <<<HTML
<h2>Новый контакт</h2>
<form action='$phpSelf' method=post>
    <table>
        <tr>
            <td>Имя:</td>
            <td><input type="text" name="name"/></td>
        </tr>
        <tr>
            <td>Телефон:</td>
            <td><input type="text" name="phone"/></td>
        </tr>
        <tr>
            <td>Почта:</td>
            <td><input type="text" name="email"/></td>
        </tr>
        <tr>
            <td colspan="2" align="center"><input type="submit"/></td>
        </tr>
        <input type=hidden name=action value=added></table>
</form>
HTML;
			
			if ($_POST) {
				self::getInfoFromPOST();
				Db::querry("INSERT INTO address (name, phone, email) VALUES ('$this->name', '$this->phone', '$this->email')");
				header("Location: $phpSelf?action=list");
			}
			
			echo $htmlOut;
		}
		
		public function deleteContact($id)
		{
			$phpSelf = $_SERVER["PHP_SELF"];
			
			Db::querry("DELETE FROM address where id=$id");
			echo "Entry has been removed <p>";
			header("Location: $phpSelf?id=$id&action=deleted");
		}
		}