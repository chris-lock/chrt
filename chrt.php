<?php
class chrt {
//------------------------------------------------------------
//
// Author: Chris Lock
// Copyright (c) 2012	
//
//------------------------------------------------------------
// VAR
//------------------------------------------------------------	
	var $version;
	var $max_sets;
	var $chart_name;
	var $chart_color;
	var $data;
	var $show_all_labels;
	var $date_type;
	var $date_start;
	var $data_type;
	var $data_count;
	var $percent;
	var $rank;
	var $currency;
	var $currency_place;
	var $drop_decimals;
	var $chart_min;
	var $chart_max;
	var $bar_count;
	var $bar_total;
	var $bar_width;
	
	var $chart_width;
	var $chart_height;
	
	var $chart_padding_x_base;
	var $chart_padding_x;
	var $chart_padding_y;
	var $chart_margin_x;
	var $chart_margin_y;
			
	var $chart_width_legend;
	var $chart_width_data;
			
	var $chart_height_legend;
	var $chart_height_data;
			
	var $guide_count;
	var $guide_color;
	var $base_line_color;
	var $guide_width;
	var $guide_label_offset;
	var $show_y_axis;
	
	var $guide_label_x_font_weight;
	var $guide_label_x_font;
	var $guide_label_x_size;
	var $guide_label_x_color;
	var $guide_label_x_stroke;
	var $guide_label_x_stroke_color;
	var $guide_label_x_stroke_opacity;
	var $guide_label_x_anchor;
	
	var $guide_label_y_font_weight;
	var $guide_label_y_font;
	var $guide_label_y_size;
	var $guide_label_y_color;
	var $guide_label_y_stroke;
	var $guide_label_y_stroke_color;
	var $guide_label_y_stroke_opacity;
	var $guide_label_y_anchor;
	
	var $legend_font_weight;
	var $legend_font;
	var $legend_size;
	var $legend_color;
	var $legend_stroke;
	var $legend_stroke_color;
	var $legend_stroke_opacity;
	var $legend_anchor;
	var $legend_font_adjust;
	
	var $line_color;
	var $line_width;
	var $curve_handle_weight;
	var $box_border_color;
	var $box_border_width;
	
	var $point_size;
	var $point_fill_color;
	var $point_stroke_color;
	var $point_stroke;
	
	var $chart_guide;
	var $chart_guide_color;
	var $chart_guide_width;
	var $chart_guide_dash;
	
	var $label_font_weight;
	var $label_font;
	var $label_size;
	var $label_color;
	var $label_stroke;
	var $label_stroke_color;
	var $label_stroke_opacity;
	var $label_anchor;
	var $label_offset;
	
	var $plot;
	var $plot_bars;
	var $plot_guides;
	var $plot_lines;
	var $plot_labels;
	
	var $main_path;
	var $www_path;
	var $svg_path;
	var $png_path;
	var $hash;

//------------------------------------------------------------
// INI
//------------------------------------------------------------			
	function chrt($chart_name, $data = array(), $labels_x, $data_type = null, $show_all_labels = true, $chart_min = null, $chart_max = null, $chart_width = null, $chart_height = null, $scale_font_and_stroke = false, $chart_color = '#fbfaf9', $guide_count = 5, $chart_padding = 20, $chart_margin = array(40, 20)) {
		$this->version = '1.9.7';
		$this->max_sets = 4;
		$this->chart_name = $chart_name;
		$this->chart_color = $chart_color;
		$this->data = array_slice($data, 0, $this->max_sets + 1);
		$this->show_all_labels = $show_all_labels;
		$this->labels_x = $labels_x;
		$this->data_type = $data_type;
		$this->data_count = null;
		$this->percent = ( $this->data_type == 'percent' ) ? true : false;
		$this->rank = ( $this->data_type == 'rank' ) ? true : false;
		$this->currency = ( $this->data_type == 'currency' ) ? true : false;
		$this->currency_place = 1;
		$this->drop_decimals = false;
		$this->chart_min = $chart_min;
		$this->chart_max = $chart_max;
		$this->bar_count = 0;
		$this->bar_total = 0;
		$this->bar_width = 0;
		
		$default_chart_width = 530;
		$default_chart_height = 300;
		
		$this->chart_width = ( $chart_width ) ? $chart_width : $default_chart_width;
		$this->chart_height = ( $chart_height ) ? $chart_height : $default_chart_height;
		
		$scale_factor = ( $scale_font_and_stroke ) ? $chart_height / $default_chart_height * $scale_font_and_stroke : 1;
		
		$this->chart_padding_x_base = $chart_padding * $scale_factor;
		$this->chart_padding_x = $this->chart_padding_x_base;
		$this->chart_padding_y = $chart_padding * $scale_factor;
		$this->chart_margin_x = $chart_margin[0] * $scale_factor;
		$this->chart_margin_y = $chart_margin[1] * $scale_factor;
		
		$this->chart_width_legend = $this->chart_width - $this->chart_margin_x;
		$this->chart_width_data = $this->chart_width_legend - ( $this->chart_padding_x * 2 );
		
		$this->chart_height_legend = $this->chart_height - ( $this->chart_margin_y * 2.5 );
		$this->chart_height_data = $this->chart_height_legend - $this->chart_padding_y;
		
		$this->guide_count = $guide_count;
		$this->guide_color = null;
		$this->base_line_color = '#333333';
		$this->guide_width = 1 * $scale_factor;
		$this->guide_label_offset = .9;
		$this->show_y_axis = true;
		
		$this->guide_label_x_font_weight = 'bold';
		$this->guide_label_x_font = 'Arial';
		$this->guide_label_x_size = 10 * $scale_factor;
		$this->guide_label_x_color = '#333333';
		$this->guide_label_x_stroke = 0 * $scale_factor;
		$this->guide_label_x_stroke_color = '#FFFFFF';
		$this->guide_label_x_stroke_opacity = 1;
		$this->guide_label_x_anchor = 'middle';
		
		$this->guide_label_y_font_weight = 'bold';
		$this->guide_label_y_font = 'Arial';
		$this->guide_label_y_size = 10 * $scale_factor;
		$this->guide_label_y_color = '#333333';
		$this->guide_label_y_stroke = 0 * $scale_factor;
		$this->guide_label_y_stroke_color = '#FFFFFF';
		$this->guide_label_y_stroke_opacity = 1;
		$this->guide_label_y_anchor = 'end';
		
		$this->legend_font_weight = 'bold';
		$this->legend_font = 'Arial';
		$this->legend_size = 10 * $scale_factor;
		$this->legend_color = '#333333';
		$this->legend_stroke = 0 * $scale_factor;
		$this->legend_stroke_color = '#FFFFFF';
		$this->legend_stroke_opacity = 1;
		$this->legend_anchor = 'left';
		$this->legend_font_adjust = .150;
		
		$this->line_color = array(
			'#DF1479',
			'#36A0D0',
			'#A74CA9',
			'#AAAAAA'
		);
		$this->line_width = 4 * $scale_factor;
		$this->curve_handle_weight = 0;
		$this->box_border_color = '#0000000';
		$this->box_border_width = 1 * $scale_factor;
		
		$this->point_size = 4 * $scale_factor;
		$this->point_fill_color = array(
			'#FFFFFF',
			'#FFFFFF',
			'#FFFFFF',
			'#FFFFFF'
		);
		$this->point_stroke_color = $this->line_color;
		$this->point_stroke = 3 * $scale_factor;
		
		$this->chart_guide = null;
		$this->chart_guide_color = '#CCCCCC';
		$this->chart_guide_width = 2 * $scale_factor;
		$this->chart_guide_dash = 40 * $scale_factor;
		
		$this->label_font_weight = 'bold';
		$this->label_font = 'Arial';
		$this->label_size = 11 * $scale_factor;
		$this->label_color = '#333333';
		$this->label_stroke = 3 * $scale_factor;
		$this->label_stroke_color = '#FFFFFF';
		$this->label_stroke_opacity = 1;
		$this->label_anchor = 'middle';
		$this->label_offset = $this->label_size / 2;
		
		$this->plot = null;
		$this->plot_bars = null;
		$this->plot_guides = null;
		$this->plot_lines = null;
		$this->plot_labels = null;
		
		$this->main_path = dirname(__file__);
		$document_root = $_SERVER['DOCUMENT_ROOT'];
		$base = ( substr($document_root, -1) == '/' ) ? '/' : '';
		$this->www_path = str_replace($document_root, $base, $this->main_path);
		$this->svg_file_path = '/svg-files/';
		$this->svg_path = $this->svg_file_path . 'svg/';
		$this->png_path = $this->svg_file_path . 'png/';
		$this->hash = null;
	}
	
	
//------------------------------------------------------------
// GRAPH
//------------------------------------------------------------
	function chart($response = 'echo') {
		if ( $this->data && $this->chart_ini() ) {
			if ( $this->chart_guide && $this->chart_guide['label'] ) array_push($this->data, $this->chart_guide);
			$i = 0;
			$this->set_count = count($this->data);
			if ( $this->chart_guide && !$this->chart_guide['label'] ) array_push($this->data, $this->chart_guide);
			
			foreach ( $this->data as $set ) {
				if ( $set['type'] == 'line' ) {
					$this->line_chart($set, $i);
				} elseif ( $set['type'] == 'bar' ) {
					$this->bar_chart($set, $i);
				}  elseif ( $set['type'] == 'comparison' ) {
					$this->bar_chart($set, $i, true);
					$i--;
				} elseif ( $set['type'] == 'guide' ) {
					$this->chart_guide($set);
				}
				
				if ( $set['label'] ) $this->legend($set['type'], $set['label'], $i);
				
				$i++;
			}
			
			$chart = $this->build_chart($response);
			
			if ( $response == 'echo' ) {
				echo $chart;
			} else {
				return $chart;
			}
		}
	}
	
	
//------------------------------------------------------------
// GRAPH INI
//------------------------------------------------------------
	function chart_ini() {
		$data_total = array();
		$comparison = false;
		
		foreach ( $this->data as $array => &$set ) {
			$i = 0;
			
			foreach ( $set['points'] as &$point ) {
				$set['points'][$i] = ( $point == '' ) ? 0 : $point;
				
				$i++;
			}
			
			if ( $set['type'] == 'comparison' ) {
				$comparison = true;
				$set['points'] = array_slice($set['points'], 0, $this->max_sets);
				$set_count = count($set['points']);
				$this->data_count = $set_count;
				
				if ( $this->percent ) {
					$i = 0;
					
					foreach ( $set['points'] as &$point ) {
						$set['points'][$i] = $point * 100;
						
						$i++;
					}
				}
				
				$this->bar_total = 1;
				$data_total = $set['points'];
			} elseif ( !$comparison || $set['type'] == 'guide' ) {
				$set_count = count($set['points']);
				$this->data_count = ( !$this->data_count && $set['type'] !== 'guide' ) ? $set_count : $this->data_count;
				
				if ( $this->percent ) {
					$i = 0;
					
					foreach ( $set['points'] as &$point ) {
					
						$set['points'][$i] = $point * 100;
						
						$i++;
					}
				}
				
				$data_total = array_merge($data_total, $set['points']);
				
				if ( $set['type'] == 'bar' ) {
					$this->bar_total++;
				} elseif ( $set['type'] == 'guide' ) {
					$this->chart_guide = $set;
					unset($this->data[$array]);
				}
				
				if ( $set['type'] !== 'guide' && $set_count !== $this->data_count ) {
					return false;
				}
			}
		}
		
		$this->data_min = min( $data_total );
		$this->data_max = max( $data_total );
		
		$this->x_int_calc();
		$this->chart_range();
		$this->data_ini();
		
		if ( $this->x_axis() ) {	
			$this->hash = $this->hash();
			
			return true;
		} else {
			return false;
		}
	}
	
	function chart_range() {
		$data_range = $this->data_max - $this->data_min;
		$guide_gap = $this->guide_count - 1;
		$place = floor( log10( ( $data_range / $guide_gap ) ) );
		$place = ( $this->rank ) ? $place = 0 : $place;
		$neg = ( $place <= 0 ) ? 1 : 0;
		$this->currency_place = ( $place < 0 ) ? 2 : 0;
		$odd_even = ( ( $place > 0 && !( $place & 1 ) ) || $place == 0 || ( $place < 0 && ( $place & 1 ) ) ) ? 2 : 1;
		$range_int = ( $place > 0 ) ? pow(10, ( $place - $odd_even ) ) * 5 * $odd_even : pow(10, ( $place ) );
		
		if ( is_null($this->chart_min) ) {
			$this->chart_min = ( $range_int ) ? floor( $this->data_min / $range_int ) * $range_int : 0;
			$this->chart_min = ( $this->chart_min == $this->data_min && $this->chart_min ) ? ( floor( $this->data_min / $range_int ) - 1 ) * $range_int : $this->chart_min;
			$this->chart_min = ( $this->rank && $this->chart_min < 1 ) ? $this->chart_min = 1 : $this->chart_min;
			$this->chart_min = ( $this->percent && $this->chart_min < 0 ) ? $this->chart_min = 0 : $this->chart_min;
		}
		
		if ( is_null($this->chart_max) ) {
			$chart_range = ( $range_int ) ? ceil( ( $this->data_max - $this->chart_min ) / ( $range_int * $guide_gap ) ) * $range_int * $guide_gap : 0;
			$this->chart_max = $this->chart_min + $chart_range;
			$chart_range = ( $this->rank && $this->chart_max == $this->data_max ) ? $chart_range + ( $range_int * $guide_gap ) : $chart_range;
		} else {
			$chart_range = $this->chart_max - $this->chart_min;
		}
		
		if ( $this->percent && $this->chart_max > 100 ) {
			$this->chart_max = 100;
			$chart_range = ceil( ( $this->chart_max - $this->data_min ) / ( $range_int * $guide_gap ) ) * $range_int * $guide_gap;
			$this->chart_min = $this->chart_max - $chart_range;
		}
		$this->data_adjust = ( $chart_range ) ? $this->chart_height_data / $chart_range : 0;
		
		$this->guides($chart_range);
	}
	
	
//------------------------------------------------------------
// X INT CALC
//------------------------------------------------------------
	function x_int_calc() {
		$this->chart_width_legend = $this->chart_width - $this->chart_margin_x;
		$this->chart_width_data = $this->chart_width_legend - ( $this->chart_padding_x * 2 );
		
		if ( $this->bar_total ) {
			$this->bar_width = $this->chart_width_data / ( ( ( $this->bar_total + 1 ) * ( $this->data_count - 1 ) ) + $this->bar_total );
			$this->chart_padding_x = $this->chart_padding_x_base + ( $this->bar_width * ( $this->bar_total / 2 ) );
			$this->chart_width_data = $this->chart_width_legend - ( $this->chart_padding_x * 2 );
		}
		
		$this->x_int = ( $this->data_count > 1 ) ? $this->chart_width_data / ( $this->data_count - 1 ) : $this->chart_width_data / 2;
	}
	
	
//------------------------------------------------------------
// DATA INI
//------------------------------------------------------------
	function data_ini() {
		foreach ( $this->data as &$set ) {
			$i = 0;
			$set['points_x'] = array();
			$set['points_y'] = array();
			$set['labels_x'] = array();
			$set['labels_y'] = array();
			$set['labels_text'] = array();
			
			foreach ( $set['points'] as $point ) {
				$point_y = $this->y_calc($point);
				if ( $set['type'] == 'line' ) {
					$point_x = ( $this->x_int * $i ) + $this->chart_margin_x + $this->chart_padding_x;
					$label_x = $point_x;
					$label_y = $point_y - ( $this->point_size / 2) - $this->point_stroke - $this->label_offset;
				} elseif ( $set['type'] == 'bar' || $set['type'] == 'comparison' ) {
					$point_x = ( $this->x_int * $i ) + ( $this->bar_width * $this->bar_count ) - ( $this->bar_width * ( $this->bar_total / 2 ) ) + $this->chart_margin_x + $this->chart_padding_x;
					$label_x = $point_x + ( $this->bar_width * .5 );
					$label_y = $point_y - ( $this->point_size / 2 ) - $this->label_offset;
				}
				$label_text = $this->chart_number( $point, 1 );
				
				array_push($set['points_x'], $point_x);
				array_push($set['points_y'], $point_y);
				array_push($set['labels_x'], $label_x);
				array_push($set['labels_y'], $label_y);
				array_push($set['labels_text'], $label_text);
				
				$i++;
			}
			
			if ( $set['type'] == 'bar' ) {
				$this->bar_count++;
			}
		}
		
		$points = array();
		$conflicts = array();
		
		for ( $column1 = 0; $column1 < $this->data_count; $column1++ ) {
			$row1 = 0;
			
			foreach ( $this->data as &$set ) {
				$conflict = 0;
				
				for ( $column2 = 0; $column2 < $this->data_count; $column2++ ) {
					$row2 = 0;
					
					foreach ( $this->data as &$set ) {
						if ( $this->conflict($column1, $row1, $column2, $row2) ) {
							$conflict++;
						}
						
						$row2++;
					}
				}
				
				$point = $column1 . ',' . $row1;
				
				array_push($points, $point);
				array_push($conflicts, $conflict);
				
				$row1++;
			}
		}
		
		array_multisort($conflicts, SORT_DESC, SORT_NUMERIC, $points, SORT_ASC, SORT_NUMERIC);
		
		foreach ( $points as $point ) {
			$point_array = explode(',', $point);
			$column1 = $point_array[0];
			$row1 = $point_array[1];
			$row2 = 0;
			$conflict = 0;
			
			foreach ( $this->data as &$set ) {
				for ( $column2 = 0; $column2 < $this->data_count; $column2++ ) {
					if ( $this->conflict($column1, $row1, $column2, $row2) ) {
						$conflict++;
					}
				}
				
				$row2++;
			}
			
			if ( $conflict ) {
				$this->data[$row1]['labels_text'][$column1] = '';
			}
		}
	}
	
	
//------------------------------------------------------------
// Y CALC
//------------------------------------------------------------
	function y_calc($point) {
		if ( $this->data_adjust ) {
			if ( $this->rank ) {
				$y = ( ( $point - $this->chart_min ) * $this->data_adjust ) + $this->chart_margin_y;
			} else {
				$y = ( ( $this->chart_max - $point ) * $this->data_adjust ) + $this->chart_margin_y;
			}
		} else {
			$y = $this->chart_height_data + $this->chart_margin_y;
		}
		
		return $y;
	}
	
	
//------------------------------------------------------------
// CONFLICT
//------------------------------------------------------------
	function conflict($column1, $row1, $column2, $row2) {
		if ( !( $column1 == $column2 && $row1 == $row2 ) ) {
			$label1_width = $this->label_width($this->data[$row1]['labels_text'][$column1], $this->label_size, $this->label_font_weight);
			$label1_left = $this->data[$row1]['labels_x'][$column1] - ( $label1_width / 2 );
			$label1_right = $this->data[$row1]['labels_x'][$column1] + ( $label1_width / 2 );
			
			if ( $label1_left < $this->chart_margin_x || $label1_right > $this->chart_width ) {
				return true;
			} else {
				if ( $this->data[$row2]['labels_text'][$column2] !== '' ) {
					$label1_top = $this->data[$row1]['labels_y'][$column1] + ( $this->label_size / 1.8 );
					$label1_bottom = $this->data[$row1]['labels_y'][$column1] - ( $this->label_size / 1.8 );
					
					$label2_top = $this->data[$row2]['labels_y'][$column2] + ( $this->label_size / 1.8 );
					$label2_bottom = $this->data[$row2]['labels_y'][$column2] - ( $this->label_size / 1.8 );
					
					if ( ( $label1_top == $label2_top ) || ( $label1_top > $label2_bottom && $label1_top < $label2_top ) || ( $label2_top > $label1_bottom && $label2_top < $label1_top ) ) {
						$label2_width = $this->label_width($this->data[$row2]['labels_text'][$column2], $this->label_size, $this->label_font_weight);
						$label2_left = $this->data[$row2]['labels_x'][$column2] - ( $label2_width / 2 );
						$label2_right = $this->data[$row2]['labels_x'][$column2] + ( $label2_width / 2 );
						
						if ( ( $label1_left == $label2_left ) || ( $label1_right > $label2_left && $label1_right < $label2_right ) || ( $label1_left > $label2_left && $label1_left < $label2_right ) ) {
							 return true;
						}
					}
				}
			}
		}
		
		return false;
	}
	
	
//------------------------------------------------------------
// GUIDES
//------------------------------------------------------------
	function guides($chart_range) {
		$label_max_width = 0;
		$guides = null;
		$guide_int = $chart_range / ( $this->guide_count - 1 );
		
		for ( $i = 0; $i < $this->guide_count; $i++ ) {
			$label = ( $this->rank ) ? $this->chart_number( $this->chart_min + ( $i * $guide_int ), 1, true ) : $this->chart_number( $this->chart_max - ( $i * $guide_int ), 1, true );
			$label_width = $this->label_width($label, $this->guide_label_y_size, $this->guide_label_y_font_weight);
			$label_max_width = ( $label_width > $label_max_width ) ? $label_width : $label_max_width;
		}
		
		if ( ( $label_max_width / $this->guide_label_offset ) > $this->chart_margin_x ) {
			$this->chart_margin_x = $label_max_width / $this->guide_label_offset;
			$this->x_int_calc();
		}
		
		$x1 = $this->chart_margin_x;
		$x2 = $x1 + $this->chart_width_legend;
		$label_x = $this->chart_margin_x * $this->guide_label_offset;
		
		$i = 0;
		while ( $i < $this->guide_count ) {
			$i = ( $this->data_adjust ) ? $i : $this->guide_count - 1;
			$y = ( $this->data_adjust ) ? ( $i * $guide_int * $this->data_adjust ) + $this->chart_margin_y + ( $this->guide_width / 2 ) : $this->chart_height_data + $this->chart_margin_y + ( $this->guide_width / 2 );
			$label = ( $this->rank ) ? $this->chart_number( $this->chart_min + ( $i * $guide_int ), 1, true ) : $this->chart_number( $this->chart_max - ( $i * $guide_int ), 1, true );
			$color = ( $i == $this->guide_count - 1 ) ? $this->base_line_color : $this->guide_color;
			
			$guides .= ( $color ) ? '<line class="guide" x1="' . $x1 . '" y1="' . $y . '" x2="' . $x2 . '" y2="' . $y . '" stroke="' . $color . '" stroke-width="' . $this->guide_width . '" />' : '';
			if ( !$this->rank || ( $i < $this->guide_count - 1 && $this->rank ) ) {
				$guides .= $this->label('guide_label_y', $label_x, $y, $label, $i);
			}
			
			$i++;
		}
		
		if ( $this->show_y_axis ) {
			$y_axis_x = $this->chart_margin_x + ( $this->guide_width / 2 );
			$y_axis_y1 = 0;
			$y_axis_y2 = $this->chart_height_data + $this->chart_margin_y;
			
			$guides .= '<line class="guide" x1="' . $y_axis_x . '" y1="' . $y_axis_y1 . '" x2="' . $y_axis_x . '" y2="' . $y_axis_y2 . '" stroke="' . $this->base_line_color . '" stroke-width="' . $this->guide_width . '" />';
		}
		
		$this->plot .= $guides;
	}
	
	
//------------------------------------------------------------
// X AXIS
//------------------------------------------------------------
	function x_axis() {
		$x_axis = null;
		$y = $this->chart_height_data + ( $this->chart_padding_y * .7 ) + $this->chart_margin_y;
		
		if ( is_array($this->labels_x) && array_key_exists('type', $this->labels_x) && array_key_exists('start', $this->labels_x) ) {
			switch( $this->labels_x['type'] ) {
				case 'daily' :
					$type = 'day';
					$format = 'D';
					break;
				case 'monthly' :
					$type = 'month';
					$format = 'M';
					break;
				default :
					$type = 'year';
					$format = 'Y';
					break;
			}
			
			for ( $i = 0; $i < $this->data_count; $i++ ) {
				$x = ( $this->x_int * $i ) + $this->chart_margin_x + $this->chart_padding_x;
				$date_offset = '+' . $i . ' ' . $type;
				$date = strtotime($date_offset, $this->labels_x['start']);
				$date_label = date($format, $date);
				$x_axis .= $this->label('guide_label_x', $x, $y, $date_label, $i);
			}
			
			$this->plot .= $x_axis;
			
			return true;
		} elseif ( is_array($this->labels_x) && array_key_exists('labels', $this->labels_x) && is_array($this->labels_x['labels']) && count( $this->labels_x['labels'] ) == count( $this->data[0]['points'] ) ) {
			$i = 0;
			$label_width_previous = null;
			$label_text = null;
			$label_width = null;
			$label_width_next = null;
			
			foreach ( $this->labels_x['labels'] as $label ) {
				if ( !$label_width_previous ) {
					$label_width_previous = $this->chart_margin_x + $this->chart_padding_x;
					$label_text = $label;
					$label_width = $this->label_width($label, $this->guide_label_x_size, $this->guide_label_x_font_weight);
				} else {
					$label_width_next = $this->label_width($label, $this->guide_label_x_size, $this->guide_label_x_font_weight);
					$space_before = ( $this->x_int * 2 ) - $label_width_previous;
					$space_after = ( $this->x_int * 2 ) - $label_width_next;
					$space_min = min($space_before, $space_after);
					
					$label_text = $this->label_fit($label_text, $label_width, $this->guide_label_x_size, $this->guide_label_x_font_weight, $space_min);
					$x = ( $this->x_int * ( $i - 1 ) ) + $this->chart_margin_x + $this->chart_padding_x;
					$x_axis .= $this->label('guide_label_x', $x, $y, $label_text, $i);
					
					$label_width_previous = $label_width;
					$label_text = $label;
					$label_width = $label_width_next;
				}
				
				$i++;
			}
			
			$space_before = ( $this->x_int * 2 ) - $label_width_previous;
			$space_after = $this->x_int;
			$space_min = min($space_before, $space_after);
			
			$label_text = $this->label_fit($label_text, $label_width, $this->guide_label_x_size, $this->guide_label_x_font_weight, $space_min);
			$x = ( $this->x_int * ( $i - 1 ) ) + $this->chart_margin_x + $this->chart_padding_x;
			$x_axis .= $this->label('guide_label_x', $x, $y, $label_text, $i);
			
			$this->plot .= $x_axis;
			
			return true;
		}
		
		return false;
	}
	
	
//------------------------------------------------------------
// LEGEND
//------------------------------------------------------------
	function legend($type, $label, $iteration) {
		if ( $type !== 'comparison' ) {
			$legend_item_width = $this->chart_width_data / $this->set_count;
			$x = ( $legend_item_width * $iteration ) + $this->chart_margin_x;
			$y = $this->chart_height_data + ( $this->chart_padding_y * 1.4 ) + $this->chart_margin_y;
			$width = $this->chart_margin_y / 2;
			$label_x = $x + ( $width * 1.5 );
			$label_y = $y + $width - ( $this->legend_font_adjust * $this->legend_size);
			$color = ( $type == 'guide' ) ? $this->chart_guide_color : $this->line_color[$iteration];
			
			$legend_label_width = $this->label_width($label, $this->legend_size, $this->legend_font_weight);
			$label = $this->label_fit($label, $legend_label_width, $this->legend_size, $this->legend_font_weight, $legend_item_width);
			$legend = '<rect x="' . $x . '" y="' . $y . '" width="' . $width . '" height="' . $width . '" fill="' . $color . '"/>';
			$legend .= $this->label('legend', $label_x, $label_y, $label);
			
			$this->plot .= $legend;
		}
	}
	
	
//------------------------------------------------------------
// HASH
//------------------------------------------------------------
	function hash() {
		$hash = $this->version . $this->chart_name . $this->data_type . $this->chart_min . $this->chart_max . $this->chart_width . $this->chart_height . $this->guide_count . $this->chart_padding_x . $this->chart_padding_y . $this->chart_margin_x . $this->chart_margin_y;
		foreach ( $this->data as $set ) {
			$hash .= $set['label'] . $set['type'] . implode('', $set['points']);
		}
		if ( array_key_exists('type', $this->labels_x) ) {
			$hash .= $this->labels_x['type'];
			$hash .= $this->labels_x['start'];
		} else {
			foreach ( $this->labels_x['labels'] as $label ) {
				$hash .= $label;
			}
		}
		$hash = md5($hash);
		
		return $hash;
	}
	
	
//------------------------------------------------------------
// LINE CHART
//------------------------------------------------------------
	function line_chart($set, $iteration) {
		$curve_handle_multiplier = $this->curve_handle_weight / 10;
		$points_x = $set['points_x'];
		$points_y = $set['points_y'];
		$labels_y = $set['labels_y'];
		$labels_text = $set['labels_text'];
		$line = null;
		$dots = null;
		$labels = null;
		
		for ( $i = 0; $i < $this->data_count; $i++ ) {
			$x = $points_x[$i];
			$y = $points_y[$i];
			
			$point_prev = ( $i == 0 ) ? $points_y[$i] : $points_y[$i - 1];
			$point_next = ( $i + 1 == $this->data_count ) ? $points_y[$i] : $points_y[$i + 1];
			$y_prev = $point_prev;
			$y_next = $point_next;
			$y_prev_diff = ( $i == 0 ) ? ( $y_next - $y ) : ( $y - $y_prev );
			$y_next_diff = ( $i + 1 == $this->data_count ) ? ( $y - $y_prev ) : ( $y_next - $y );
			$y_diff_min = ( abs( $y_prev_diff ) < abs( $y_next_diff ) ) ? $y_prev_diff : $y_next_diff;
			$y_prev_diff = ( $y_prev_diff > 0 ) ? ( abs( $y_diff_min ) * $curve_handle_multiplier ) : ( abs( $y_diff_min ) * -1 * $curve_handle_multiplier );
			$y_next_diff = ( $y_next_diff > 0 ) ? ( abs( $y_diff_min ) * $curve_handle_multiplier ) : ( abs( $y_diff_min ) * -1 * $curve_handle_multiplier );
			
			$handle_x1 = $x - ( $this->x_int * $curve_handle_multiplier );
			$handle_x2 = $x + ( $this->x_int * $curve_handle_multiplier );
			$handle_y1 = $y - $y_prev_diff;
			$handle_y2 = $y + $y_next_diff;
			
			if ( ( $y_prev_diff > 0 && $y_next_diff < 0 ) || ( $y_prev_diff < 0 && $y_next_diff > 0 ) ) {
				$handle_y1 = $y;
				$handle_y2 = $y;
			}
			
			if ( $i == 0 ) {
				$line .= 'M' . $x . ',' . $y . ' C' . $handle_x2 . ',' . $handle_y2;
			} elseif ( $i + 1 == $this->data_count ) {
				$line .= ' ' . $handle_x1 . ',' . $handle_y1 . ' ' . $x . ',' . $y;
			} else {
				$line .= ' ' . $handle_x1 . ',' . $handle_y1 . ' ' . $x . ',' . $y . ' C' . $handle_x2 . ',' . $handle_y2	;
			}
			$dots .= '<circle id="pointA" cx="' . $x . '" cy="' . $y . '"  r="' . $this->point_size . '" />';
			$this->plot_labels .= ( $this->show_all_labels || ( !$i || $i == $this->data_count - 1 ) ) ? $this->label('label', $x, $labels_y[$i], $labels_text[$i], $iteration) : '';
		}
		
		
		if ( count($points_x) > 1 ) $this->plot_lines .= '<path class="points" d="' . $line . '" stroke="' . $this->line_color[$iteration] . '" stroke-width="' . $this->line_width . '" fill="none" />';
		$this->plot_lines .= '<g fill="' . $this->point_fill_color[$iteration] . '" stroke="' . $this->point_stroke_color[$iteration] . '" stroke-width="' . $this->point_stroke . '">' . $dots . '</g>';
	}
	
	
//------------------------------------------------------------
// BAR CHART
//------------------------------------------------------------
	function bar_chart($set, $iteration, $comparison = false) {
		$points_x = $set['points_x'];
		$points_y = $set['points_y'];
		$labels_x = $set['labels_x'];
		$labels_y = $set['labels_y'];
		$labels_text = $set['labels_text'];
		$bars = null;
		$labels = null;
		
		for ( $i = 0; $i < $this->data_count; $i++ ) {
			$height = $this->chart_height_data - $points_y[$i] + $this->chart_margin_y;
			
			if ( $height > .5 ) {
				$height_total = $height + ( $this->box_border_width / 2 );
				$color = ( $comparison ) ? $i : $iteration;
				
				$this->plot_bars .= '<rect x="' . $points_x[$i] . '" y="' . $points_y[$i] . '" width="' . $this->bar_width . '" height="' . $height_total . '" fill="' . $this->line_color[$color] . '" stroke="' . $this->box_border_color . '" stroke-width="' . $this->box_border_width . '"/>';
			}
			
			$this->plot_labels .= ( $this->show_all_labels || ( !$i || $i == $this->data_count - 1 ) ) ? $this->label('label', $labels_x[$i], $labels_y[$i], $labels_text[$i], $iteration) : '';
		}
	}
	
	
//------------------------------------------------------------
// CHART GUIDE
//------------------------------------------------------------
	function chart_guide($set) {
		$x1 = $this->chart_margin_x;
		$x2 = $x1 + $this->chart_width_legend;
		$y = $this->y_calc($set['points'][0]) + ( $this->guide_width / 2 );
		$dash_width = ( $this->chart_guide_dash ) ? $this->chart_width_legend / ( ( $this->chart_guide_dash * 2 ) - 1 ) : null;
		$dashed = ( $this->chart_guide_dash ) ? ' stroke-dasharray="' . $dash_width . ' ' . $dash_width . '"' : '';
		
		$this->plot_guides = '<line class="guide" x1="' . $x1 . '" y1="' . $y . '" x2="' . $x2 . '" y2="' . $y . '" stroke="' . $this->chart_guide_color . '" stroke-width="' . $this->guide_width . '"' . $dashed . ' />';
	}
	
	
//------------------------------------------------------------
// LABEL FIT
//------------------------------------------------------------
	function label_fit($label, $label_width, $text_size, $weight, $space) {
		$label_length = strlen($label);
		$ell = ' ... ';
		$ell_width = $this->label_width($ell, $text_size, $weight);
		$ell_length = strlen($ell);
		
		if ( $label_length > $ell_length + 2 && $label_width > $space ) {
			$max = floor( ( ( $space - $ell_width ) / $label_width ) * $label_length );
			$half = $max / 2;
			$first = ceil($half);
			$last = floor($half) * -1;
			$first = max($first, 1);
			$last = min($last, -1);
			
			$label = substr($label, 0, $first) . $ell . substr($label, $last);
		}
		
		return $label;
	}
	
	
//------------------------------------------------------------
// LABEL WIDTH
//------------------------------------------------------------
	function label_width($label, $text_size, $weight) {
		$label_length = strlen( $label );
		$punctuation = array(',', '.');
		$label_punctuation = $label_length - strlen( str_replace($punctuation, '', $label) );
		$label_width = ( ( $label_length - $label_punctuation ) * $text_size * .57 ) + ( $label_punctuation * $text_size * .55 );
		$label_width = ( $weight == 'bold' || $weight == 'italic' ) ? $label_width * 1 : $label_width;
		
		return $label_width;
	}
	
	
//------------------------------------------------------------
// LABEL
//------------------------------------------------------------
	function label($type, $x, $y, $text, $iteration = 0) {
		$label = null;
		$text_stroke = $type . '_stroke';
		$text_color = $type . '_color';
		$text_font_weight = $type . '_font_weight';
		$text_font = $type . '_font';
		$text_size = $type . '_size';
		$text_stroke_color = $type . '_stroke_color';
		$text_stroke = $type . '_stroke';
		$text_anchor = $type . '_anchor';
		
		if ( $text !== '' ) {
			if ( $this->$text_stroke ) {
				$label .= '<text x="' . $x . '" y="' . $y . '" fill="' . $this->$text_color . '" font-weight="' . $this->$text_font_weight . '" font-family="' . $this->$text_font . '" font-size="' . $this->$text_size . '" stroke="' . $this->$text_stroke_color . '" stroke-width="' . $this->$text_stroke . '" stroke-linecap="round" stroke-linejoin="round" stroke-opacity="' . $this->label_stroke_opacity . '" text-anchor="' . $this->$text_anchor . '">' . $text. '</text>';
			}
			$label .= '<text x="' . $x . '" y="' . $y . '" fill="' . $this->$text_color . '" font-weight="' . $this->$text_font_weight . '" font-family="' . $this->$text_font . '" font-size="' . $this->$text_size . '" text-anchor="' . $this->$text_anchor . '">' . $text . '</text>';
		}
		
		return $label;
	}
	
	
//------------------------------------------------------------
// GRAPH NUMBER
//------------------------------------------------------------
	function chart_number($num, $decimals, $drop_blank_zeros = false) {
		$drop_blank_zeros = ( $this->drop_decimals ) ? true : $drop_blank_zeros;
		$decimals = ( $this->currency ) ? 2 : $decimals;
		$num_decimals = explode('.', $num);
		$last_decimal = ( count($num_decimals) > 1 && strlen($num_decimals[1]) >= $decimals ) ? substr($num_decimals[1], $decimals) : false;
		$num = ( $last_decimal && $last_decimal !== 0 ) ? ceil($num * pow(10, $decimals)) / pow(10, $decimals) : $num;
		$num = ( $drop_blank_zeros && $this->currency ) ? number_format( $num, $this->currency_place, '.', ',' ) : number_format( $num, $decimals, '.', ',' );
		$num = ( ( $drop_blank_zeros || !$this->percent ) && !$this->currency ) ? preg_replace('/\.?0*$/', '', $num) : $num;
		$num = ( $this->percent && !$drop_blank_zeros ) ? $num . '%' : $num;
		$num = ( $this->currency ) ? '$' . $num : $num;
		
		return $num;
	}
	
	
//------------------------------------------------------------
// BUILD GRAPH
//------------------------------------------------------------
	function build_chart($response) {
		$chart = '<svg xmlns="http://www.w3.org/2000/svg" version="1.1" width="' . $this->chart_width . '" height="' . $this->chart_height . '" style="background: ' . $this->chart_color . ';">';
		$chart .= ( $this->chart_color ) ? '<rect x="0" y="0" width="' . $this->chart_width . '" height="' . $this->chart_height . '" fill="' . $this->chart_color . '"/>' : '';
		$chart .= $this->plot_guides;
		$chart .= $this->plot_bars;
		$chart .= $this->plot_lines;
		$chart .= $this->plot;
		$chart .= $this->plot_labels;
		$chart .= '</svg>';
		
		$chart_svg_name = $this->svg_path . $this->hash . '.svg';
		$chart_svg_server = $this->main_path . $chart_svg_name;
		$chart_svg_www = $this->www_path . $chart_svg_name;
		
		$chart_png_name = $this->png_path . $this->hash . '.png';
		$chart_png_server = $this->main_path . $chart_png_name;
		$chart_png_www = $this->www_path . $chart_png_name;
		
		if ( !file_exists($chart_svg_server) || $response ) {
			$chart_svg = fopen($chart_svg_server, 'w');
			fwrite($chart_svg, $chart);
			fclose($chart_svg);
		}
		
		if ( file_exists($chart_png_server) && filesize($chart_png_server) ) {
			if ( $response !== 'url' ) {
				$chart = '<img src="' . $chart_png_www . '" alt="' . $this->chart_name . '" width="' . $this->chart_width . '" height="' . $this->chart_height . '" />';
			} else {
				$chart = $chart_png_www;
			}
		}
		
		return $chart;
	}
}


//------------------------------------------------------------
// TEST
//------------------------------------------------------------
function chrt_test($num, $tens_place = null) {
	
	$min_sets = 1;
	$max_sets = 4;
	$min_points = 3;
	$max_points = 12;
	
	for ( $i1 = 0; $i1 < $num; $i1++ ) {
		$sets = rand($min_sets, $max_sets);
		$points = rand($min_points, $max_points);
		$date = strtotime(date('y:m:d'));
		$date_types = array(
			'daily',
			'monthly',
			'yearly'
		);
		$date_type = $date_types[rand(0,2)];
		$data_types = array(
			null,
			'rank',
			'percent'
		);
		$data_type = ( $tens_place ) ? null : $data_types[rand(0,2)];
		$data_min = ( $data_type == 'rank' ) ? 1 : 0;
		$data_max = ( $data_type == 'percent' ) ? 100 : 1000;
		$data = array();
		
		for ( $i2 = 0; $i2 < $sets; $i2++ ) {
			$chart_types = array(
				'line',
				'bar'
			);
			$chart_type = $chart_types[rand(0,1)];
			$set_points = array();
			
			for ( $i3 = 0; $i3 < $points; $i3++ ) {
				$point = rand($data_min, $data_max);
				$point = ( $data_type == 'percent' ) ? ( $point / 100 ) : $point;
				$point = $point * pow(10, $tens_place);
				array_push($set_points, $point);
			}
			
			$set = array(
				'label' => $i2,
				'type' => $chart_type,
				'points' => $set_points
			);
			
			array_push($data, $set);
		}
		
		$$i1 = new chrt($i1, $data, $date_type, $date, $data_type);
		$$i1->chart(true);
	}
}

chrt_test(10);
?>