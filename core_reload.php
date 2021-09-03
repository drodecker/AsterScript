<html>
<title>AsterScript</title>
<body>
Issue an AMI Asterisk script.<br>
<form action="core_reload.php" method="post">
    <input type="submit" name="reload" value="reload" onclick="reload()" />
</form>

<?php
# core_reload.php
# This forces refresh of asterisk to reload all extensions and scripts
# Note that /etc/asterisk/manager.conf needs to be edited to contain a set of confirmations for [reloaduser]
#[resetuser]
#secret=resudaoler
#read=system,call,log,verbose,command,agent,user
#write=system,call,log,verbose,command,agent,user
#deny=0.0.0.0/0.0.0.0
#permit=127.0.0.1/255.255.255.255

if($_SERVER['REQUEST_METHOD'] == "POST" and isset($_POST['reload'])) reload();
function reload() {
  $oSocket = fsockopen("127.0.0.1", 5038, $errnum, $errdesc) or die("Connection Failed");
  $line = fgets($oSocket);
  echo "<br>Open socket returned: <b> $line </b><br>";
  $cmd ="Action:Login\r\n";
  $cmd .="UserName:reloaduser\r\n";
  $cmd .="Secret:resudaoler\r\n";
  $cmd .="\r\n";
  $cmd .="Action:Command\r\n";
  $cmd .="Command:reload\r\n";
  $cmd .="\r\n";
  $cmd .="action: logoff\r\n";
  $cmd .="\r\n";

  fputs($oSocket, $cmd);
  echo "<br>Output from AMI: <br>";

  $output="";
  while (!feof($oSocket)) {
	  $output = fgets($oSocket);
	  echo "<br>$output";
		    }

  fclose($oSocket);

  echo "<br>Completed script";
}
?>
