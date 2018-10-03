<?php

//phpとMysqlの連携 データベースへの接続

$dsn = 'mysql:dbname=tt_317_99sv_coco_com;host=localhost';
$user = 'tt-317.99sv-coco';
$password = 'Ed8LC5wU';
$pdo = new PDO($dsn,$user,$password);

//テーブル作成
$sql= "CREATE TABLE mission4"
." ("
. "id INT,"
. "name char(32),"
. "comment TEXT,"
. "password TEXT"
.");";
$stmt = $pdo->query($sql);


if($_POST["editnum"] != ""){
	$editnum = (int) $_POST["editnum"];
	$editpassword = $_POST["pass"];

	$sql = 'SELECT * FROM mission4';
	$results = $pdo -> query($sql);
	foreach ($results as $row){
	
		if($editnum == $row['id']){
			$number = $row['id'];
			$namedef = $row['name'];
			$commentdef = $row['comment'];
		}

	}

}

?>

<html>
  <form action=" " method="post">
    <input type="text" name="name" placeholder="名前" value="<?php echo $namedef; ?>" >
    <br>
    <input type="text" name="comment" placeholder="コメント" value="<?php echo  $commentdef; ?>">
    <br>
    <input type="text" name="password" placeholder="パスワード">
    <br>
    <input type="submit" value="投稿"><br>
    <input type="hidden" name="number" value="<?php echo  $editnum; ?>">
    <input type="hidden" name="editpass" value="<?php echo  $editpassword; ?>">

    <input type="text" name="delete" placeholder="削除対象番号"><br>
    <input type="text" name="passdel" placeholder="パスワード"><br>
    <input type="submit" value="削除"><br>

    <input type="text" name="editnum" placeholder="編集対象番号"><br>
    <input type="text" name="pass" placeholder="パスワード"><br>
    <input type="submit" value="編集"><br>
  
  </form>
</html>


<?php

$inpass = $_POST["editpass"];
$editpassword = $_POST["pass"];

$sql = 'SELECT * FROM mission4 order by id';//order by idはなくても良い
$results = $pdo -> query($sql);
$results->execute();
$cnt = $results->rowCount();

//3-5 insertを行って、データを入力

if($_POST["name"] != "" && $_POST["comment"] != ""){

	if($_POST["number"] != ""){//編集

		$id = (int) $_POST["number"];
		$nm =  $_POST["name"];
		$kome =  $_POST["comment"];
		$epass = $_POST["password"];
		$sql = "update mission4 set name='$nm', comment='$kome', password='$epass' where id='$id' and password='$inpass'";
		$result = $pdo->query($sql);
		
	}else{//書き込み

		$sql = $pdo -> prepare("INSERT INTO mission4 (id,name,comment,password) VALUES (:id, :name, :comment, :password)");
		$sql -> bindParam(':id', $id, PDO::PARAM_INT);
		$sql -> bindParam(':name', $name, PDO::PARAM_STR);
		$sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
		$sql -> bindParam(':password', $password, PDO::PARAM_STR);

		$id = "$cnt";
		$name = $_POST["name"];
		$comment = $_POST["comment"];
		$password = $_POST["password"];

		$sql -> execute();
		
	}

}


if($_POST["delete"] != ""){//削除
	$id = (int) $_POST["delete"];
	$inpassdel = $_POST["passdel"];
	$sql = "delete from mission4 where id='$id' and password='$inpassdel'";
	$result = $pdo->query($sql);
	
}

//3-6 入力したデータをselectによって表示する

$sql = 'SELECT * FROM mission4 order by id';
$results = $pdo -> query($sql);
foreach ($results as $row){
//$rowの中にはテーブルのカラム名が入る
	echo $row['id'].',';
	echo $row['name'].',';
	echo $row['comment'].'<br>';
}

?>
