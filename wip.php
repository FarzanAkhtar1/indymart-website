<html>
 <head>
  <title>Indymart</title>
  <h1>Buyback calculator</h1>
  
 </head>
 <body>
     <br>
<form action="wip.php" method="post">
    <br>
    Evepraisal Link: <textarea name="itemName" rows="1" cols="40"></textarea>
    <input type = "submit">
</form>
<?php
    function printValues($arr) {
    global $count;
    global $values;
    
    // Check input is an array
    if(!is_array($arr)){
        die("Please enter an Evepraisal link above");
    }
    
    /*
    Loop through array, if value is itself an array recursively call the
    function else add the value found to the output items array,
    and increment counter by 1 for each value found
    */
    foreach($arr as $key=>$value){
        if(is_array($value)){
            printValues($value);
        } else{
            $values[] = $value;
            $count++;
        }
    }
    
    // Return total count and values found in array
    return array('total' => $count, 'values' => $values);
    }
    echo "---------------------------------"."<br>";
    $itemNames = $_POST["itemName"].".json";
    echo $_POST["itemName"]."<br>";
    $ch = curl_init($itemNames);                                                                      
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_POSTREDIR, 3);                                                                  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                 
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // follow http 3xx redirects
    $curlExec = curl_exec($ch); // execute    
    
    $jsonDecode = json_decode($curlExec, true);
    
    $result = printValues($jsonDecode);
    $jitaSell = $jsonDecode["totals"]["sell"];
    $jitaBuy = $jsonDecode["totals"]["buy"];
    echo "Jita Sell: ".number_format($jitaSell, 2)." ISK <br>";
    echo "Jita Buy: ".number_format($jitaBuy, 2)." ISK <br>";
    
    echo "<br>"."<br>";
    
    
    

?>

 </body>
 
</html>