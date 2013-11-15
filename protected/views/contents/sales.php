 <div class="bld-container">
  <div class="well" id="filter">
	<?=$this->renderPartial('//parts/date_range')?>
</div>
  <?php
 if (!$data)
 {
 	?>
     <h4 style="text-align: center">Data not found</h4>
 <?
  }
  else
  {
  	echo $this->renderPartial('//parts/table', array('data' => $data, 'summary_data' => $summary_data));

  	 echo $this->renderPartial('//parts/chart', array(
  	 	'chart_data' => $chart_data,
  	 	'type' => 'line',
  	 	'title' => 'Sales Forecast'
  	 ));
  }
 ?>
 </div>