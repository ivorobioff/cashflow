  <tr>
 <th></th>
 <?php

 $current_year  = date('Y');
 $current_month = intval(date('m'));

 if ($year == $current_year && in_array($current_month, array_keys($months)))
 {
 	reset($months);
 	$first_month = key($months);
 ?>
 <th colspan="<?=($current_month - $first_month)?>">Actual</th>
 <th colspan="<?=(count($months) - ($current_month - $first_month))?>">Forecast</th>
 <?php
 }
 else
 {
 ?>
 <th colspan="<?=count($months)?>"><?=$year <= $current_year? 'Actual' : 'Forecast'?></th>
 <?php
 }
 ?>
  <th>Actual+Forecast</th>
 </tr>
  <tr>
 <th>Months</th>
 <?php
 foreach (array_keys($months) as $month)
 {
 ?>
 <th><?=$month?></th>
 <?php
 }
 ?>
 <th>Full YEAR</th>
 </tr>