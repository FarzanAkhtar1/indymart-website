# indymart-website
Website code for indymart

This repo contains all the code for a website I developed using a template for the Space-themed MMO, Eve Online for a friend of mine. 
This code isn't well documented or maintained. Sorry.

<h2>Procurement Code</h2>
If you are after the backend code for the procurement calculator. This can be found in procurement.php
Line 58-65 contains the HTML form used to take an evepraisal.com link as an inputs.
Line 73-157 contains the actual calculations. Some explanation:
- Line 114: Rounds the Jita Sell value up to the nearest million. <br/>
- Line 115: Calcualtes collateral by a factor of 1.1, rounds up to nearest million <br/>
- Line 116: Calculates the fee paid to couriers from Jita to Mendori (45 jumps), at a rate of 0.1% of the collat per jump. <br/>
- Line 117-118: 117 gets volume of goods. 118 calculates a ratio of the volume over 320,000, rounded to 2 d.p (follows BLT formula). <br/>
- Line 119: Calcualtes ratio of collat to recommended collat of 3,000,000,000, rounded to 2 d.p (follows BLT formula). <br/>
- Line 120: Picks highest of the 2 ratios from above. <br/>
- Line 121-122: Calculates the JF cost from Mendori to the GE/PZMA. The number is taken from the BLT caculator, hovering over the reward shown gives a breakdown, the value is the sum of the breakdown. <br/>
- Line 125-126: Outputs the total price of procurement (including purchasing, transporting, and contracting). Calculation is Jita Sell (Line 114) + Highsec Courier (Line 116) + JF hauling (Line 121-122, based on destination). If then multiplies this by 1.1, giving a 10% margin. Also gets rounded. <br/>
