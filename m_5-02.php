<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>mission_5-01</title>
</head>
<body>
    <?php
    $dsn = 'データベース名';
    $user = 'ユーザー名';
    $password = 'パスワード';
    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
    $sql = "CREATE TABLE IF NOT EXISTS m5_1"
    ." ("
    . "id INT AUTO_INCREMENT PRIMARY KEY,"
    . "name char(32),"
    . "comment TEXT,"
    . "date TEXT,"
    . "pass TEXT,"
    . "pass1 TEXT,"
    . "pass2 TEXT"
    .");";
    $stmt = $pdo->query($sql);
    if(!empty($_POST["name"]) && !empty($_POST["txt"])){
        if(!empty($_POST["pass"]))
    if(is_numeric($_POST["num"])){
        //編集モード
        $id = $_POST["num"];
        $name = $_POST["name"];
        $comment = $_POST["txt"];
        $date = date("Y/m/d H:i:s");
        $pass = $_POST["pass"];
        $sql = 'UPDATE m5_1 SET name=:name,comment=:comment,date=:date,pass=:pass WHERE id=:id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':comment', $comment, PDO::PARAM_STR);
        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
        $stmt->bindParam(':pass', $pass, PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        
        $stmt->execute();
    }else{
        $sql = $pdo -> prepare("INSERT INTO m5_1 (name, comment, date, pass) VALUES (:name, :comment, :date, :pass)");
        $sql -> bindParam(':name', $name, PDO::PARAM_STR);
        $sql -> bindParam(':comment', $comment, PDO::PARAM_STR);
        $sql -> bindParam(':date', $date, PDO::PARAM_STR);
        $sql -> bindParam(':pass', $pass, PDO::PARAM_STR);
        $name = $_POST["name"];
        $comment = $_POST["txt"];
        $date = date("Y/m/d H:i:s");
        $pass = $_POST["pass"];
        $sql -> execute();
    }
    }elseif(!empty($_POST["del"]) && !empty($_POST["pass1"])){
        //削除機能
        $sql = 'SELECT * FROM m5_1';
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        foreach ($results as $row){
            if($row[4] == $_POST["pass1"]){
            $id = $_POST["del"];
            $sql = 'delete from m5_1 where id=:id';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            }
        }
    }elseif(!empty($_POST["edi"])){
        if(!empty($_POST["pass2"]))
        $sql = 'SELECT * FROM m5_1';
        $stmt = $pdo->query($sql);
        $results = $stmt->fetchAll();
        foreach ($results as $row){
            if($row[0] == $_POST["edi"] && $row[4] == $_POST["pass2"]){
                $ar = $row;
                echo "編集中";
            }
        }
    }
    ?>
    <form action="" method="post">
        <input type="text" name="name" value="<?php if(!empty($ar)){echo $ar[1];}?>" placeholder="名前"><br>
        <input type="text" name="txt" value="<?php if(!empty($ar)){echo $ar[2];}?>" placeholder="コメント"><br>
        <input type="text" name="pass" value="<?php if(!empty($ar)){echo $ar[4];}?>" placeholder="パスワード">
        <input type="submit" name="submit"><br>
        <input type="hidden" name="num" value="<?php echo $ar[0]?>">
        <br>
        <input type="number" name="del" placeholder="削除対象番号"><br>
        <input type="text" name="pass1" placeholder="パスワード">
        <input type="submit" name="submit" value="削除">
        <br><br>
        <input type="number" name="edi" placeholder="編集対象番号"><br>
        <input type="text" name="pass2" placeholder="パスワード">
        <input type="submit" name="submit" value="編集">
    </form>
    <?php
    $sql = 'SELECT * FROM m5_1';
    $stmt = $pdo->query($sql);
    $results = $stmt->fetchAll();
    foreach ($results as $row){
        echo $row[0].' ';
        echo $row[1].' ';
        echo $row[2].' ';
        echo $row[3].'<br>';
    echo "<hr>";
    }
    ?>
</body>
</html>