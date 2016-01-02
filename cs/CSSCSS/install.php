<?php


	
	$dbname = !isset($_POST['dbname'])? '' : $_POST['dbname'];
	$dbhost = !isset($_POST['dbhost'])? '' : $_POST['dbhost'];
	$dbuser = !isset($_POST['dbuser'])? '' : $_POST['dbuser'];
	$dbpass = !isset($_POST['dbpass'])? '' : $_POST['dbpass'];
	$time_zone = !isset($_POST['time_zone'])? '' : $_POST['time_zone'];
	$site_name 	= !isset($_POST['site_name'])? '' : $_POST['site_name'];
	$admin = !isset($_POST['admin'])? '' : $_POST['admin'];
	$pass_admin = !isset($_POST['pass_admin'])? '' : $_POST['pass_admin'];
?>
<html>
	<head>
	<script type='text/javascript' src='js/jquery.min.js' type='text/javascript'></script>
	<script type='text/javascript' src='js/bootstrap.min.js' type='text/javascript'></script>
	<link rel='stylesheet' type='text/css' href='style/bootstrap.min.css'>
	<title>Установка UNBan ENGINE II</title>
	</head>
	
	<body>
	
	
	<div class="container">
	<div style="width: 700px; margin: auto; margin-top: 25px;">
		<div class="panel" style="margin-bottom: 5px;">
		
	<div class="panel-body">
	<div id="result" style="margin: 20px 0 15px 0;"></div>
		<div id="result" style="margin: 20px 0 15px 0;"></div>
		<div class="form-group"> 
  
  <fieldset>
    <center><h2>Установка UNBan ENGINE II</h2></center><hr>
    <blockquote>
  <p>Требования</p>
  <small><ul>
					<li>PHP 5.2 или позднее <span class="light">(ваша версия php - <?=phpversion()?>)</span></li>
					<li>MySQL 5</li>
					<li>Apache w/ mod_rewrite</li>
				</ul></small>
</blockquote><hr>
<form action="" method="post">
				<div class="form-group">
				  <input type="text" class="form-control" name="dbname" size="45" placeholder="Имя БД" value="<?=$dbname?>">
				</div>
				<div class="form-group">
				  <input type="text" class="form-control" name="dbhost" size="45" placeholder="Хост БД" value="<?=$dbhost?>">
				</div>
				<div class="form-group">
				  <input type="text" class="form-control" name="dbuser" size="45" placeholder="Логин от БД" value="<?=$dbuser?>">
				</div>
				<div class="form-group">
				  <input type="text" class="form-control" name="dbpass" size="45" placeholder="Пароль от БД" value="<?=$dbpass?>">
				</div>
				<select class="form-control" name="time_zone">
				  <option>Выберите часовой пояс</option>
				  <option value="Europe/Kiev">Киев (Украина)</option>
				  <option value="Europe/Moscow">Москва (Россия)</option>
				</select>
					<hr/>
				<div class="form-group">
				  <input type="text" class="form-control" name="site_name" size="100" placeholder="Название сайта" value="<?=$site_name?>">
				</div>
					<hr/>
				<div class="form-group">
				  <input type="text" class="form-control" name="admin" size="45" placeholder="Логин для админки" value="<?=$admin?>">
				</div>
				<div class="form-group">
				  <input type="text" class="form-control" name="pass_admin" size="45" placeholder="Пароль для админки" value="<?=$pass_admin?>">
				</div>
				
				<?php
			if(isset($_POST['submit']))
			{
				echo "<h2>Установка началась...</h2>";
				
				$errors = array();
				$success = array();
				
				if(empty($_POST['dbname'])) $errors[] = "Пожалуйста, введите имя БД";
				if(empty($_POST['dbhost'])) $errors[] = "Пожалуйста, введить хост БД";
				if(empty($_POST['dbuser'])) $errors[] = "Пожалуйста, введите имя пользователя БД";
				if(empty($_POST['dbpass'])) $errors[] = "Пожалуйста, введите пароль пользователя БД";
				if(empty($_POST['time_zone'])) $errors[] = "Пожалуйста, выберите часовой пояс";
				if(empty($_POST['site_name'])) $errors[] = "Пожалуйста, введите название вашего сайта";
				if(empty($_POST['admin'])) $errors[] = "Пожалуйста, введите логин от админки";
				if(empty($_POST['pass_admin'])) $errors[] = "Пожалуйста, введите пароль от админки";
				
				//check for .htaccess
				if( !file_exists('.htaccess') ) 
					$errors[] = "файл .htaccess не найден";
				else
					$success[] = "файл .htaccess был найден";
				
				//test MySQL connection
				try{
					$db = new PDO('mysql:dbname='.$_POST['dbname'].';host='.$_POST['dbhost'], $_POST['dbuser'], $_POST['dbpass']);
					$success[] = "database connection successful";
					
					$db->query("CREATE TABLE IF NOT EXISTS `news` (
								  `id` int(50) NOT NULL AUTO_INCREMENT,
								  `news` text NOT NULL,
								  `date` date NOT NULL,
								  PRIMARY KEY (`id`)
								) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3;");
					
					$db->query("CREATE TABLE IF NOT EXISTS `complaints` (
								  `id` int(11) NOT NULL AUTO_INCREMENT,
								  `nick` varchar(100) NOT NULL,
								  `prichina` text NOT NULL,
								  `contacts` varchar(200) NOT NULL,
								  `view` int(1) NOT NULL,
								  `ip` varchar(15) NOT NULL,
								  `date` date NOT NULL,
								  PRIMARY KEY (`id`)
								) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;");
								
					$db->query("INSERT INTO `complaints` (`id`, `nick`, `prichina`, `contacts`, `view`, `ip`, `date`) VALUES
								(1, '-=ARES=-', 'просто', 'awd', 1, '127.0.0.1', '2015-01-23');");
								
					$db->query("CREATE TABLE IF NOT EXISTS `server` (
								  `id` int(11) NOT NULL AUTO_INCREMENT,
								  `name` text NOT NULL,
								  `ip` varchar(15) NOT NULL,
								  `port` int(10) NOT NULL,
								  PRIMARY KEY (`id`)
								) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4;");
								
					$db->query("INSERT INTO `server` (`id`, `name`, `ip`, `port`) VALUES
								(2, '+ 18 VIP-MOSCOW SERVER', '193.26.217.101', 27048),
								(3, '.:: Без лишних слов! © 18+ ::.', '77.220.180.144', 27015);");
					
					$db->query("INSERT INTO `news` (`id`, `news`, `date`) VALUES
								(1, 'Настроена стабильность скрипта. Багофиксы. Улучшение работоспособности.', '2014-12-28'),
								(2, 'Добавлены на сайт бан по IP. За злоупотребление можно будет получить бан.', '2015-01-01');");
					
					$db->query("CREATE TABLE IF NOT EXISTS `unban` (
								  `id` int(255) NOT NULL AUTO_INCREMENT,
								  `nick` varchar(40) NOT NULL,
								  `contacts` varchar(255) NOT NULL,
								  `prichina` text NOT NULL,
								  `dok` text NOT NULL,
								  `ban` int(1) NOT NULL,
								  `ip` varchar(25) NOT NULL,
								  `date` date NOT NULL,
								  `server` int(1) NOT NULL,
								  PRIMARY KEY (`id`)
								) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;");
					
					$db->query("INSERT INTO `unban` (`id`, `nick`, `contacts`, `prichina`, `dok`, `ban`, `ip`, `date`, `server`) VALUES
								(1, 'CocoJambo007', 'admin@site.ru', 'WH', 'http://vk.com', 2, '127.0.0.1', '2014-12-27', 0),
								(2, 'STEAM_0:X:XXXXXXXX', 'skype', 'CD Hack', 'http://site2.ru', 0, '127.0.0.1', '2014-12-28', 2),
								(3, '192.168.0.100', 'вк', 'АИМ', 'Я не читер', 1, '127.0.0.1', '2014-12-30', 3);");
						
					$db->query("CREATE TABLE IF NOT EXISTS `adminka` (
								`id` int(1) NOT NULL AUTO_INCREMENT,
								`login_a` text NOT NULL,
								`pass_a` text NOT NULL,
								`auth` int(11) NOT NULL,
								`last_active` text NOT NULL,
								PRIMARY KEY (`id`));");
								
						
					$db->query("INSERT INTO `adminka` (`id`, `login_a`, `pass_a`, `auth`, `last_active`) VALUES (1, '".$admin."', '".$pass_admin."', 1418845349, '127.0.0.1');");
					
					$db->query("CREATE TABLE IF NOT EXISTS `ip_ban` (
								  `id` int(11) NOT NULL AUTO_INCREMENT,
								  `ip` varchar(50) NOT NULL,
								  `date` date NOT NULL,
								  `prichina` text NOT NULL,
								  PRIMARY KEY (`id`)
								) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;");
								
					$db->query("INSERT INTO `ip_ban` (`id`, `ip`, `date`, `prichina`) VALUES
								(8, '127.0.0.2', '2015-01-01', 'Просто)');");
					
				}catch (PDOException $e){
					$errors[] = 'database connection failed: ' . $e->getMessage();
				}
							
				//create config
				$config = file_get_contents('conf.php');
				$find = array(
					'**time_zone**',
					'**database_host**',
					'**database_user**',
					'**database_pass**',
					'**database_name**',
					'**site_name**',
				);
				$replace = array(
					$_POST['time_zone'],
					$_POST['dbhost'],
					$_POST['dbuser'],
					$_POST['dbpass'],
					$_POST['dbname'],
					$_POST['site_name']
				);
				$config = str_replace($find, $replace, $config);				
				if( count($errors) == 0 and file_put_contents('conf.php', $config) )
					$success[] = "файл conf.php был успешно изменён";
				else
					$errors[] = 'файл conf.php не был изменён';
		
				foreach($errors as $message)
					echo '<div class="alert alert-dismissable alert-danger">
					  '.$message.'
					</div>';
				foreach($success as $message)
					echo '<div class="alert alert-dismissable alert-success">
					  '.$message.'
					</div>';
				
				
				if( count($errors) == 0)
				{
					//check version
					
					echo '<div class="alert alert-dismissable alert-success"><strong>Движок был успешно установлен</strong></div>';
					echo '<div class="alert alert-dismissable alert-info">Пожалуйста, удалите файл <b>install.php</b>!</div>';
					echo '<p>Вы можете начать пользоваться сайтом <a href="http://'.$_SERVER["HTTP_HOST"].'">'.$_SERVER["HTTP_HOST"].'</a> или зайти в админку <a href="http://'.$_SERVER["HTTP_HOST"].'/adm/">'.$_SERVER["HTTP_HOST"].'/adm/</a>.</p>';
				}
				echo "</div>";
			}
			?>
				<center><p class="center">
					<input type="submit" name="submit" value="Установить Движок" class="btn btn-success" <?if(isset($_POST['submit'])){if( count($errors) == 0){echo 'disabled';}} ?>/>
				</p></center>
				
</form>
  </fieldset>

</div>
			&copy; 2014-2015 <a href="http://vk.com/matrizza_fox">MaTRiZZa</a>
		</div>
		</div>
		</div>
		</div>

	</body>
</html>