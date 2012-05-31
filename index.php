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
$concatstring=  fread($fh, filesize($myFile));

echo "from file:  $concatstring";


$myFile = "testFile.txt";
$fh = fopen($myFile, 'a');
fwrite($fh, $concatstring);
fclose($fh);

$r = new HttpRequest('http://jeremychallenge.crisply.com/timesheet/api/activity_items.xml', HttpRequest::METH_POST);

//commented test, creates loop with own site, but the testFile shows that it does in fact post the data.
//$r = new HttpRequest('http://webdev.evolvesoftware.cc', HttpRequest::METH_POST);
$r->setOptions(array('cookies' => array('lang' => 'de')));

//add authentication key from crispley, guid, and descriptive text
//$r->addPostFields(array('key' => 'xrpwXOK9Fr4yKBH1jIk', 'guid' => 'post-activity-1322526872.80136-11155634485294814317', 'text' => '$text' ));
$r->addPostFields(array('payload' => '$concatstring' ));

//$r->addPostFields(array('user' => 'xrpwXOK9Fr4yKBH1jIk', 'pass' => 'anything'));
//$r->addPostFile($concatstring, 'webhook.xml', 'application/xml');


try {
    echo $r->send()->getBody();//send http request
} catch (HttpException $ex) {
    echo $ex;
}


 ?>

</html>
