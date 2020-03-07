<?php
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'test');
    
    $mysqli = @new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
    if ($mysqli->connect_errno) exit('Ошибка соединения с БД');
    $mysqli->set_charset('utf8');
    
	$reg = '/^[A-Za-zа-яА-Я0-9]+$/u';
	if (isset($_POST['user_role'])) {
		$rolename = $mysqli->real_escape_string (htmlspecialchars($_POST['rolename']));
		if ($rolename == ''){
		echo 'Вы забыли вписать роль для пользователя!';
		exit();
		}elseif (preg_match($reg, $rolename)){
			echo '';
			}else {
			echo 'Роль для пользователя может быть только словом или числом!';
			exit();
			}
		$query = "INSERT INTO `user_role` (`id`, `rolename`) VALUES (NULL, '$rolename')";		
		$result = $mysqli->query($query);
    }
	
	
	$result_rolename = $mysqli->query('SELECT `rolename` FROM `user_role` ORDER BY `id`');
	$roles = [];
	
	/*получаем значение поля rolename*/
	while (($rol = $result_rolename->fetch_assoc()) != false) {
		$roles[] = $rol;
	}
	
	/*получаем список пользователей*/
	$result_id = $mysqli->query('SELECT `username`, `rolename` FROM `user`,`user_role` WHERE `user`.`role_id`=`user_role`.`id` ');
	$spisok = [];
	while (($rolid = $result_id->fetch_assoc()) != false) {
		$spisok[] = $rolid;
	}

	/*заносим нового пользователя в базу*/
	if (isset($_POST['user'])) {
		$selectid = $mysqli->real_escape_string (htmlspecialchars ($_POST['selectid']));
		$result_id = $mysqli->query = ("SELECT `id` FROM `user_role` WHERE `rolename` = '$selectid'");
		$resultid = $mysqli->query($result_id);
		foreach ($resultid as $kay => $value) {
			foreach ($value as $z => $r) {
			}
		}
        $username = $mysqli->real_escape_string (htmlspecialchars($_POST['username']));
		if ($username == ''){
		echo 'Вы забыли вписать имя для пользователя!';
		exit();
		}elseif (preg_match($reg, $username)){
			echo '';
			}else {
			echo 'Имя пользователя может быть только словом или числом!';
			exit();
			}
		$query = "INSERT INTO `user` (`id`, `username`, `role_id`) VALUES (NULL, '$username', '$r')";		
		$resultname = $mysqli->query($query);
        //$error = true;
    }
    $mysqli->close();
	
?>
	<form>
	<p>Список всех пользователей с ролями:</p>
	<?php foreach ($spisok as $key => $value) {
			foreach ($value as $k => $v) {
			echo "   $v";
        }
        echo '<br />';
    } ?>			
	</form>
	<br /><br />

	<?php if (isset($result)) { ?>
		<?php if ($result) { ?>
			<p>Новая роль для пользователей добавлена.</p>
		<?php } else { ?>
			<p>Ошибка при добавлении.</p>
		<?php } ?>
	<?php } ?>


<form name="user_role" method="post" action="index.php">
    <p>
        Введите роли для пользователей: <input type="text" name="rolename" />
    </p>
    <p>
        <input type="submit" name="user_role" value="Записать" />
    </p>
</form>
<br>

		<?php if (isset($resultname)) { ?>
			<?php if ($resultname) { ?>
				<p>Новый пользователь добавлен.</p>
			<?php } else { ?>
				<p>Ошибка при добавлении.</p>
			<?php } ?>
		<?php } ?>

<form name="user" method="post" action="index.php">
    <p>
        Введите имя: <input type="text" name="username" />
    </p>
	
	Значение: <select class="form-control" name="selectid">
					<?php foreach ($roles as $keys => $values) {?>
						<?php foreach ($values as $ke => $va) {?>
								<option value="<?=$va?>"><?=$va?></option>
					<?php } ?>
					<?php } ?>	 	  	 
			  </select>
    <p>
        <input type="submit" name="user" value="Записать" />
    </p>
</form>