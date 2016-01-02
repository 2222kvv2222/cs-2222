<? 
session_start();
include("./conf.php");?>
<html>
	<head>
	<script type='text/javascript' src='js/jquery.min.js' type='text/javascript'></script>
	<script type='text/javascript' src='js/bootstrap.min.js' type='text/javascript'></script>
	<script type='text/javascript' src='js/ajax.js'></script>
	<link rel='stylesheet' type='text/css' href='style/bootstrap.min.css'>
	<title><?=SITE_NAME ?> | Разбан</title>
	</head>
	
	<body>
	
	<div class="navbar navbar-default">
  <div class="navbar-header">
    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-responsive-collapse">
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
      <span class="icon-bar"></span>
    </button>
    <a class="navbar-brand" href="/">Главная</a>
  </div>
  <div class="navbar-collapse collapse navbar-responsive-collapse">
    <ul class="nav navbar-nav">
      <li><a href="unban">Разбан</a></li>
      <li><a href="view">Список</a></li>
	  <li><a data-toggle="modal" data-target="#faq" style="cursor: pointer;">FAQ</a></li>
	  <li><a data-toggle="modal" data-target="#news" style="cursor: pointer;">Новости</a></li>
	  <li class="active"><a href="complaints">Подать жалобу на админа</a></li>
	  <? $bu = mysql_query("SELECT * FROM server");
		 $rows1 = mysql_num_rows($bu);
		if($rows1 > 0) {?>
	   <li><a href="servers">Наши сервера</a></li>
		<? } ?>
    </ul>
  </div>
</div>
	
	
	<div class="container">
	<div style="width: 400px; margin: auto;">
		<div class="panel" style="margin-bottom: 5px;">
		
	<div class="panel-body">
		<div id="result" style="margin: 20px 0 15px 0;">
		<? if(isset($_POST['start'])){
		$kapcha = mb_strtolower($_POST['captcha']);
		if($kapcha != $_SESSION['rand_code']){ 
echo '<div class="alert alert-dismissable alert-danger">
  <button type="button" class="close" data-dismiss="alert">×</button>
  Капча введена неверно, попробуйте снова.
</div>';
} 
else { 
		if($_POST[nick]===''){unset($_POST[nick]);}else{$nick = $_POST[nick];}
		if($_POST[prichina]===''){unset($_POST[prichina]);}else{$prichina = $_POST[prichina];}
		if($_POST[contacts]===''){unset($_POST[contacts]);}else{$contacts = $_POST[contacts];}
		if(isset($nick) and isset($prichina) and isset($contacts)){
		$ip = $_SERVER['REMOTE_ADDR'];
		$date = date("Y-m-d");
		$re = mysql_query("INSERT INTO complaints (nick,prichina,contacts,ip,date) VALUES ('$nick','$prichina','$contacts','$ip','$date')");
		if($re = 'true'){echo '<div class="alert alert-dismissable alert-success">
  <button type="button" class="close" data-dismiss="alert">×</button>
  Жалоба на админа успешно принята и будет рассмотрена в течении 24 часов!
</div>';
		}else {

	echo '<div class="alert alert-dismissable alert-danger">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <strong>Внимание!</strong> Что-то не так. Запись в БД невозможна.
</div>';

}
		}else {

	echo '<div class="alert alert-dismissable alert-danger">
  <button type="button" class="close" data-dismiss="alert">×</button>
  <strong>Внимание!</strong> Вы не всё ввели.
</div>';

}
		}
		}
		?>
		</div>
		<div class="form-group"> 
  
  <form class="form-horizontal" action='' method="POST">
  <fieldset>
    <center><legend>Жалоба на админа</legend></center>
    <div class="form-group">
      <div class="col-lg-10">
        <input type="text" class="form-control" name="nick" id="nick" placeholder="Ник Админа">
      </div>
    </div>
    <div class="form-group">
      <div class="col-lg-10">
        <input type="text" class="form-control" name="prichina" id="prichina" placeholder="Причина жалобы">
      </div>
    </div><br>
	<div class="form-group">
      <div class="col-lg-10">
        <textarea type="text" class="form-control" name="contacts" id="contacts" placeholder="Ваши контакты"></textarea>
      </div>
    </div>
	<div class="form-group">
      <div class="col-lg-10">
			<input type="text" class="form-control" id="captcha" name="captcha" placeholder="Введите код с картинки"><br>
			<span class="form-control input-lg" style="background-color: #6E7B8B;"><center><img src="captcha.php" id="cpt" width="60" height="20" style="cursor: pointer" onclick="generate();"/></center></span>
      </div>
    </div>
    
        <center><input type="submit" name="start" value="Подать Заявку" class="btn btn-primary"></center>
  </fieldset>
</form>
</div>
&copy; 2014-2015 <a href="http://vk.com/matrizza_fox">MaTRiZZa</a>
		</div>
		</div>
		</div>
		</div>
		

		<div class="modal fade" id="faq">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
		<h4 class="modal-title">FAQ: Часто задаваемые вопросы</h4>
      </div>
      <div class="modal-body">
		<p><p><h4>Где узнать IP?</h4></p>
<p>IP узнать можно на сайте <a href="http://2ip.ru">2ip.ru</a></p> 
<p><h4>Как узнать STEAM_ID?</h4></p>
<p>Заходите на любой сервер и в консоле пишете: <i>status</i></p>
<p>Ищите в списке свой ник и возле него будет написан steam id</p>
<p><h4>Пример заполнения формы</h4></p>
<p><img src="images/FAQ.png"></p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade" id="news">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
		<h4 class="modal-title">Новости</h4>
      </div>
      <div class="modal-body">
		<table class="table">
		<th>Дата</th>
		<th>Информация</th>
<?

		$result = mysql_query("SELECT * FROM news ORDER BY id DESC");
		$myrow = mysql_fetch_array($result);
		do{
?>
		<tr>
			<td><span class="label label-primary"><?=$myrow[date]; ?></span></td>
			<td><?=$myrow[news]; ?></td>
		</tr>
<? } while($myrow = mysql_fetch_array($result)); ?>	
		</table>
      </div>
    </div>
  </div>
</div>



	</body>
</html>