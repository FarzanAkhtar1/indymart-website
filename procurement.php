<!DOCTYPE HTML>
<!--
	Industrious by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<html>
	<head>
		<title>Indymart - Procurement</title>
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
					<h1><a href="procurement.php">Procurement</a></h1>
					<p>Bringing Jita a little closer to home</p>
				</div>

			</section>

		<!-- Highlights -->
			<section class="wrapper">
				<div class="inner">
					<header class="special">
						<p><b>[NOTICE] - 28/11/20 - On hiatus from 30/11/2020 for the forseeable future due to irl issues</p></b>
						<b><p>Thank you all for the support over the past 2 years. Unfortunately I need to take a step back due to irl situation. I hope to be back at some point in the future. The site and calculator will remain as there are individuals who would also like to run a procurement program. Although these services may use my calculator, the services are not run by me, nor do I take responsibility for them.</p></b>
						
						<h2>How to use</h2>
						<p>Input an evepraisal link into the box. Press the button to generate your quote. Copy your quote and then send me the quote on Slack/Discord (Indybro III and Fazzy#6116 respectively, or whoever your service provider is) via private message</p>
					</header>
					
										<form method="post" action="procurement.php">
										<div class="row gtr-uniform">
											<div class="col-6 col-12-xsmall">
												<input type="text" name="evepraisal" id="evepraisal" value="" placeholder="Evepraisal" />
											<div class="col-12">
											<ul class="actions">
													<li><input type="submit" value="Submit Form" class="primary" /></li>
													</ul>	
											
											</div></div>
											
											
											
											<center>
											    
                                        <?php
    function printValues($arr) {
    global $count;
    global $values;
    
    // Check input is an array
    if(!is_array($arr)){
        echo "Please enter an evepraisal<br>";
        
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
    $evepraisals = $_POST["evepraisal"].".json";
    echo $_POST["evepraisal"]."<br>";
    $ch = curl_init($evepraisals);                                                                      
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
    curl_setopt($ch, CURLOPT_POSTREDIR, 3);                                                                  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                 
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // follow http 3xx redirects
    $curlExec = curl_exec($ch); // execute    
    
    $jsonDecode = json_decode($curlExec, true);
    
    $result = printValues($jsonDecode);

    $jitaSell = round($jsonDecode["totals"]["sell"]+500000.01, -6);
    $collateral = round($jsonDecode["totals"]["sell"], -6)*1.1;
    $jitaToMendori = (collateral*45)/1000;
    $volume = round($jsonDecode["totals"]["volume"],2);
    $volumeRatio = round(round($jsonDecode["totals"]["volume"],2)/320000,2);
    $collatRatio = round($collateral/3000000000,2);
    $max = max($volumeRatio, $collatRatio);
    $mendoriToGE = 164240000 * $max;
    $mendoriToPZMA  = 279360000 * $max;
    ##$mendoriToFAT = 261440000 * $max;
    ##$GEToFAT = 95360000 * $max;
    $toGE = "Procurement to GE-8JV: ".number_format(max(round(($jitaSell + $jitaToMendori + $mendoriToGE+500000.001)*1.10,-6), 5000000))."<br>";
    $toPZMA = "Procurement to PZMA-E: ".number_format(max(round(($jitaSell + $jitaToMendori + $mendoriToPZMA+500000.001)*1.10,-6), 5000000))."<br>";
    $toFAT = "Procurement to FAT-6P: ".number_format(max(round(($jitaSell + $jitaToMendori + $mendoriToFAT+500000.001)*1.10,-6), 5000000))."<br>";
    ##$haulToFAT = "Hauling from GE-8JV to FAT-6P: ".number_format(max($GEToFAT,5000000))."<br>";
    $haulToGE = "Hauling to/from GE-8JV: ".number_format(max(round(($jitaSell + $jitaToMendori + $mendoriToGE+500000.001)*1.10,-6)-$jitaSell, 5000000))."<br>";
    $haulToPZMA = "Hauling to/from PZMA-E: ".number_format(max(round(($jitaSell + $jitaToMendori + $mendoriToPZMA+500000.001)*1.10,-6)-$jitaSell, 5000000))."<br>";
    
    ##$toGEZXIC = "GE-8JV <-> ZXIC: ".number_format($GEToZXIC)."<br>";
    //$toLtack5 = "Total to L-5: ~".number_format(max(round(($jitaSell + $jitaToMendori + $mendoriToLtack5+500000.001)*1.01,-6), 5000000))."<br>";
    
    

    
    
    
    $bigString = $_POST["evepraisal"]."<br>".$toGE.$toZXIC.$toGEZXIC;
    echo "Due to the current situation and diverted focus, procurement orders may take longer than listed below<br>";
    echo "Jita Sell: ".number_format($jitaSell)."<br>";
    echo $toGE;
    echo $toPZMA;
    ##echo $toFAT;
    ##echo $haulToFAT;
    /*echo $haulToGE;
    echo $haulToPZMA;*/
    
    echo "<br>";
    //echo $toLtack5;
    /*
    echo "New Test price to GE: ~".number_format($modifiedTotalToGE)."<br>";
    echo "New Test price to PZMA: ~".number_format($modifiedTotalToPZMA)."<br>";
    echo "<br>"."<br>";
    */
    ?>   
                                            </center>
                                            


                               
											
											
											

					
				</div>
				<b2>I retain the right to reject any orders. Reason for this is likely the overall isk/m3 of the order making it difficult to transport through empire space.<br></b2>
				<b2>Delivery to GE usually takes 24-36 hours from order confirmation but I aim to deliver within 24 hours. Delivery to other places may take longer.<br></b2>
  <b2>I use various 3rd parties to carry out my services, these include but are not limited to: public couriers, BLT and TEST hauling services. </b2>
  <br>
  <b3>Due to market fluctuations, the price at delivery may differ from the quote.<br>If there is a significant change (5%+) I will notify you before carrying out any purchases. All orders are subject to a minimum total pricing of 5,000,000 isk.</b3>
				</div>
				
			</section>

		<!-- Scripts -->
			<script src="assets/js/jquery.min.js"></script>
			<script src="assets/js/browser.min.js"></script>
			<script src="assets/js/breakpoints.min.js"></script>
			<script src="assets/js/util.js"></script>
			<script src="assets/js/main.js"></script>

	</body>
</html>