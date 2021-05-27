<html>
 <head>
     <title>Indymart</title>
     <center>
       <h1>Welcome to Indymart - Home of all your logistic services</h1>  
     </center>
  
  <h2>Instructions for use:<br></h2>
  <b2>1. Enter an evepraisal link<br></b2>
  <b2>2. Press submit<br></b2>
  <b2>3. Copy the text below the dashed line<br></b2>
  <b2>4. Send a slack PM to Indybro and mention where you want the items delivered.<br>If your preferred delivery location is not listed please let me know and I can consider options to include it.<br></b2>
  <b2>Delivery to GE usually takes 24-36 hours from order confirmation but I aim to deliver within 24 hours. Delivery to other places may take longer.<br></b2>
  <b2>I use various 3rd parties to carry out my services, these include but are not limited to: public couriers, BLT and TEST hauling services. </b2>
  <br>
  <b3>Due to market fluctuations, the price at delivery may differ from the quote.<br>If there is a significant change (5%+) I will notify you before carrying out any purchases. All orders are subject to a minimum total pricing of 5,000,000 isk.</b3>
  
  
 </head>
 <body>
     <br>
<form action="index.php" method="post">
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
    $jitaSell = round($jsonDecode["totals"]["sell"], -6);
    $collateral = round($jsonDecode["totals"]["sell"], -6)*1.1;
    $jitaToMendori = (round($jsonDecode["totals"]["sell"], -6)*1.1*18)/1000;
    $volume = round($jsonDecode["totals"]["volume"],2);
    $volumeRatio = round(round($jsonDecode["totals"]["volume"],2)/320000,2);
    $collatRatio = round($collateral/3000000000,2);
    $max = max($volumeRatio, $collatRatio);
    $mendoriToGE = 158240000 * $max;
    $mendoriToPZMA  = 267360000 * $max;
    $mendoriToLtack5 = 202240000 * $max;
    $jitaToQLPX = round( ($jitaSell + ($volume * 900) + 500000.01 + ($collateral/100))*1.01,-6);
    $toGE = "Total to GE: ~".number_format(max(round(($jitaSell + $jitaToMendori + $mendoriToGE+500000.001)*1.01,-6), 5000000.01))."<br>";
    $toPZ = "Total to PZMA: ~".number_format(max(round(($jitaSell + $jitaToMendori + $mendoriToPZMA+500000.001)*1.01,-6), 5000000.01))."<br>";
    $toQLPX = "Total to QLPX-J: ~".number_format(max($jitaToQLPX,5000000.01))."<br>";
    //$toLtack5 = "Total to L-5: ~".number_format(max(round(($jitaSell + $jitaToMendori + $mendoriToLtack5+500000.001)*1.01,-6), 5000000))."<br>";
    
    
    $modifiedVolumeRatio = round(round($jsonDecode["totals"]["volume"],2)/60000,2);
    $modifiedCollatRatio = round($collateral/1000000000,2);
    $modifiedJitaToMendori = max($modifiedVolumeRatio, $modifiedCollatRatio)*1000000*18;
    $modifiedTotalToGE = max(round(($jitaSell + $modifiedJitaToMendori + $mendoriToGE + 500000.001)*1.01,-6),500000);
    $modifiedTotalToPZMA = max(round(($jitaSell + $modifiedJitaToMendori + $mendoriToPZMA + 500000.001)*1.01,-6),500000);
    
    
    $bigString = $_POST["itemName"]."<br>".$toGE.$toPZ.$toLtack5;
    echo "Jita Sell: ".number_format($jitaSell)."<br>";
    echo $toGE;
    echo $toPZ;
    echo $toQLPX;
    //echo $toLtack5;
    /*
    echo "New Test price to GE: ~".number_format($modifiedTotalToGE)."<br>";
    echo "New Test price to PZMA: ~".number_format($modifiedTotalToPZMA)."<br>";
    echo "<br>"."<br>";
    */
    
    
    

?>

 </body>
 
</html>