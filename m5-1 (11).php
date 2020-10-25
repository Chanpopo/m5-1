<!DOCTYPE html>
<html lang="ja">
    <head>
    <meta charset="UTF-8">
    <title>mission_5-1</title>
</head>

<body>

<?php
// DB接続設定
	$dsn = 'データベース名';
	$user = 'ユーザー名';
	$password = 'パスワード';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	
#    $sql = "CREATE TABLE IF NOT EXISTS mission5_1"
#    ." ("
#    . "id INT AUTO_INCREMENT PRIMARY KEY,"
#    . "time TEXT,"
#    . "name TEXT,"
#    . "comment TEXT,"
#    . "dpass TEXT"
#    . ");";
#    $stmt = $pdo->query($sql);

    if(isset($_POST["edit2"])  and (isset($_POST["editpass"]))){
      if (strlen($_POST["edit2"])!=0 and strlen($_POST["editpass"])!=0) { 
        $sql = 'SELECT * FROM mission5_1';
        $stmt = $pdo->query($sql);
    	$results = $stmt->fetchAll();
	   foreach ($results as $row){
	       if($row["id"]==$_POST["edit2"]){
	           if($row["dpass"]==$_POST["editpass"]){
		$name=$row["name"];
		$comment=$row["comment"];
		$edit1=$row["id"];
		$pass0=$row["dpass"];
        }
	       }
	   }
       }
    }
?>
    
    <form action="" method="post">
        <input type="text" name="name" placeholder="名前" value="<?php if(!empty($name)) {echo $name;} ?>"><br>
        <input type="text" name="comment" placeholder="コメント" value="<?php if(!empty($comment)) {echo $comment;} ?>"><br>
        <input type="hidden" name="edit1" placeholder="編集中番号" value="<?php if(!empty($edit1)) {echo $edit1;} ?>">
        <input type="text" name="pass" placeholder="パスワード" value="<?php if(isset($pass)) {echo $pass;} ?>">
        <input type="hidden" name="pass0" placeholder="編集対象パスワード表示" value="<?php if(isset($pass0)) {echo $pass0;} ?>">
        <input type="submit" name="submit" value="送信"><br><br>
        <input type="number" name="delete" placeholder="削除対象番号"><br>
        <input type="text" name="dpass" placeholder="パスワード">
        <input type="submit" name="submit2" value="削除"><br><br>
        <input type="number" name="edit2" placeholder="編集対象番号"><br>
        <input type="text" name="editpass" placeholder="パスワード">
        <input type="submit" name="submit3" value="編集">
    </form>
    
<?php
    if(isset($_POST["name"]) and isset($_POST["comment"]) and !empty($_POST["pass"]) and strlen($_POST["delete"])==0 and strlen($_POST["edit1"])==0){
        if(strlen($_POST["name"])!=0 and strlen($_POST["comment"])!=0 and strlen($_POST["pass"])!=0){
        $name=$_POST["name"];
        $comment=$_POST["comment"];
        $pass=$_POST["pass"];
        $date=date("Y/m/d H:i:s");
        $str=$name.$comment;
            if(strlen($edit1==0)){
            $edit1=$_POST["edit1"];
            $sql = $pdo -> prepare("INSERT INTO mission5_1 (name, comment, time, dpass) VALUES (:name, :comment, :time, :dpass)");
            $sql -> bindParam(':time', $time, PDO::PARAM_INT);
	        $sql -> bindParam(':name', $name, PDO::PARAM_STR);
	        $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
	        $sql -> bindParam(':dpass', $dpass, PDO::PARAM_INT);
	        $time = " ".$date;
            $name = " ".$name;
	        $comment = " ".$comment;
	        $dpass = " ".$pass;
	        $sql -> execute();
        echo "";
    }
    else{
        $id = $_POST["edit1"]; //変更する投稿番号
	    $name = $_POST["name"];
	    $comment = $_POST["comment"]; 
	    $time = " ".$date;
	    $dpass = $_POST["pass0"];
	    $sql = 'UPDATE mission5_1 SET name=:name,comment=:comment,time=:time,dpass=:dpass WHERE id=:id';
	    $stmt = $pdo->prepare($sql);
	    $stmt->bindParam(':name', $name, PDO::PARAM_STR);
	    $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
	    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
	    $stmt->bindParam(':time', $time, PDO::PARAM_INT);
	    $stmt->bindParam(':dpass', $dpass, PDO::PARAM_INT);
	    $stmt->execute();
	    
#	    $sql = 'SELECT * FROM mission5_1';
#    	$stmt = $pdo->query($sql);
#	    $results = $stmt->fetchAll();
#	        foreach ($results as $row){
#		echo $row['id'].',';
#        echo $row['time'].',';
#        echo $row['name'].',';
#        echo $row['comment']."<br>";
#        echo"<hr>";
#	}
        	}
        }
    }
    
    if (!empty($_POST["delete"]) and  !empty($_POST["dpass"]) and strlen($_POST["name"])==0 and strlen($_POST["comment"])==0 and strlen($_POST["edit2"])==0) {

        $dpass = $_POST["dpass"];
        $delete = $_POST["delete"];
#            $sql = 'SELECT * FROM mission5_1';
#	        $stmt = $pdo->query($sql);
#        	$results = $stmt->fetchAll();
#        	foreach ($results as $row){
#        	    if($row["id"]==$_POST["delete"]){
#        	        if($row["dpass"]==$_POST["dpass"]){
        	$id = $_POST["delete"];            
	        $sql = 'delete from mission5_1 where id=:id';
	        $stmt = $pdo->prepare($sql);
	        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
	        $stmt->execute();
        	        }
#       	    }
#      	}
#        }
        	        
	$sql = 'SELECT * FROM mission5_1';
    	$stmt = $pdo->query($sql);
	    $results = $stmt->fetchAll();
	        foreach ($results as $row){
		    echo $row['id'].',';
            echo $row['time'].',';
            echo $row['name'].',';
            echo $row['comment']."<br>";
            echo"<hr>";
   	}
        
?>

</body>
</html>