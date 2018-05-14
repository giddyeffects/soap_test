<?php

  ini_set('display_errors', false);
  
  error_reporting(E_ALL);

  require_once('lib/nusoap.php');
  
  $error  = '';
  
  $result = array();
  
  $wsdl = "http://saf.ngrok.io/TestWebService/TestWS?wsdl";
  
  if(isset($_POST['sub'])){

    $name = trim($_POST['name']);

    if(!$name){

      $error = 'Name cannot be left blank.';
    }

    if(!$error){

        //create client object
        $client = new nusoap_client($wsdl, true);

        $err = $client->getError();

        if ($err) {

            echo '<h2>Constructor error</h2>' . $err;

            exit();
        }

        try {

            $result = $client->call('hello', array('name'=>$name));

            foreach ($result as $key => $value) {
                echo "Key1: ".$key;
                foreach ($value as $key2 => $value2) {
                    echo "Key2: ".$key2;
                    echo "Value2: <b>".$value2."</b>";
                }
            }

        } catch (Exception $e) {

        echo 'Caught Exception: ',  $e->getMessage(), "\n";
        }
    }
  }

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Hello Web Service</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.css" type="text/css" rel="stylesheet" media="all">
</head>
<body>
    <div class='row'>

        <form class="form-inline" method = 'post' name='form1'>

            <?php if($error) { ?> 

            <div class="alert alert-danger fade in">

                <a href="#" class="close" data-dismiss="alert">&times;</a>
                <strong>Error!</strong>&nbsp;<?php echo $error; ?> 

            </div>

        <?php } ?>

            <div class="form-group">

            <label for="name">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Name:</label>

            <input type="text" class="form-control" name="name" id="name" placeholder="Enter Name">

            </div>

            <button type="submit" name='sub' class="btn btn-default">Send</button>

        </form>


    </div>
</body>
</html>