<?php
include_once 'DataReader.php';
include_once 'MSISDNParser.php';

/*
$g = new MSISDNParser();
if($g===false)
{
    echo("štala");
}
else
{
    var_dump($g->getData("+38641810042"));
}

*/

$client = new JsonRpc('http://localhost/MSISDNParser/MSISDNParser/MSISDN_Parser/');
$result = $client->getData('+38641810042'); // returns 4

var_dump($result);
    /*
$g = new MSISDNParser("+38641810042789");
if($g===false)
{
    echo("štala");
}
else
{
    var_dump($g);
}
*/
?>

<html>
<body>

<h1>MSISDN Parser</h1>
<p/>
    <div>
        <form method ="post">
	        MSISDN number: <input name ="msisdn" title ="Input number" /><input type="submit" value="Send"/>
	    </form>
    </div>
    <div>



    </div>
</body>
</html>