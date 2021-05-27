<html>
 <head>
     <title>Jinx's Wormhole Buyback</title>
     <center>
       <h1>Jinx's Wormhole Buyback</h1>  
     </center>
  
 
  
  
 </head>
 <style type="text/css">
 
  body {background-color: black; background-repeat: no-repeat; background-position: center center; background-size: contain; background-attachment: fixed;}
  table, th, td {
    width:600px;  
    border: 1px solid white;
    border-collapse: collapse;
    text-align: center;
    
  }
</style>
<script src="sorttable.js"></script>
 <body text="white"; background="12 - lQxQbbM.jpg">
     <br>
<form action="jinx.php" method="post">
    <br>
    Evepraisal Link: <textarea name="itemName" rows="1" cols="40"></textarea>
    <input type = "submit" value="Appraise">
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
    //echo "---------------------------------"."<br>";
    $itemNames = $_POST["itemName"].".json";
    echo $_POST["itemName"]."<br>";
    $ch = curl_init($itemNames);                                                                      
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_POSTREDIR, 3);                                                                  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                 
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // follow http 3xx redirects
    $curlExec = curl_exec($ch); // execute    
    
    $jsonDecode = json_decode($curlExec, true);
    $servername = "[redacted]";
    $username = "[redacted]";
    $password = "[redacted]";
    $dbname = "[redacted]";
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    $Total = 0;
    $length = count($jsonDecode["items"]);
    echo "<table style='align' = 'center' width:90% class = 'sortable'>";
    //echo "<table class='sortable'>";
        echo "<tr>";
            echo "<th>Quantity</th>";
            echo "<th>Name</th>";
            echo "<th>Jita Buy Single</th>";
            echo "<th>Jinx Buy Stack</th>";            
            echo "<th>Rate</th>"; 
        echo "</tr>";
    
    for ($i = 0; $i < $length; $i++){
        try{
            $name =  print_r($jsonDecode["items"][$i]["typeName"],true);
            $jitaBuy = $jsonDecode["items"][$i]["prices"]["buy"]["max"];
            $quantity = $jsonDecode["items"][$i]["quantity"];
            $rate = $conn->query("SELECT Rate from `JinxWormhole` WHERE Name = \"$name\"");
            $store = print_r(mysqli_fetch_row($rate)["0"], true);
            print_r(mysqli_fetch_row($rate)["0"]);
            if(empty($store)){
                $store = 0;
            }
            $jinxBuy = ($jitaBuy * ($store/100));
            echo "<tr>";
                echo "<td>".$quantity."</td>";
                echo "<td>".$name."</td>";
                echo "<td>".number_format($jitaBuy,2)."</td>";
                echo "<td>".number_format($jinxBuy*$quantity,2)."</td>";
                echo "<td>".$store."%"."</td>";
            echo "</tr>";

            $Total = $Total + (($jsonDecode["items"][$i]["prices"]["buy"]["max"])*($store/100)*$quantity);
            
        }catch(Exception $e){
            break;
        }
        
    }
    echo "</table>";
    echo "<br>";
    echo "Jita buy: ".number_format($jsonDecode["totals"]["buy"],2)."<br>";
    echo "Jinx will pay: ".number_format($Total,2);
    /*foreach($jsonDecode->items as $mydata){
        echo $mydata->name;
        //echo ($jsonDecode["items"][$value]["typeName"])."<br>";    
    }*\
    
    $result = printValues($jsonDecode);
    $jitaSell = round($jsonDecode["totals"]["sell"], -6);
    $collateral = round($jsonDecode["totals"]["sell"], -6)*1.1;
    $jitaToMendori = (round($jsonDecode["totals"]["sell"], -6)*1.1*18)/1000;

    
    
    

?>

 </body>
 
</html>