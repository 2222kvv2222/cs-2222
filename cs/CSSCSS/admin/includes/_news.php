<?
if(!isset($_GET['add'])){
if(isset($_POST['addto'])){
						if (isset($_POST['text'])) {$text = $_POST['text']; if ($text == '') {unset($text);}}
						if (isset($_POST['id'])) {$id = $_POST['id'];}
						if (isset($_POST['date'])) {$date = $_POST['date']; if ($date == '') {unset($date);}}
						
						if(isset($text) and isset($date))
					{
					if(mysql_query("UPDATE news SET news='$text',date='$date' WHERE id='$id'"))
                     	echo '<div class="alert alert-dismissable alert-success">
							  <button type="button" class="close" data-dismiss="alert">×</button>
							  Новость обновлена!
							</div>
							<script>
							function GoNah(){ 
						location="./?go=news"; 
						} 
						setTimeout( "GoNah()", 2000 );
						</script>';
                	else
                     	echo '<div class="alert alert-dismissable alert-danger">
							  <button type="button" class="close" data-dismiss="alert">×</button>
							  <strong>Новость НЕ обновлена!</strong>Что-то не работает.
							</div>';
					}
				else
					{
					echo	'<div class="alert alert-dismissable alert-danger">
							  <button type="button" class="close" data-dismiss="alert">×</button>
							  Содержание новости не введено. Нету данных для обновления!
							</div>';
					}
					}


if (isset($_GET['edit'])) {$id = $_GET['edit'];}
	if (!isset($id))
					{
					?>
					<form action="" method="post">  
					<?
				$resultat = mysql_query("SELECT * FROM news GROUP BY id DESC");
				$content = mysql_fetch_array($resultat);
				if (isset($_POST['id1'])) {$id = $_POST['id1'];}
	if (isset($_POST['del2'])) {
	
	if(isset($id))
				{
				if (mysql_query("DELETE FROM news WHERE id='$id'"))
                    	echo '<div class="alert alert-dismissable alert-success">
							  <button type="button" class="close" data-dismiss="alert">×</button>
							  Новость удалена! 
							</div>
							<script>
							function GoNah(){ 
						location="./?go=news"; 
						} 
						setTimeout( "GoNah()", 2000 );
						</script>';
                	else
                    	echo '<div class="alert alert-dismissable alert-danger">
							  <button type="button" class="close" data-dismiss="alert">×</button>
							  <strong>Новость НЕ удалена!</strong> Что-то не работает.
							</div>';
				}
				else
				{
				echo '<div class="alert alert-dismissable alert-danger">
					  <button type="button" class="close" data-dismiss="alert">×</button>
					  Для начала выберите новость!
					</div>';
				}
	
	}
?>
<ul class="pager">
  <li class="previous"><a href="./?go=news&add">Добавить</a></li>
</ul>
		<center><h2>Редактировать Новость</h2></center>
		<table class="table table-striped table-hover">
		<thead>
    <tr>
	  <th>Удалить</th>
      <th>Новость</th>
      <th>Дата</th>
    </tr>
  </thead>
  <tbody>
<?
				do
				{
				printf ("<tr class='active'><td><input name='id1' type='radio' value='%s' /></td><td><a href='./?go=news&edit=%s'>%s</a></td><td><span class='label label-primary'>(%s)</span></td></tr>",$content['id'],$content['id'],$content['news'],$content['date']);
				}
				while ($content = mysql_fetch_assoc($resultat));
?>
</tbody>
</table>
<input name="del2" type="submit" class="btn btn-default" value="Удалить " />
</form>
<?
					}
					else 
					{
				$resultat = mysql_query("SELECT * FROM news WHERE id=$id");
				$content = mysql_fetch_assoc($resultat);
print <<<FORM
						<center><h2>Редактировать Новость №$id</h2></center>
						<ul class="pager">
						  <li class="previous"><a href="javascript:history.go(-1)" mce_href="javascript:history.go(-1)">← Назад</a></li>
						</ul>
						<center><form id="form1" name="form1" method="post" action="">
						<div class="form-group">
						<label class="control-label" for="inputDefault">Содержание новости</label>
						<textarea name="text" class="form-control" id="inputDefault" cols="45" rows="5">$content[news]</textarea>
						</div>
              	  		<br>
						<div class="form-group">
						<label class="control-label" for="inputDefault">Дата</label>
						<input name="date" type="text" class="form-control" id="inputDefault" value="$content[date]">
						</div>
           	      		<p>
						<input name="id" type="hidden" value="$content[id]" />
           	        	<label>
           	        	&nbsp;&nbsp;&nbsp;<input type="submit" name="addto" id="addto"class="btn btn-default" value="Обновить" />
           	        	</label>
           	      		</p>
           	  			</form></center>
FORM;
					}	
						
} else {

?>
<center><h2>Добавить Новость</h2></center>
<ul class="pager">
  <li class="previous"><a href="javascript:history.go(-1)" mce_href="javascript:history.go(-1)">← Назад</a></li>
</ul>
	<form action="" method="post">
	<div class="form-group">
      <div class="col-lg-10">
        <textarea type="text" class="form-control" name="text" id="text" placeholder="" style="margin: 0px -1px 0px 0px; height: 205px; width: 425px;"></textarea>
      </div>
    </div>
	<center><input type="submit" name="new" value="Добавить" class="btn btn-primary"></center></form>
	<?
		if(isset($_POST['new'])) {
		if($_POST["text"] === "") {unset($_POST["text"]);} else {$text = $_POST['text'];}
		if(isset($text)) {
		$date = date("Y-m-d");
		$result3 = mysql_query ("INSERT INTO news (news,date) VALUES ('$text','$date')");
		if($result3 == 'true')  {
			  echo '<div class="alert alert-dismissable alert-success">
					<button type="button" class="close" data-dismiss="alert">×</button>
					Добавлено!
					</div>
					<script>
							function GoNah(){ 
						location="./?go=news"; 
						} 
						setTimeout( "GoNah()", 2000 );
						</script>'; 
			  }
			  else {echo '<div class="alert alert-dismissable alert-danger">
						  <button type="button" class="close" data-dismiss="alert">×</button>
						  <strong>Не добавлена!</strong> Вы где-то ошиблись.
						  </div>';}
	} else { echo '<div class="alert alert-dismissable alert-danger">
						  <button type="button" class="close" data-dismiss="alert">×</button>
						  <strong>Внимание!</strong> Вы не всё ввели.
						  </div>';}
	
	}
}
?>