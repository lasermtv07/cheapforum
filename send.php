<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sending</title>
</head>
<body>
    <script>window.location='index.php?c=<?php $cathegory= $_POST["cathegory"]; echo $cathegory;?>';</script>
    <?php
	ini_set('display_errors', 1);
        $count=fopen('last.txt', 'r+');
        $s_name= $_POST["name"];
        $s_msg= $_POST["msg"];
        echo "<script>alert($cathegory)</script>";
        $id=intval(fread($count, filesize('last.txt')))+1;

        $i_img="none";

        if(isset($_FILES["img"]) && $_FILES["img"]["error"] == UPLOAD_ERR_OK && exif_imagetype($_FILES["img"]["tmp_name"])){
            move_uploaded_file($_FILES["img"]["tmp_name"],"uploads/post".$id.".".pathinfo($_FILES["img"]["name"], PATHINFO_EXTENSION));
            $i_img="uploads/post".$id.".".pathinfo($_FILES["img"]["name"], PATHINFO_EXTENSION);
        }
        echo $_FILES["img"]["error"];
        //echo "<script> alert('$id');</script>";
        if($s_name=="") $s_name="Anonymous";
        $db=new SQLite3('dev.db');
        $records = $db->querySingle('SELECT COUNT(*) from main');
        
        $i_date=date("Y-m-d H:i:s");
        $i_cathegory=$db->escapeString(htmlspecialchars($cathegory));
        $i_author=$db->escapeString(htmlspecialchars($s_name));
        $i_content=$db->escapeString(htmlspecialchars($s_msg));

        if($s_msg!="")$db-> query("INSERT INTO main (id, r_date, cathegory, author, content, img) VALUES ($id, '$i_date', '$i_cathegory', '$i_author', '$i_content', '$i_img');");
        
        rewind($count);
        fwrite($count, $id);
        fclose($count);
        echo "redirecting back..";
    ?>
</body>
</html>

