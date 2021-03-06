 <?php
 $params = $this->getParams();
 ?>
 <div class="bld-container">
  <div class="well" id="filter">
	<?=$this->renderPartial('//parts/date_range')?>
	<br/>
	<table id="mini-forms">
		<tr>
			<td>Starting cash-in in days&nbsp;&nbsp;</td>
			<td>
			<div class="input-append">
		    <input class="span1" id="appendedInputButton" name="starting_cashin" value="<?=$params['starting_cashin']?>" type="text">
		    <button class="btn" type="button"><i class="icon-ok">&nbsp;</i></button>
		    </div>
			</td>

			<td style="padding-left: 25px;">Increase in Revenues&nbsp;&nbsp;</td>
			<td>
			<div class="input-append">
		    <input class="span1" id="appendedInputButton" name="increase_revenues" value="<?=$params['increase_revenues']?>" type="text">
		    <button class="btn" type="button"><i class="icon-ok">&nbsp;</i></button>
		    </div>
			</td>
		</tr>
		<tr>
			<td>Average time to pay&nbsp;&nbsp;</td>
			<td>
				<div class="input-append">
			    <input class="span1" id="appendedInputButton" name="average_time" value="<?=$params['average_time']?>" type="text">
			    <button class="btn" type="button"><i class="icon-ok">&nbsp;</i></button>
			    </div>
			</td>
			<td style="padding-left: 25px;">Reduction of expenses&nbsp;&nbsp;</td>
			<td>
				<div class="input-append">
			    <input class="span1" id="appendedInputButton" name="reduction_expenses" value="<?=$params["reduction_expenses"]?>" type="text">
			    <button class="btn" type="button"><i class="icon-ok">&nbsp;</i></button>
			    </div>
			</td>
		</tr>

	</table>
</div>
<?php if ($expenses_data){?>
<h4 style="text-align: left;">Revised Expenses</h4>
 <?=$this->renderPartial('//parts/table', array(
 		'data' => $expenses_data,
 		'summary_data' => $expenses_summary_data,
 		'show_expenses_fixed' => true
 ));?>
<?php if ($this->isAllowedShowCharts()){?>
 <table style="width: 100%;">
 	<tr>
 		<td style="width: 50%;">
			<div>
			<?=$this->renderPartial('//parts/chart', array(
			 	'chart_data' => $current_expenses_chart_data,
			 	'type' => 'column',
			 	'title' => 'Current budget incl Forecast',
			 	'id' => 'current-expenses',
			 ))?>
			 </div>
 		</td>
 		<td>
 			<div>
 			 <?=$this->renderPartial('//parts/chart', array(
			 	'chart_data' => $expenses_chart_data,
			 	'type' => 'column',
			 	'title' => 'Revised budget incl Forecast',
			 	'id' => 'revised-expenses',
			 ))?>
			 </div>
 		</td>
 	</tr>
 </table>
 <?php }?>
 <br/>
 <?php }?>
<h4 style="text-align: left;">Revised Cash Flow</h4>
  <?=$this->renderPartial('//parts/cashflow_table', array(
 		'data' => $cashflow_data,
 		'summary_data' => $cashflow_summary_data
 ));?>

  <?php
if ($this->isAllowedShowCharts())
{
  	echo $this->renderPartial('//parts/chart', array(
 	'chart_data' => $cashflow_chart_data,
 	'type' => 'column',
 	'title' => 'Revised Cash Flow'
 ));
}?>
 </div>

  <script>
$(function(){
	new Views.MiniForms();
});
 </script>