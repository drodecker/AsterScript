<?php
# core_reload.php
# This forces refresh of asterisk to reload all extensions and scripts
# Note that /etc/asterisk/manager.conf needs to be edited to contain a set of confirmations for [resetuser]
#[resetuser]
#secret=resuteser
#read=system,call,log,verbose,command,agent,user
#write=system,call,log,verbose,command,agent,user
#deny=0.0.0.0/0.0.0.0
#permit=127.0.0.1/255.255.255.255

  $oSocket = fsockopen("127.0.0.1", 5038, $errnum, $errdesc) or die("Connection Failed");
  $line = fgets($oSocket);
  echo "<br>Open socket returned: <b> $line </b><br>";
  $cmd ="Action:Login\r\n";
  $cmd .="UserName:resetuser\r\n";
  $cmd .="Secret:resuteser\r\n";
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
?>
