<? include("./conf.php");?>

<html>
	<head>
	<script type='text/javascript' src='js/jquery.min.js' type='text/javascript'></script>
	<script type='text/javascript' src='js/bootstrap.min.js' type='text/javascript'></script>
	<script type='text/javascript' src='js/ajax.js'></script>
	<link rel='stylesheet' type='text/css' href='style/bootstrap.min.css'>
	<title><?=SITE_NAME ?> | Сервера</title>
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
	  <li><a href="complaints">Подать жалобу на админа</a></li>
	  <li class="active"><a href="servers">Наши сервера</a></li>
    </ul>
  </div>
</div>
	
	
	<div class="container">
	<div style="<? if(!isset($_GET['view'])){echo 'width: 800px;';} else {echo 'width: 450px;';} ?> margin: auto;">
		<div class="panel" style="margin-bottom: 5px;">
		
	<div class="panel-body">
	<div id="result" style="margin: 20px 0 15px 0;"></div>
		<div id="result" style="margin: 20px 0 15px 0;"></div>
		<div class="form-group"> 
  
  <form class="form-horizontal">
  <fieldset>
    

<?
	include('conf.php');
	include('admin/includes/mon.php');
	if(!isset($_GET['view'])) {
	$req=mysql_query("SELECT * FROM server");
if(mysql_num_rows($req)>0) { 
  $result = mysql_query("SELECT * FROM server");
$myrow = mysql_fetch_array($result);
?>
<h2><center>Список наших серверов</h2></center>
<center> <table class="table table-striped"> <thead><th>Название</th><th>IP</th><th>Игроков</th><th>Карта</th><th>Действие</th></thead><tbody>

<?

do{
$server_info = CSMonitoring::getServerInfo( $myrow["ip"], $myrow["port"], $error );
printf ("<tr class='active'>
		 <form action='' method='post'>
		 <input type='hidden' name='u' value='".$myrow[id]."'>
		 <td>%s</td>
		 <td>%s:%s</td>
		 <td>%s/%s</td>
		 <td>%s</td>
		 <td><a href='?view=%s'>Подробности</a></td>
		 </form></tr>", $myrow["name"],$myrow["ip"],$myrow["port"],$server_info['pc'],$server_info['pm'],$server_info['nm'],$myrow[id]);
}
while($myrow = mysql_fetch_array($result));
	
  echo "</tbody>
</table>";
  } } else {
		$id = $_GET["view"];



$result = mysql_query("SELECT * FROM server WHERE id='$id'");
$myrow = mysql_fetch_array($result);
$server_info = CSMonitoring::getServerInfo( $myrow["ip"], $myrow["port"], $error );
$name_serv = $server_info['nh'];
$url = "http://unbe.ml/other/maps/".$server_info['nm'].".jpg";
if (@fopen($url, "r")) {
$img = 'http://unbe.ml/other/maps/'.$server_info['nm'].'.jpg';
} else {$img = 'http://unbe.ml/other/maps/nopicture.gif';}
if($name_serv == '') {$img = 'http://unbe.ml/other/maps/off.jpg';}
?>

<center><legend><?=$server_info['nh']; ?> </legend></center>

<ul class="pager">
  <li class="previous"><a href="javascript:history.go(-1)" mce_href="javascript:history.go(-1)">← Назад</a></li>
</ul>
			<table class="table table-striped">
			<tr><td><center><img src="<?=$img?>"><br><?=$server_info['nm']?></center></td></tr>
			<table class="table table-striped">
			<thead><th><?=$server_info['pc']?>/<?=$server_info['pm']?></th><th>Ник игрока</th><th>Убийств</th></thead>
                    <?
					if($server_info['pc'] !== 0){
					if( $server_info['ps'] ){?>
                        <?$c = 0; foreach( $server_info['ps'] as $p ){?>
                        <tr>
                            <td><?=++$c?>.</td>
                            <td><strong><?=$p['n']?></strong></td>
                            <td><?=$p['s']?></td>
                        </tr>
                        <?}?>
                    <?} else {?>
                        <tr>
                            <td colspan='3'><?=$error?></td>
                        </tr>
                    <?}} else {?>
					<tr>
                            <td colspan='3'>На данный момент на сервере нет игроков.</td>
                        </tr>
					<?}?>
                </table>
			
			<? } ?>
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