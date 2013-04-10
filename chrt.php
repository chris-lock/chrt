<?php
class chrtException extends Exception {}

class chrt {
	/**
	 * Settings
	 * @var array
	 *		chart (array)
	 *			height (num)
	 *			width (num)
	 *    		margin (num)
	 *			padding (num)
	 *		legend (array)
	 *			height (num)
	 *		guide (array)
	 *			count (num)
	 *			color (string)
	 *    		width (num)
	 *		baseline (array)
	 *			color (string)
	 *			auto (bool)
	 *			value (num)
	 *		point (array)
	 *			size (num)
	 *			stroke_width (num)
	 *		line (array)
	 *			width (num)
	 *			handle_offset (double)
	 *		label (array)
	 *			font (string)
	 *			size (num)
	 *    		color (string)
	 */
	private $settings = array(
		'chart' => array(
			'height' => 310,
			'width' => 450,
			'margin' => 20,
			'padding' => 20,
		),
		'legend' => array(
			'height' => 20
		),
		'guide' => array(
			'count' => 5,
			'color' => '#EEEEEE',
			'width' => 1
		),
		'baseline' => array(
			'color' => '#333333',
			'auto' => true,
			'value' => 0
		),
		'point' => array(
			'size' => 5,
			'stroke_width' => 2
		),
		'line' => array(
			'width' => 4,
			'handle_offset' => 0.4
		),
		'label' => array(
			'font' => 'san-serif',
			'size' => 10,
			'color' => '#333333'
		)
	);

	/**
	 * Example data set used for validation
	 * @var array
	 *		label (string)
	 *		color (string)
	 *		type (string)
	 *		points (array)
	 *			(num)
	 */
	private $data_set_example = array(
		'label' => 'string',
		'color' => 'string',
		'type' => 'string',
		'points' => array(
			1
		)
	);

	/**
	 * Final chart
	 * @var string
	 */
	public $chart;

	/**
	 * PHP 4 Constructor
	 * See __contruct
	 */
	public function chrt($chart_name, $data_sets, $x_axis_labels, $settings)
	{
		$this->__construct($chart_name, $data_sets, $x_axis_labels, $settings);
	}

	/**
	 * PHP 5 Constructor
	 * @param string Chart Name
	 * @param array Data sets matching the type data_set_example
	 * @param array Labels for the x axis
	 * @param array An array of settings overrides matching the type of the default setting
	 * @return string Chart
	 */
	public function __construct($name, $data_sets, $x_axis_labels, $settings = array())
	{
		$this->validate_and_update_settings($settings, $this->settings);
		$this->validate_data_sets($data_sets);
		$this->validate_x_axis_labels($x_axis_labels, $data_sets);

		$all_data_points = $this->get_all_points_points($data_sets);
		$data_max = $this->get_data_max($all_data_points);
		$data_min = $this->get_data_min($all_data_points);
		$this->settings['guide']['interval'] = $this->get_aesthetic_guide_interval(
			$data_max,
			$data_min,
			$this->settings['guide']['count'] - 1
		);
	}

	/**
	 * Validates and updates individual setting with override
	 * @param mixed Setting override
	 * @param mixed Default setting
	 * @param string Default setting name
	 * @throws chrtException If setting doesn't exist or is improperly typed
	 */
	private function validate_and_update_settings($override, &$default, $default_name = '$this->settings')
	{
		$this->validate_type_matches($override, $default, $default_name);

		if (is_array($default)) {
			foreach ($override as $override_name => $override_value) {
				$default_name = $default_name . '[' . $override_name . ']';
				
				if (! isset($default[$override_name]))
					throw new chrtException(
						$default_name . ' is not used.'
					);

				$this->validate_and_update_settings(
					$override_value,
					$default[$override_name],
					$default_name
				);
			}
		} else {
			$default = $override;
		}
	}

	/**
	 * Validates that a provided param matches a default param
	 * @param mixed Provided prarm
	 * @param mixed Default param
	 * @param string Default param name
	 * @throws chrtException If param is improperly typed
	 */
	private function validate_type_matches($provided_value, $default_value, $default_name)
	{
		$provided_type = gettype($provided_value);
		$default_type = gettype($default_value);

		if (is_numeric($provided_value) && is_numeric($default_value))
			return true;

		if ($provided_type !== $default_type)
			throw new chrtException(
				$default_name . ' should be ' . $default_type . '. ' . 
				$provided_type . ' provided.'
			);
	}

	/**
	 * Validates data set parameters and data set points length
	 * @param array Data sets
	 */
	private function validate_data_sets($data_sets)
	{
		$data_set_points_default_size = count($data_sets[0]['points']);

		foreach ($data_sets as $index => $data_set) {
			$data_set_name = '$data_sets[' .  $index . ']';
			
			$this->validate_data_set_parameters(
				$data_set_name,
				$data_set
			);
			$this->validate_data_set_points_size(
				$data_set_name,
				$data_set['points'],
				$data_set_points_default_size
			);
		}
	}

	/**
	 * Validates data set parameters
	 * @param string Data set name
	 * @param array Data set
	 * @throws chrtException If data set param are missing or improperly typed
	 */
	private function validate_data_set_parameters($data_set_name, $data_set)
	{
		foreach ($this->data_set_example as $default_param => $default_type) {
			if (! isset($data_set[$default_param]))
				throw new chrtException(
					$data_set_name . ' missing ' . $default_param
				);

			$this->validate_type_matches(
				$data_set[$default_param],
				$default_type,
				$data_set_name . '[' . $default_param . ']'
			);

			if (is_array($default_type))
				foreach ($data_set[$default_param] as $key => $value)
					$this->validate_type_matches(
						$value,
						$default_type[0],
						$data_set_name . '[' . $default_param . ']' . '[' . $key . ']'
					);
		}
	}

	/**
	 * Validates data set parameters
	 * @param string Data set name
	 * @param array Data set points
	 * @param int Default data set point length
	 * @throws chrtException If data set point length does not match default
	 */
	private function validate_data_set_points_size($data_set_name, $data_set_points, $data_set_points_default_size)
	{
		$data_set_points_size = count($data_set_points);

		if ($data_set_points_size !== $data_set_points_default_size)
			throw new chrtException(
				'Data sets size do not match. ' . 
				$data_set_name . ' has ' . $data_set_points_size . ' items ' .
				'instead of ' . $data_set_points_default_size . '.'
			);
	}

	/**
	 * Validates data set parameters
	 * @param array X axis labels
	 * @param array Data sets
	 * @throws chrtException If x axis length does not match data sets point size
	 */
	private function validate_x_axis_labels($x_axis_labels, $data_sets)
	{
		$x_axis_labels_size = count($x_axis_labels);
		$data_set_points_default_size = count($data_sets[0]['points']);

		if ($x_axis_labels_size !== $data_set_points_default_size)
			throw new chrtException(
				'$x_axis_labels size do not match data set points size. ' . 
				'$x_axis_labels has ' . $x_axis_labels_size . ' items ' .
				'instead of ' . $data_set_points_default_size . '.'
			);
	}

	/**
	 * Aggregate all data points into a single array
	 * @param array Data sets
	 * @return array All data points
	 */
	private function get_all_points_points($data_sets)
	{
		$all_data_points = array();
		foreach ($data_sets as $index => $data_set)
			$all_data_points = array_merge($all_data_points, $data_set['points']);

		return $all_data_points;
	}

	/**
	 * Get maximum data point value
	 * @param array All data points
	 * @return int Maximum value
	 */
	private function get_data_max($all_data_points)
	{
		return max($all_data_points);
	}

	/**
	 * Get minimum data point value
	 * @param array All data points
	 * @return num Minimum value
	 */
	private function get_data_min($all_data_points)
	{
		return min($all_data_points);
	}

	/**
	 * Gets an aesthetically pleasing guide interval
	 * @param num Data max
	 * @param num Data min
	 * @param num Guide interval count
	 * @return num Aesthetic guide interval
	 */
	private function get_aesthetic_guide_interval($data_max, $data_min, $interval_count)
	{
		$data_range = $data_max - $data_min;
		$place = floor(log10(($data_range / $interval_count)));
		$odd_even = (cos(pi() * $place) * .5) + 1.5;

		return ($place)
			? pow(10, ($place - $odd_even)) * 5 * $odd_even 
			: pow(10, $place);
	}
}