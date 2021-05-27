<!DOCTYPE HTML>
<!--
	Industrious by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<html>
	<head>
		<title>Indymart - Jolly's Buyback</title>
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
					<h1><a href="piratebuyback.php">Overseer Jolly's Pirate Buyback</a></h1>
					<p>DED, Faction and ratting loot</p>
				</div>

			</section>

		<!-- Highlights -->
			<section class="wrapper">
				<div class="inner">
					<header class="special">
						<h2>How to use</h2>
						<p>Overseer Jolly's Pirate Buyback is your fast and safe source to turn your ratting loot into cash. Anomolies, combat sites, incursions, DED. If it drops from a rat, sell it here.  Simply input an evepraisal link below.  For LP sales, BPC sales, or any other questions contact @Overseer Jolly on slack.</p>
						<p>100% Jita Buy value for modules of all tiers, as well as ammo that drops from rats.  Anything that sells to NPC buy orders, including Overseer's Personal Effects and Navy Insignias sell for a fixed value, typically about 93% of the NPC price, just include them in the same evepraisal link.  Full value is available in GE-8JV - Mothership Bellicose, PZMA-E Fortress Impass, Amarr VIII (Oris) - Emperor Family Academy, as well as the active Voltron Coalition Staging keepstar.  Please reduce price by 3% for any other Brave owned structure, and 6% for structures belonging to our allies. Send contracts to Jolly Eginald.</p>

						
						
					</header>
					
								<form action="piratebuyback.php" method="post">
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
            echo "<th>Jolly Buy Single</th>";
            echo "<th>Jolly Buy Stack</th>";            
            echo "<th>Rate</th>"; 
        echo "</tr>";
    
    for ($i = 0; $i < $length; $i++){
        try{
            $name =  print_r($jsonDecode["items"][$i]["typeName"],true);
            $jitaBuy = $jsonDecode["items"][$i]["prices"]["buy"]["max"];
            $quantity = $jsonDecode["items"][$i]["quantity"];
            $rate = $conn->query("SELECT `Rate` from `Jolly` WHERE `Name` = \"$name\"");
            $store = print_r(mysqli_fetch_row($rate)["0"], true);
            $rate2 = $conn->query("SELECT `Fixed` from `Jolly` WHERE `Name` = \"$name\"");
            $store2 = print_r(mysqli_fetch_row($rate2)["0"], true);            
            if(empty($store) && empty($store2)){
                
                echo "<tr>";
                    echo "<td>".$quantity."</td>";
                    echo "<td>".$name."</td>";
                    echo "<td>".number_format($jitaBuy,2)."</td>";
                    echo "<td>".number_format(0,2)."</td>";
                    echo "<td>".number_format($store2*$quantity,2)."</td>";
                    $Total = $Total + $store2*$quantity;
                    echo "<td>0%</td>";
                echo "</tr>";  
                
            }
            elseif(empty($store)){
                
                echo "<tr>";
                    echo "<td>".$quantity."</td>";
                    echo "<td>".$name."</td>";
                    echo "<td>".number_format($jitaBuy,2)."</td>";
                    echo "<td>".number_format($store2,2)."</td>";
                    echo "<td>".number_format($store2*$quantity,2)."</td>";
                    $Total = $Total + $store2*$quantity;
                    echo "<td>".number_format((($store2/$jitaBuy)*100),2)."%</td>";
                echo "</tr>"; 
                
            }
            else{
                
                print_r(mysqli_fetch_row($rate)["0"]);
                $jinxBuy = ($jitaBuy * ($store/100));
                
                echo "<tr>";
                    echo "<td>".$quantity."</td>";
                    echo "<td>".$name."</td>";
                    echo "<td>".number_format($jitaBuy,2)."</td>";
                    echo "<td>".number_format($jitaBuy,2)."</td>";
                    echo "<td>".number_format($jinxBuy*$quantity,2)."</td>";
                    $Total = $Total + $jinxBuy*$quantity;
                    echo "<td>".number_format($store,0)."%</td>";
                echo "</tr>";
                
            }
            
            ###$Total = $Total + (($jsonDecode["items"][$i]["prices"]["buy"]["max"])*($store/100)*$quantity);
            
        }catch(Exception $e){
            break;
        }
        
    }
    echo "</table>";
    echo "<br>";
    echo "Evepraisal: ".$_POST["itemName"]."<br>";
    echo "Jita buy: ".number_format($jsonDecode["totals"]["buy"],2)."<br>";
    echo "Jolly will pay: ".number_format($Total,2)."<br>";

    
    
    

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