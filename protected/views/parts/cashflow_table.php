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
 <tr <?=$name == 'Total' ? 'class="total-bold"' : ''?>>
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
 <?=$this->money($summary_data[$year][$name])?>
 </td>
 </tr>
 <?php
 }
 ?>
   </table>
 <?php
 }
 ?>