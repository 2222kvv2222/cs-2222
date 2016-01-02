<?
if(!isset($_GET['view'])){
if(!isset($_GET['add'])){
if(!isset($_GET['u'])) {

if(isset($_POST['del_all']))
    {
    mysql_query("DELETE FROM `server`");    
    }

if(isset($_POST['del']))
    {
    $id=$_POST['u'];
    mysql_query("DELETE FROM `server` WHERE `id` = '$id'");    
    }
if(isset($_POST['refresh']))
    {
	$id=$_POST['u'];
	$res1 = mysql_query("SELECT * FROM server WHERE id='$id'");
	$m = mysql_fetch_array($res1);
	$server_info = CSMonitoring::getServerInfo( $m['ip'], $m['port'], $error );
	$name = $server_info['nh'];
    mysql_query ("UPDATE server SET name='$name' WHERE id='$id'");   
    }
	?>
	<ul class="pager">
  <li class="previous"><a href="./?go=server&add">Добавить</a></li>
</ul>
	<?
	$req=mysql_query("SELECT * FROM server");
if(mysql_num_rows($req)>0) { 
  $result = mysql_query("SELECT * FROM server");
$myrow = mysql_fetch_array($result);
?>
<h2><center>Мои сервера</h2></center>
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
		 <td><div class='btn-group'>
			 <a href='#' class='btn btn-default dropdown-toggle' data-toggle='dropdown' aria-expanded='false'>Действие  <span class='caret'></span></a>
			 <ul class='dropdown-menu'>
			 <li><a href='./?go=server&view=%s'>Подробности</a></li>
			 <li><a href='./?go=server&u=%s'>Редактировать</a></li>
			 <li>&nbsp;&nbsp;<input type='submit' value='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Обновить&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' name='refresh' class='btn btn-default'></li>
			 <li>&nbsp;&nbsp;<input type='submit' value='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Удалить&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' name='del' class='btn btn-default'></li>
			 </ul>
			 </div></td>
		 </form></tr>", $myrow["name"],$myrow["ip"],$myrow["port"],$server_info['pc'],$server_info['pm'],$server_info['nm'],$myrow[id],$myrow[id]);
}
while($myrow = mysql_fetch_array($result));
	
  echo "</tbody>
</table>";
  }
else {
	echo '<div class="panel panel-info">
  <div class="panel-heading">
    <h3 class="panel-info">Внимание!</h3>
  </div>
  <div class="panel-body">
    Вы не добавляли сервера!
  </div>
</div>';
}
}
                                       
	  else {
	  $id = $_GET["u"];
?>
<h2><center>Редактирование сервера №<?=$id; ?></h2></center>
<?
	if(isset($_POST["set1"])) {
$ip= $_POST["ip"];
$port = $_POST["port"];
$result = mysql_query ("UPDATE server SET ip='$ip', port='$port' WHERE id='$id'");
			  
			  if($result == 'true')  {
			  echo '<div class="alert alert-dismissable alert-success">
					<button type="button" class="close" data-dismiss="alert">?</button>
					Отредактировано!
					</div>
					<script>
							function GoNah(){ 
						location="./?go=server"; 
						} 
						setTimeout( "GoNah()", 2000 );
						</script>'; 
			  }
			  else {echo '<div class="alert alert-dismissable alert-danger">
						  <button type="button" class="close" data-dismiss="alert">?</button>
						  <strong>Не отредактировано!</strong> Вы где-то ошиблись.
						  </div>';}
	  }

	  $result2 = mysql_query("SELECT * FROM server WHERE id='$id'");
$myrow2 = mysql_fetch_array($result2);
	  echo '<center><form action="" method="post" name="edit">
	  <br><div class="form-group">
          <label class="control-label" for="inputLarge">IP: </label>
          <input class="form-control input-lg" type="text" name="ip" value="'.$myrow2["ip"].'" maxlength="15">
		  </div>
		  <div class="form-group">
          <label class="control-label" for="inputLarge">Порт: </label>
          <input class="form-control input-lg" type="text" name="port" value="'.$myrow2["port"].'" maxlength="10">
		  </div><br>
	   <ul class="pager">
		<li class="previous"><a href="javascript:history.go(-1)" mce_href="javascript:history.go(-1)">< Назад</a></li>
		</ul>
	   <input class="btn btn-primary" name="set1" type="submit" value="Редактировать" />
	  </form></center>';
	  
	  }
} else {
?>
<center><h2>Добавить сервер</h2></center>
	<form action="" method="post">
	<div class="form-group">
      <div class="col-lg-10">
        <input type="text" class="form-control" name="ip" id="ip" placeholder="Введите IP сервера">
      </div>
    </div>
	<div class="form-group">
      <div class="col-lg-10">
        <input type="text" class="form-control" name="port" id="prichina" placeholder="Введите порт сервера">
      </div>
    </div>
	<ul class="pager">
	<li class="previous"><a href="javascript:history.go(-1)" mce_href="javascript:history.go(-1)">< Назад</a></li>
	</ul>
	<center><input type="submit" name="new_server" value="Добавить" class="btn btn-primary"></center></form>
	<?
		if(isset($_POST['new_server'])) {
		if($_POST["ip"] === "") {unset($_POST["ip"]);} else {$ip = $_POST['ip'];}
		if($_POST["port"] === "") {unset($_POST["port"]);} else {$port = $_POST['port'];}
		if(isset($ip) and isset($port)) {
		$server_info = CSMonitoring::getServerInfo( $ip, $port, $error );
		$name = $server_info["nh"];
		$req2=mysql_query("SELECT * FROM server WHERE ip='$ip' and port='$port'");
		if(mysql_num_rows($req2)>0) { 
		
		 echo '<div class="alert alert-dismissable alert-info">
					<button type="button" class="close" data-dismiss="alert">?</button>
					'.$ip.':'.$port.' уже находится в базе данных!
					</div>';
		
	} else {	
			$result3 = mysql_query ("INSERT INTO server (name,ip,port) VALUES ('$name','$ip','$port')");
		if($result3 == 'true')  {
			  echo '<div class="alert alert-dismissable alert-success">
					<button type="button" class="close" data-dismiss="alert">?</button>
					'.$name.' добавлен в базу данных!
					</div>
					<script>
							function GoNah(){ 
						location="./?go=server"; 
						} 
						setTimeout( "GoNah()", 2000 );
						</script>'; 
			  }
			  else {echo '<div class="alert alert-dismissable alert-danger">
						  <button type="button" class="close" data-dismiss="alert">?</button>
						  <strong>Не добавлено!</strong> Вы где-то ошиблись.
						  </div>';}}
	} else { echo '<div class="alert alert-dismissable alert-danger">
						  <button type="button" class="close" data-dismiss="alert">?</button>
						  <strong>Внимание!</strong> Вы не всё ввели.
						  </div>';}
	
	}
	}
	} else {
	
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