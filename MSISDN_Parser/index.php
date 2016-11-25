<?php
include_once 'DataReader.php';
include_once 'MSISDNParser.php';
?>

<html>
<body>

<h1>MSISDN Parser</h1>
<p/>
    <div>
        <form method ="post">
	        MSISDN number: <input name ="msisdn" title ="Input number" /><input type="submit" value="Parse"/>
	    </form>
    </div>

    <div>
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if(!empty($_POST["msisdn"])){

                $parser = new MSISDNParser();
                $result = $parser->getData($_POST["msisdn"]);
                var_dump($result);
            }
        }
        ?>


    </div>
</body>
</html>