<?php
 foreach ($data as $year => $names)
 {
 	reset($names);
 	$months = current($names);
 ?>
 <h4><?=$year?></h4>
  <table class="table table-bordered bld-data">
   <?=$this->renderPartial('//parts/table_head', array('year' => $year, 'months' => $months))?>
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