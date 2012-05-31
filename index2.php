<html><body><h3>This is a test!</h3></body>


<?php
//$db=mysql_connect ("localhost") or die(mysql_error());
 //mysql_select_db ("dbname"); //You'll need this to see what input the github page sends you

 $myFile = "testFile.txt";
$fh = fopen($myFile, 'w');

$postdata= $_REQUEST;
 $text= $_REQUEST['text'];
 $guid= $_REQUEST['guid'];
 
 //take payload from hithub, in json format
//$postdata = $_REQUEST['payload'];
 
 $concatstring=NULL;
echo "entering loop";
 foreach($postdata as $value){//put all request input into one string for tesing
  $concatstring.=$value;
 }
fwrite($fh, $concatstring);//test to check all data in request
fwrite($fh, $text);//test text value
fwrite($fh, $guid);//test guid value
 //$decoded = json_decode($concatstring); //decide json payloadfrom github
 fclose($fh);



$myFile= "/home/jeremy/webhook.xml";
$fh = fopen($myFile, 'r');
$contentlength = filesize($myFile);
$concatstring=  fread($fh, $contentlength);
$contentlength = filesize($myFile);
echo "from file:  $concatstring";


$myFile = "testFile.txt";
$fh = fopen($myFile, 'a');
fwrite($fh, $concatstring);
fclose($fh);

$postreq = "POST /timesheet/api/activity_items.xml http/1.5\r\nHost: jeremychallenge.crisply.com\r\nUser-Agent: Mozilla/4.0\r\nContent-Length: $contentlength\r\nContent-Type: application/xml\r\n\r\n$concatstring\r\n";

echo "$postreq";
$address = getHostByName(getHostName());//get IP of host server

$port = 3266;//set port
$addr = getHostByName('jeremychallenge.crisply.com');
echo "$addr";

$sock = socket_create(AF_INET, SOCK_STREAM, 0);//create socket
socket_connect($sock, $addr, 80);

$len = strlen($postreq);
socket_send($sock, $postreq, $len, 0);

socket_close($sock);

 ?>

</html>
