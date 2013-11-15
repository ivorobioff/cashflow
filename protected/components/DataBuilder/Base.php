<?php
namespace Components\DataBuilder;

use Helpers\Basic as BasicHelper;
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

	public function buildChartData(array $data)
	{
		return $this->_buildData4Chart($data);
	}

	protected function _buildData4Chart(array $data)
	{
		$result = array('categories' => array(), 'data' => array());

		$helper = new BasicHelper();

		foreach ($data as $year => $names)
		{
			reset($names);

			foreach (current($names) as $month => $values)
			{
				$result['categories'][$month.'/'.$year] = 1;
			}
		}

		$result['categories'] = array_keys($result['categories']);
		$result['total_categories'] = count($result['categories']);

		$tmp_data = array();

		foreach ($data as $year => $names)
		{
			foreach ($names as $name => $months)
			{
				foreach ($months as $month => $value)
				{
					$tmp_data[$name][] = round($value, 2);
				}
			}
		}

		foreach ($tmp_data as $name => $data)
		{
			$result['data'][] = array('name' => $name, 'data' => $data);
		}

		return json_encode($result);
	}
}