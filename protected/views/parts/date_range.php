<?php
$params = $this->getParams();
?>
<form action="<?=$this->createUrl('/params/updateDate')?>" id="date-range-filter">
<table>
		<tr>
			<td style="vertical-align: middle;">Date Range:&nbsp;&nbsp;&nbsp;</td>
			<td>
				<div class="input-append date" id="date_from" data-date="<?=date('m/Y', strtotime($params['date_from']))?>" data-date-format="mm/yyyy" data-date-viewmode="years" data-date-minviewmode="months">
					<input class="span2" size="16" type="text" value="<?=date('m/Y', strtotime($params['date_from']))?>" name="date_from" readonly="true" />
					<span class="add-on"><i class="icon-calendar"></i></span>
				  </div>
			</td>
			<td>&nbsp;&nbsp;- to -&nbsp;&nbsp;</td>
			<td>
				<div class="input-append date" id="date_to" data-date="<?=date('m/Y', strtotime($params['date_to']))?>" data-date-format="mm/yyyy" data-date-viewmode="years" data-date-minviewmode="months">
					<input class="span2" size="16" type="text" value="<?=date('m/Y', strtotime($params['date_to']))?>" name="date_to" readonly="true" />
					<span class="add-on"><i class="icon-calendar"></i></span>
				  </div>
			</td>
			<td>&nbsp;&nbsp;&nbsp;&nbsp;End date needs to be some date in the future for the forecast&nbsp;&nbsp;&nbsp;&nbsp;

			<button class="btn btn-primary" type="submit">Update</button>
			</td>
		</tr>
	</table>
</form>
<script>
$(function(){
	new Views.DateRangeFilter();
});
</script>