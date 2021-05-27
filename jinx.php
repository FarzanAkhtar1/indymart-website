<!DOCTYPE HTML>
<!--
	Industrious by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<html>
	<head>
		<title>Indymart - Jinx's Buyback</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		<link rel="stylesheet" href="assets/css/main.css" />
	</head>
	<body class="is-preload">

		<!-- Header -->
			<header id="header">
				<a class="logo" href="index.php">Indymart</a>
				<nav>
					<a href="#menu">Menu</a>
				</nav>
			</header>

		<!-- Nav -->
			<nav id="menu">
				<ul class="links">
					<li><a href="index.php">Home</a></li>
					<li><a href="procurement.php">Procurement</a></li>
					<li><a href="cyno.php">Cynos'R'Us</a></li>
					<li><a href="explobuyback.php">Indybro's Exploration Buyback</a></li>
					<li><a href="jinx.php">Jinx's Wormhole Buyback</a></li>
					<li><a href="piratebuyback.php">Overseer Jolly's Pirate Buyback</a></li>
				</ul>
			</nav>

		<!-- Banner -->
			<section id="banner">
				<div class="inner">
					<h1><a href="jinx.php">Jinx's Wormhole Buyback</a></h1>
					<p>Offload your hole</p>
				</div>

			</section>

		<!-- Highlights -->
			<section class="wrapper">
				<div class="inner">
					<header class="special">
						<h2>How to use</h2>
						<p>Input an evepraisal link into the box. Press the button to generate your quote. Create the contract in-game to "bjinx"</p>
					</header>
					
								<form action="jinx.php" method="post">
                                <div class="row gtr-uniform">
											<div class="col-6 col-12-xsmall">
												<input type="text" name="itemName" id="itemName" value="" placeholder="Evepraisal" />
											<div class="col-12">
											<ul class="actions">
													<li><input type="submit" value="Appraise" class="primary" /></li>
													</ul>	
											
											</div></div>								    

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
    echo "Evepraisal: ".$_POST["itemName"]."<br>";
    echo "Jita buy: ".number_format($jsonDecode["totals"]["buy"],2)."<br>";
    echo "Jinx will pay: ".number_format($Total,2);
    

    
    
    

?>
</div>
                                            </center>
                                            


                               
											

				
			</section>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>