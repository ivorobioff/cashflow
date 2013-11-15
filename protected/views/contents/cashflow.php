 <?php
 $params = $this->getParams();
 ?>
 <div class="bld-container">
 <div class="well" id="filter">
	<?=$this->renderPartial('//parts/date_range')?>
	<br/>
	<div id="mini-forms">
	 Average time to pay&nbsp;&nbsp;
	<div class="input-append">
    <input class="span1" id="appendedInputButton" type="text" name="average_time" value="<?=$params['average_time']?>" />
    <button class="btn" type="button"><i class="icon-ok">&nbsp;</i></button>
    </div>
	</div>
</div>
 <?=$this->renderPartial('//parts/cashflow_table', array('data' => $data, 'summary_data' => $summary_data));?>
 <?=$this->renderPartial('//parts/chart', array(
 	'chart_data' => $chart_data,
 	'type' => 'column',
 	'title' => 'Cashflow Forecast'
 ))?>

 </div>

<script>
$(function(){
	new Views.MiniForms();
});
 </script>