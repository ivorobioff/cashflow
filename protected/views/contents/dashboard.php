 <div class="bld-container">
	 <div class="well" id="filter">
		<?=$this->renderPartial('//parts/date_range')?>
	</div>

<?=$cashflow_chart_data ? $this->renderPartial('//parts/chart', array(
 	'chart_data' => $cashflow_chart_data,
 	'type' => 'column',
 	'title' => 'Cashflow Forecast',
	'id' => 'cashflow-chart',
 )) : ''?>

<?=$expenses_chart_data ? $this->renderPartial('//parts/chart', array(
	'chart_data' => $expenses_chart_data,
	'type' => 'column',
	'title' => 'Expenses Forecast',
	'id' => 'expenses-chart'
)) : ''?>

 <?=$sales_chart_data ? $this->renderPartial('//parts/chart', array(
 	'chart_data' => $sales_chart_data,
 	'type' => 'line',
 	'title' => 'Sales Forecast'
 )) : ''?>

<?php if ($this->isAllowedShowCharts()) {?>
<?=$revised_cashflow_chart_data ? $this->renderPartial('//parts/chart', array(
 	'chart_data' => $revised_cashflow_chart_data,
 	'type' => 'column',
 	'title' => 'Revised Cash Flow',
 	'id' => 'revised-cashflow-chart'
 )) : ''?>

 <table style="width: 100%;">
 	<tr>
 		<td style="width: 50%;">
			<div>
			<?=$expenses_chart_data ? $this->renderPartial('//parts/chart', array(
			 	'chart_data' => $expenses_chart_data,
			 	'type' => 'column',
			 	'title' => 'Current budget incl Forecast',
			 	'id' => 'current-expenses-chart',
			 )) : ''?>
			 </div>
 		</td>
 		<td>
 			<div>
 			 <?=$revised_expenses_chart_data ? $this->renderPartial('//parts/chart', array(
			 	'chart_data' => $revised_expenses_chart_data,
			 	'type' => 'column',
			 	'title' => 'Revised budget incl Forecast',
			 	'id' => 'revised-expenses-chart',
			 )) : ''?>
			 </div>
 		</td>
 	</tr>
 </table>
 <?php }?>
 </div>