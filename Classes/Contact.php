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
		public $name, $phones = array(), $email, $id;
		
		public function editContact($contactId)
		{
			$phpSelf = $_SERVER["PHP_SELF"];
			self::getInfoById($contactId);
			
			$htmlOut = <<<HTML
<h2><a href="/AdressBook/">Главная</a> | Редактирование контакта</h2>
<form action=$phpSelf method=post>
    <table>
        <tr>
            <td>Имя контакта:</td>
            <td><input type="text" value="$this->name" name="name"/></td>
        </tr>
HTML;
			$i = 0;
			foreach ($this->phones as $phone) {
				$i++;
				
				$htmlOut .= <<<HTML
				
	        <tr>
            <td>Телефон №$i:</td>
            <td><input type="text" value="$phone" name="phone"/></td>
        </tr>
	
HTML;
				
			}
			
			
			$htmlOut .= <<<HTML
		
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
			$this->email = $data['email'];
			$this->id = $data['id'];
			
			$phones = Db::querry("SELECT * FROM phones WHERE contact_id = '$id'");
			
			$i = 0;
			while ($row = mysqli_fetch_assoc($phones)) {
				$i++;
				$this->phones[$i] = $row['phone_number'] . " ";
			}
			
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
			
			<script language='JavaScript' type="text/javascript">

    var i = 2;
    function ff() {
        document.getElementById('phone').innerHTML = document.getElementById('phone').innerHTML + "<input type='text' name='phone[" + i + "]' /><br/>";
        i++;
    }
</script>

<h2><a href="/AdressBook/">Главная</a> | Новый контакт</h2>
<form action='$phpSelf' method=post>
    <table>
        <tr>
            <td>Имя:</td>
            <td><input type="text" name="name" required/></td>
        </tr>
        <tr>
            <td>Почта:</td>
            <td><input type="text" name="email"/></td>
        </tr>
        <tr>
            <td>Телефоны:</td>
<td><span name='phone' id='phone'><input type='text' name='phone[1]'/></span></td>
<td><input type='button' value='Еще один' onclick="ff()"></td>
        </tr>
        <tr>
            <td colspan="2" align="center"><input type="submit"/></td>
        </tr>
        <input type=hidden name=action value=added></table>
</form>









HTML;
			
			if ($_POST) {
				
				
				print_r($_POST);
				
				
				self::getInfoFromPOST();
				Db::querry("INSERT INTO address (name, email) VALUES ('$this->name', '$this->email')");
				$id = Db::qetLastInsertId();
				
				$sql = 'INSERT INTO phones (contact_id, phone_number) VALUES ';
				
				
				foreach ($_POST['phone'] as $ph) {
					$sql .= "('$id', '$ph'),";
				}
				
				Db::querry(substr($sql, 0, -1));
				
				
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
		
		public function viewContact($id)
		{
			$phpSelf = $_SERVER["PHP_SELF"];
			self::getInfoById($id);
			
			$htmlOut = <<<HTML
<h2><a href="/AdressBook/">Главная</a> | Просмотр контакта</h2>
<form action=$phpSelf method=post>
    <table>
        <tr>
            <td>Имя контакта:</td>
            <td><input type="text" disabled value="$this->name" name="name"/></td>
        </tr>
HTML;
			$i = 0;
			foreach ($this->phones as $phone) {
				$i++;
				
				$htmlOut .= <<<HTML
				
	        <tr>
            <td>Телефон №$i:</td>
            <td><input type="text" disabled value="$phone" name="phone"/></td>
        </tr>
	
HTML;
				
			}
			
			
			$htmlOut .= <<<HTML
		
        <tr>
            <td>Почта:</td>
            <td><input type="text" disabled value="$this->email" name="email"/></td>
        </tr>

        <input type=hidden name=action value=edited> <input type=hidden name=id value=$this->id;>
    </table>
</form>
<br>


HTML;
			
			echo $htmlOut;
		}
			
		}