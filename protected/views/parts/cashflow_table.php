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
 <td>
<?php
 if ($name == '$ at Bank')
 {
 	$budget_id = uniqid('budget');
 ?>
<div class="budget-editable" id="<?=$budget_id?>">
	<?=$this->money($value)?>
	<script>
		$(function(){
			new Views.BudgetEditor("<?=$budget_id?>", "<?=$year?>-<?=$month?>", "<?=$value?>");
		});
	</script>
</div>
 <?php
 }
 else
 {
 	echo $this->money($value);
 }
?>
 </td>
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

 <script type="text/template" id="edit-budget-dialog">
	<div ref="{{ref}}">
		<div class="input-append">
		    <input class="span2" id="appendedInputButton" name="budget" value="" type="text">
		    <button class="btn" id="change-budget" type="button"><i class="icon-ok">&nbsp;</i></button>
			<button class="btn" id="close-popover" type="button"><i class="icon-remove">&nbsp;</i></button>
		  </div>
	</div>
 </script>
