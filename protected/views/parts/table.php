<?php 
 foreach ($data as $year => $names)
 { 	
 	reset($names);
 	$months = current($names); 
 	
 	$current_year  = date('Y');
 	$current_month = intval(date('m'));
 ?>
 <h4><?=$year?></h4>
  <table class="table table-bordered bld-data">
  <tr>
 <th></th>
 <?php 
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
 <?php 
 foreach ($names as $name => $months)
 {
 ?>
 <tr>
 <td><?=CHtml::encode($name)?></td>
 <?php 
 foreach ($months as $month => $value)
 {
 ?>
 <td><?=$this->money($value)?></td>
 <?php 
 }
 ?>
 <td>
 <?=$this->money($summary_data[$year]['names'][$name])?>
 </td>
 </tr>
 <?php 
 }
 ?>
 <tr class="bld-total">
 	<td>Total</td>
<?php 
 foreach ($summary_data[$year]['months'] as $value)
 {
 ?>
 <td><?=$this->money($value)?></td>
 <?php 
 }	
?>
<td><?=$this->money($summary_data[$year]['total'])?></td>
 </tr>
   </table>
 <?php 
 }
 ?> 