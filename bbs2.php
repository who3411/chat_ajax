<?php
	session_start();
	$allUpData = '';
	$mysqli = new mysqli("localhost", "account_root", "testpass", "test");
	if(mysqli_connect_errno()){
		die("MySQL connection error: ". mysqli_connect_errno());
		exit();
	}
	if($_POST['mode'] == 0){
		$message = htmlspecialchars($_POST['message']);
		if($message == 'undo'){
			//一番上のデータをとる方法1
			$sql = 'INSERT INTO clearChat(roomID, accountID, str, path) SELECT roomID, ';
			$sql .= 'accountID, str, path FROM roomChat WHERE ';
			$sql .= 'roomID = '. $_SESSION['roomID']. ' AND accountID = "';
			$sql .= $_SESSION['id']. '" ORDER BY chatTime DESC LIMIT 1;';
			if(!($result = $mysqli->query($sql))){
				die("SQL error: " . $mysqli->error);
				exit();
			}
			$sql = 'UPDATE clearChat SET chatTime = '. time(). ' WHERE ';
			$sql .= 'chatTime = (SELECT MAX(chatTime) FROM (SELECT * FROM roomChat WHERE';
			$sql .= ' accountID = "'. $_SESSION['id']. '" AND roomID = '. $_SESSION['roomID'];
			$sql .= ') AS temp GROUP BY temp.accountID, temp.roomID);';
			if(!($result = $mysqli->query($sql))){
				die("SQL error: " . $mysqli->error);
				exit();
			}
			//一番上のデータをとる方法2
			$sql = 'DELETE FROM roomChat WHERE chatTime = (SELECT MAX(chatTime) FROM ';
			$sql .= '(SELECT * FROM roomChat WHERE accountID = "'. $_SESSION['id']. '" ';
			$sql .= 'AND roomID = '. $_SESSION['roomID']. ') AS temp GROUP BY ';
			$sql .= 'temp.accountID, temp.roomID);';
			$allUpData = '<delete>';
		}else if($message == 'clear'){
			$sql = 'INSERT INTO clearChat(roomID, accountID, str, path) SELECT roomID, ';
			$sql .= 'accountID, str, path FROM roomChat WHERE roomID = '. $_SESSION['roomID']. ';';
			if(!($result = $mysqli->query($sql))){
				die("SQL error: " . $mysqli->error);
				exit();
			}
			$sql = 'DELETE FROM roomChat WHERE roomID = '. $_SESSION['roomID']. ';';
			if(!($result = $mysqli->query($sql))){
				die("SQL error: " . $mysqli->error);
				exit();
			}
		}else{
			$sql = 'INSERT INTO roomChat VALUES("'. $_SESSION['id']. '", "';
			$sql .= $_SESSION['roomID']. '", NULL, "'. $message. '", "';
			$sql .= $_POST['tmp_name']. '");';
		}
		if(!($result = $mysqli->query($sql))){
			die("SQL error: " . $mysqli->error);
			exit();
		}
	}else if($_POST['mode'] == 1){
		$allUpData = upCheck(1);
	}else{
		$allUpData = upCheck(2);
	}
	echo $allUpData;

	function upCheck($pattern){
		$mysqli = new mysqli("localhost", "account_root", "testpass", "test");
		if(mysqli_connect_errno()){
			die("MySQL connection error: ". mysqli_connect_errno());
			exit();
		}
		$upData = '';
		$sql = 'SELECT roomChat.chatTime AS time, account.name AS name, roomChat.str AS str, ';
		$sql .= 'roomChat.path AS path FROM roomChat, account WHERE account.id = roomChat.accountID ';
		$sql .= 'AND roomChat.roomID = '. $_SESSION['roomID']. ' ORDER BY chatTime DESC;';
		if(!($result = $mysqli->query($sql))){
			die("SQL error: ". $mysqli->error);
			exit();
		}
		if($pattern > 1){
			$before = $result->num_rows;
			$after = $before;
			$loopcount = 0;
			while($before !== $after){
				/*
				sleep(1);
				if(!($result = $mysqli->query($sql))){
					die("SQL error: ". $mysqli->error);
					exit();
				}
				$after = $result->num_rows;
				if($loopcount++ > 9)	break;
				*/
			}
		}
		$nowquery = $result->num_rows;
		if($_SESSION['querycnt'] < $nowquery || $_SESSION['querycnt'] == 0){
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				if($_SESSION['querycnt'] == $nowquery) break;
				$upData .= '<span class="'. ($_SESSION['name'] != $row['name'] ? 'right' : 'left'). '">';
				$upData .= '<div class="'. ($_SESSION['name'] != $row['name'] ? 'right' : 'left');
				$upData .= '_user">'. $row['name']. '</div>';
				$upData .= '<div class="'. ($_SESSION['name'] != $row['name'] ? 'right' : 'left');
				$upData .= '_balloon">'. $row['str'];
				if($row['path'] != NULL){
					$ext = substr($row['path'], strrpos($row['path'], '.') + 1);
					$upData .= '<br><a href="files/'. $row['path']. '" target="_blank">';
					if(strlen(strripos($ext, 'txt')) > 0){
						$upData .= $row['path'];
					}else{
						$upData .= '<img src="files/'. $row['path']. '">';
					}
					$upData .= '</a>';
				}
				$upData .= '</div></span>';
				$_SESSION['querycnt']++;
			}
		}else if($_SESSION['querycnt'] > 0 && $nowquery == 0){
			$_SESSION['querycnt'] = 0;
			echo '<cleard>';
		}else if($_SESSION['querycnt'] > $nowquery){
			$sql = str_replace('roomChat', 'clearChat', $sql);
			if(!($result = $mysqli->query($sql))){
				die("SQL error: ". $mysqli->error);
				exit();
			}
			$upData .= '<deleted>';
			while($row = $result->fetch_array(MYSQLI_ASSOC)){
				if($_SESSION['querycnt'] == $nowquery)	break;
				$upData .= ($row['name']. $row['str']);
				if($row['path'] != NULL){
					$ext = substr($row['path'], strrpos($row['path'], '.') + 1);
					if(strlen(strripos($ext, 'txt')) > 0){
						$upData .= $row['path'];
					}
				}
				$upData .= '<span></span>';
				/*
				$upData .= '<span class="'. ($_SESSION['name'] != $row['name'] ? 'right' 'left'). '>';
				$upData .= '<div class="'. ($_SESSION['name'] != $row['name'] ? 'right' : 'left');
				$upData .= '_user">'. $row['name']. '</div>';
				$upData .= '<div class="'. ($_SESSION['name'] != $row['name'] ? 'right' : 'left');
				$upData .= '_balloon">'. $row['str'];
				if($row['path'] != NULL){
					$upData .= '<br><img src="files/"'. $row['path']. '">';
				}
				$upData .= '</div></span>;
				*/	
				$_SESSION['querycnt']--;
			}
		}
		return $upData;
	}
?>
