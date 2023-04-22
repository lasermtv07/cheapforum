<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cheapforum DEV</title>
    <style>
        body {
            background-color: beige;
        }
        .wrapper{
            background: white;
            width: 50%;
            position:absolute;
            left:50%;
            transform: translate(-50%,-2%);
            border: 2px solid black;
            padding: 20px;
        }
        textarea, .logo, h1 {
            width: 100%;
	}
	.warning {border: 2px solid red; color: red;}
	.warning div {
		background-color: red; color: white;
	}
	.ok {border: 2px solid green; color: green;}
	.ok div { background-color: green; color: white;}
    .i {
        font-size:0.8em;
        color: gray;
    }
    .nav a {
        text-decoration: none;
        color: white;
    }
    .nav{
        margin-top: 0;
        background-color: blue;
    }
    .userimg {
        max-width:128px;
        max-height:171px;
    }
    </style>
</head>
<body>
    <div class="wrapper">
        <img src="logo.png" alt="logo" class=logo>
        <hr/>
	<h1>cheapforum.com - posts</h1>
	<i>DEV version</i><br><br>
    <hr/>
    <div class=nav><a href="?c=misc">Miscellanious</a> &nbsp;&nbsp;<a href="?c=dev">cheapforums community</a> &nbsp;&nbsp;<a href="?c=lang">Program. Langs</a> &nbsp;&nbsp;<a href="?c=hist">History</a> &nbsp;&nbsp;<a href="?c=tech">Tech / General</a> &nbsp;&nbsp;<a href="?c=vid">Videos/YT</a> &nbsp;&nbsp;<a href="?c=cz">CZ/cs</a></div>
    <form action="send.php" method="post" enctype="multipart/form-data">
        <b>Name: </b><input type="text" name="name" id=""><br>
        <b>Message: </b><br><textarea name="msg" id="" cols="80" rows="5"></textarea><br/>
        <input type="hidden" name="cathegory" value="<?php 
        $cathegory=$_GET["c"] ?? "misc";
        echo $cathegory;?>">
        <b>Image: </b><input type="file" name="img" id=""><br/>
        <input type="submit" value="Send">
    </form>
    <?php
	ini_set('display_errors', 1);
	$pinfile=fopen('pin.txt', 'r');
    
	$pin=intval(fread($pinfile, filesize('pin.txt')));
	echo $cathegory;
        $db=new SQLite3('dev.db');
        $records = $db->querySingle('SELECT COUNT(*) from main');
	$results = $db->query('SELECT * FROM main ORDER BY r_date DESC;');
	$pin=$db->query("SELECT * FROM main WHERE id == '$pin'")->fetchArray();
        if($pin)echo '<br><div style="border:2px solid orange"><div style="background-color: orange; color: white;">Pinned</div><b>'. $pin["author"]."</b> - <i>".$pin["id"]."</i><br>".$pin["content"]."</div>";
        while($row=$results->fetchArray()){
            if($cathegory==$row["cathegory"]){
                echo "<hr/><b>".$row["author"]."</b><br/>";
                echo "<i>".$row["id"]. " - ". date("d/m/y H:m",strtotime($row["r_date"])). "</i><br/>";
                echo $row["content"];
                if($row["img"]!= "none") {echo "<h4> assets </h4>";
                echo '<img src="'.$row["img"].'" alt="" class=userimg>';}
            }
        }
        unset($_POST);
    ?>
    </div>
</body>
</html>

