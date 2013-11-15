<?php
namespace Components\DataBuilder;

abstract class Base
{
	protected $_params;

	public function __construct(array $params)
	{
		$this->_params = $params;
	}

	abstract public function build();

	public function buildSummary(array $data)
	{
		$res = array();

		foreach ($data as $year => $names)
		{
			foreach ($names as $name => $months)
			{
				foreach ($months as $month => $value)
				{
					if (!isset($res[$year]['months'][$month]))
					{
						$res[$year]['months'][$month] = 0;
					}

					$res[$year]['months'][$month] += $value;

					if (!isset($res[$year]['names'][$name]))
					{
						$res[$year]['names'][$name] = 0;
					}

					$res[$year]['names'][$name] += $value;
				}
			}
		}

		foreach ($res as $year => $items)
		{
			$res[$year]['total'] = array_sum($items['months']);
		}

		return $res;
	}
}