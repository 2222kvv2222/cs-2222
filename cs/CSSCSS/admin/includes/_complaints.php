<?

if(isset($_POST['del']))
    {
    $id=$_POST['u'];
    mysql_query("DELETE FROM `complaints` WHERE `id` = '$id'");    
    }

	if(isset($_GET[view])){
		
		$id = $_GET["view"];


mysql_query("UPDATE complaints SET view='1' WHERE id='$id'");
$result = mysql_query("SELECT * FROM complaints WHERE id='$id'");
$myrow = mysql_fetch_array($result);
?>

<center><legend>Жалоба №<? echo $myrow["id"];?> </legend></center>

<ul class="pager">
  <li class="previous"><a href="javascript:history.go(-1)" mce_href="javascript:history.go(-1)">← Назад</a></li>
</ul>
<table class="table table-striped table-hover ">

			<tr><td>Ник админа:</td><td><? echo $myrow["nick"];?></td></tr>
			<tr><td>Причина:</td><td><? echo $myrow["prichina"];?></td></tr>
			<tr><td>Контакты:</td><td><? echo $myrow["contacts"];?></td></tr>
			<tr><td>Жалоба создана:</td><td><? echo $myrow["date"];?></td></tr></table> <?
		
	}else{
	
	$req=mysql_query("SELECT * FROM complaints");
if(mysql_num_rows($req)>0) { 
  $result = mysql_query("SELECT * FROM complaints ORDER BY view");
$myrow = mysql_fetch_array($result);

?>
<h2><center>Жалобы на админов</h2></center>
<table class="table table-striped"> <thead><th>Ник админа</th><th>Причина</th><th>Статус</th><th>IP</th><th>Действие</th></thead><tbody>

<?
do{
if($myrow["view"] === "0") {$b = "Не просмотрена"; $b1 = "class='active'";} if($myrow["view"] === "1") {$b = "Просмотрена"; $b1 = "class='success'";}
printf ("<tr $b1 >
		 <form action='' method='post'>
		 <input type='hidden' name='u' value='".$myrow[id]."'>
		 <td>%s</td>
		 <td>%s</td>
		 <td>%s</td>
		 <td>%s</td>
		 <td><div class='btn-group'>
			 <a href='#' class='btn btn-default dropdown-toggle' data-toggle='dropdown' aria-expanded='false'>Действие  <span class='caret'></span></a>
			 <ul class='dropdown-menu'>
			 <li><a href='./?go=complaints&view=%s'>Просмотр</a></li>
			 <li>&nbsp;&nbsp;<input type='submit' value='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Удалить&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' name='del' class='btn btn-default'></li>
			 </ul>
			 </div></td>
		 </form></tr>", $myrow["nick"],$myrow["prichina"],$b,$myrow["ip"],$myrow["id"]);
}
while($myrow = mysql_fetch_array($result));
	
  echo "</tbody>
</table>";
  }
else {
	echo '<br><br><div class="panel panel-info">
  <div class="panel-heading">
    <h3 class="panel-info">Внимание!</h3>
  </div>
  <div class="panel-body">
    В базе данных пока нету никаких записей!
  </div>
</div>';
	}}?>
                                       
	 