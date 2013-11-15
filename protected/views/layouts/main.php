<?php /* @var $this Controller */?>
<!DOCTYPE html>
<html>
	<?=$this->renderPartial('//parts/head')?>
  	<body>
  		<div class="body-container">
  		 	<div class="navbar">
			    <div class="navbar-inner">
			    <a class="brand" href="/">Cloud Cash Flow</a>
			    <a href="<?=$this->createUrl('/auth/logout')?>" style="float: right; margin-left: 10px;" class="btn btn-danger">Logout</a>
			    <ul class="nav nav nav-pills pull-right">
			    <li <?=is_location('/dashboard/index')? 'class="active"' : ''?>><a href="<?=$this->createUrl('/dashboard')?>">Dashboard</a></li>
			    <li <?=is_location('/cashflow/index')? 'class="active"' : ''?>><a href="<?=$this->createUrl('/cashflow')?>">Cashflow</a></li>
			    <li <?=is_location('/expenses/index')? 'class="active"' : ''?>><a href="<?=$this->createUrl('/expenses')?>">Expenses</a></li>
			    <li <?=is_location('/sales/index')? 'class="active"' : ''?>><a href="<?=$this->createUrl('/sales')?>">Sales</a></li>
			    <li <?=is_location('/budgets/index')? 'class="active"' : ''?>><a href="<?=$this->createUrl('/budgets')?>">Budgets</a></li>
			    </ul>

			    </div>
		    </div>
		    <?=$content?>
  		</div>
  		<br/><br/>
    </body>
</html>