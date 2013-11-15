<?php
$params = $this->getParams();
$expenses_fixed = $params['expenses_fixed'];

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
 <td>
 <?=CHtml::encode($name)?>
 <?php
 if (!empty($show_expenses_fixed))
 {
 ?>
 &nbsp; &nbsp;<select class="exp-fixed" name="expenses_fixed" onchange="update_expenses_fixed(this, '<?=addslashes($name)?>')">
	<option <?=!setif($expenses_fixed, $name) ? 'selected="selected"' : ''?> value="0">Variable</option>
	<option <?=setif($expenses_fixed, $name) ? 'selected="selected"' : ''?> value="1">Fixed</option>
</select>
 <?php
 }
 ?>
 </td>
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

 <?php
 if (!empty($show_expenses_fixed))
 {
 ?>
 <script>
function update_expenses_fixed(el, name){
	el = $(el);
	el.attr("disabled", "disabled");
	post("/params/updateExpensesFixed", {name: name, fixed: el.val()}, {
		callback: function(){
			location.reload();
		}
	});
}
 </script>
 <?php
 }
 ?>