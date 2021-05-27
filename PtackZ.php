<html>  
<body>
Hauling from Jita <=> 8QT 
Hauling from Badivefi/Moro <=> 8QT
If you require more than 10b collateral, please PM me directly on Slack (@indybro) or on Discord (@fazzy#6116)
<form action="PtackZ.php" method="post">
Collateral: <input type="number" name="collateral" max="10000000000"><br>
Volume (60,000 m3 max): <input type="text" name="volume" max="60000" pattern="^\d*(\.\d{0,2})?$"><br>
<input type="submit" value="Calculate">
</form>

<?php
$collatRatio = round($_POST["collateral"]/6000000000, 2);
$volumeRatio = round($_POST["volume"]/360000, 2);
if ($_POST["collateral"] > 0 && $_POST["volume"] > 0 && $_POST["volume"] <60000.01) {
    echo "Volume: ".number_format($_POST["volume"])." m3 <br>";
    echo "Collateral: ".number_format($_POST["collateral"])." isk <br>";
    echo "Availability: Private: 'Indybro' (Exactly as spelt)<br>";
    echo "Duration: 7 days<br>";
    echo "Completion: 7 days<br>";
    echo "Source: Jita 4-4<br>";
    echo "Destination: P-ZMZV<br>";
    echo "Reward: ".number_format(max(20000000,((58/1000 * 0.85 * $_POST["collateral"]) + (max($collatRatio, $volumeRatio)*90000000))*1.02))."<br>";
};
?>
</body>
</html>