<!DOCTYPE HTML>
<!--
	Industrious by TEMPLATED
	templated.co @templatedco
	Released for free under the Creative Commons Attribution 3.0 license (templated.co/license)
-->
<html>
	<head>
		<title>Indymart - Hauling</title>
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
					<li><a href="index.php">Buybacks</a></li>
				</ul>
			</nav>

		<!-- Banner -->
			<section id="banner">
				<div class="inner">
					<h1><a href="hauling.php">Hauling</a></h1>
					<p>A to B, safe and secure</p>
				</div>

			</section>

		<!-- Highlights -->
			<section class="wrapper">
				<div class="inner">
					<header class="special">
						<h2>How to use</h2>
						<p>Input an evepraisal link into the box. Press the button to generate your quote.</p>
						<p>Contracts to "Indybro" of Zansha Buyback. Max volume 350,000 m3. Expiration, 7 days. Time to complete, 3 days.  </p>
						<b2>Serviced stations:<br></b2>
						<b2>GE-8JV - Mothership Bellicose<br></b2>
						<b2>ZXIC-7 - Catch Stronghold<br></b2>
						<b2>Mendori IV - Moon 1 - Ministry of Assessment Information Center<br></b2>
					</header>
					
										<form method="post" action="hauling.php">
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
    if($jsonDecode["totals"]["sell"] = 0.00){
    }else{
    $jitaSell = round($jsonDecode["totals"]["sell"]+500000.01, -6);
    $collateral = round($jsonDecode["totals"]["sell"], -6)*1.1;
    $jitaToMendori = (collateral*18)/1000;
    $volume = round($jsonDecode["totals"]["volume"],2);
    $volumeRatio = round(round($jsonDecode["totals"]["volume"],2)/320000,2);
    $collatRatio = round($collateral/3000000000,2);
    $max = max($volumeRatio, $collatRatio);
    $mendoriToGE = 164240000 * $max * 0.75;
    $mendoriToZXIC  = 132880000 * $max * 0.75;
    $GEToZXIC = 47240000 * $max * 0.75;
    ##$jitaToQLPX = round( ($jitaSell + ($volume * 900) + 500000.01 + ($collateral/100))*1.01,-6);
    $toGE = "Mendori <-> GE-8JV: ".number_format($mendoriToGE)."<br>";
    $toZXIC = "Mendori <-> ZXIC-7: ".number_format($mendoriToZXIC)."<br>";
    $toGEZXIC = "GE-8JV <-> ZXIC: ".number_format($GEToZXIC)."<br>";
    //$toLtack5 = "Total to L-5: ~".number_format(max(round(($jitaSell + $jitaToMendori + $mendoriToLtack5+500000.001)*1.01,-6), 5000000))."<br>";
    
    

    
    
    
    $bigString = $_POST["evepraisal"]."<br>".$toGE.$toZXIC.$toGEZXIC;
    echo "Jita Sell: ".number_format($jitaSell)."<br>";
    echo $toGE;
    echo $toZXIC;
    echo $toGEZXIC;
    echo "<br>";
    //echo $toLtack5;
    /*
    echo "New Test price to GE: ~".number_format($modifiedTotalToGE)."<br>";
    echo "New Test price to PZMA: ~".number_format($modifiedTotalToPZMA)."<br>";
    echo "<br>"."<br>";
    */}
    ?>
                                            </center>
                                            


                               
											
											
											

					
				</div>
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