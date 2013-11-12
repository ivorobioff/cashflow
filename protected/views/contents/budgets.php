 <div class="bld-container">
 <?=$this->renderPartial('//parts/table', array(
 		'data' => $expenses_data,
 		'summary_data' => $expenses_summary_data
 ));?>
 <br/>
 <hr/>
  <?=$this->renderPartial('//parts/cashflow_table', array(
 		'data' => $cashflow_data,
 		'summary_data' => $cashflow_summary_data
 ));?>
 </div>