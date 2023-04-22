<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>cheapforum - admin panel</title>
    <style>
        .warn {
            color:red;
        }
    </style>
</head>
<body>
    <h1>Admin Panel</h1>
	<h2>Remove message</h2>
    	<form action="" method="get">
        <b>Message ID to remove</b>: 
        <input type="text" name="id" id=""><br>
        <b>Password</b>: 
	<input type="password" name="pws" id=""><br>
        <input type="submit" value="Remove">
    </form>
	<h2>Pin message</h2>
	<form action="" method="get">
	<b>Message ID to pin:</b> <input type=text name=pin><br>
	<b>Password: </b> <input type=password name=pws><br> 
	<input type=submit value=Pin></form>
    <?php
    //ini_set('display_errors', 1);

$id = $_GET["id"];
$pin= $_GET["pin"];
echo $pin;
    $pw = $_GET["pws"];
    $db=new SQLite3('dev.db');
    $pass=fopen('password.txt', 'r');

    if(password_verify($pw,fread($pass, filesize('password.txt')))){
        unlink($db->querySingle("SELECT img FROM main WHERE id == $id"));
        $db->query("DELETE FROM main WHERE id == $id");
        echo $id;

	    if($pin!=""){
		    echo "hi";
		    $pfile= fopen('pin.txt','w');
		    fwrite($pfile, $pin);
		    fclose($pfile);
	    }
    }
    else if($pw != ""){
        echo '<b class=warn>error: incorrect password</b>';
    }
	fclose($pass);
    ?>
</body>
</html>
