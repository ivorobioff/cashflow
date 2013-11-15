 <div class="bld-container">
  <div class="well" id="filter">
	<?=$this->renderPartial('//parts/date_range')?>
</div>
 <?=$this->renderPartial('//parts/table', array('data' => $data, 'summary_data' => $summary_data));?>
 </div>