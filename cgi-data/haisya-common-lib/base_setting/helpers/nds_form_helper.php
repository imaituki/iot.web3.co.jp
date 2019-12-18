<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

// ------------------------------------------------------------------------

/**
 * Text Input Field
 * 
 * @access	public
 * @param	mixed
 * @param	array
 * @param	string
 * @return	string
 */
if ( ! function_exists('form_nds_input'))
{

	function form_nds_input($data = '', $db_value_array = array(), $extra = '')
	{
		//第一引数に配列は認めない
		if (is_array($data))
		{
			$data = "";
		}

		$db_value = isset($db_value_array[$data]) ? $db_value_array[$data] : '';
		$value = set_value($data, $db_value);

		$defaults = array('type' => 'text', 'name' => $data, 'value' => $value);

		return "<input "._parse_form_attributes($data, $defaults).$extra." />";
	}
}

// --------------------------------------------------------------------

/**
 * Password Field
 * 
 * Identical to the input function but adds the "password" type
 *
 * @access	public
 * @param	mixed
 * @param	string
 * @param	string
 * @return	string
 */
if ( ! function_exists('form_nds_password'))
{
	function form_nds_password($data = '', $db_value_array = array(), $extra = '')
	{
		//第一引数に配列は認めない
		if (is_array($data))
		{
			$data = "";
		}

		$db_value = isset($db_value_array[$data]) ? $db_value_array[$data] : '';
		$value = set_value($data, $db_value);

		$defaults = array('type' => 'password', 'name' => $data, 'value' => $value);

		return "<input "._parse_form_attributes($data, $defaults).$extra." />";
	}
}

// --------------------------------------------------------------------

/**
 * Checkbox Field
 *
 * @access	public
 * @param	mixed
 * @param	string
 * @param	bool
 * @param	string
 * @return	string
 */
if ( ! function_exists('form_nds_checkbox'))
{
	function form_nds_checkbox($data = '', $value = '', $db_value_array = array(), $extra = '')
	{
		//第一引数に配列は認めない
		if (is_array($data))
		{
			$data = "";
		}

		$defaults = array('type' => 'checkbox', 'name' => $data, 'value' => $value);

		$db_value = isset($db_value_array[$data]) ? $db_value_array[$data] : '';

		$checked_str = "";

		//複数選択のチェックボックスの場合を考慮
		if ( ! is_array($db_value))
		{
			$checked_str = nds_set_checkbox($data, $value, ($db_value === $value));
		}
		else
		{
			//自社のメソッドを呼び出す
			$checked_str = nds_set_checkbox($data, $value, in_array($value, $db_value));
		}

		if (is_not_blank($checked_str))
		{
			$defaults['checked'] = 'checked';
		}
		else
		{
			unset($defaults['checked']);
		}

		return "<input "._parse_form_attributes($data, $defaults).$extra." />";
	}
}

// --------------------------------------------------------------------

/**
 * Checkbox Field
 * ※複数選択
 * @access	public
 * @param	mixed
 * @param	string
 * @param	bool
 * @param	string
 * @return	string
 */
if ( ! function_exists('form_nds_multi_checkbox'))
{
	function form_nds_multi_checkbox($data = '', $value = '', $db_value_array = array(), $extra = '')
	{
		//第一引数に配列は認めない
		if (is_array($data))
		{
			$data = "";
		}

		$defaults = array('type' => 'checkbox', 'name' => $data . '[]', 'value' => $value);

		$db_value = isset($db_value_array[$data]) ? $db_value_array[$data] : '';

		$checked_str = "";

		//複数選択のチェックボックスの場合を考慮
		if ( ! is_array($db_value))
		{
			//自社のメソッドを呼び出す
			$checked_str = nds_set_checkbox($data, $value, ($db_value === $value));
		}
		else
		{
			//自社のメソッドを呼び出す
			$checked_str = nds_set_checkbox($data, $value, in_array($value, $db_value));
		}

		if (is_not_blank($checked_str))
		{
			$defaults['checked'] = 'checked';
		}
		else
		{
			unset($defaults['checked']);
		}

		return "<input "._parse_form_attributes($data, $defaults).$extra." />";
	}
}

// --------------------------------------------------------------------

/**
 * Checkbox Field
 *
 * @access	public
 * @param	mixed
 * @param	string
 * @param	bool
 * @param	string
 * @return	string
 */
if ( ! function_exists('form_nds_radio'))
{
	function form_nds_radio($data = '', $value = '', $db_value_array = array(), $extra = '')
	{
		//第一引数に配列は認めない
		if (is_array($data))
		{
			$data = "";
		}

		$defaults = array('type' => 'radio', 'name' => $data, 'value' => $value);

		$db_value = isset($db_value_array[$data]) ? $db_value_array[$data] : '';

		//自社のメソッドを呼び出す
		$checked_str = nds_set_checkbox($data, $value, ($db_value == $value));

		if (is_not_blank($checked_str))
		{
			$defaults['checked'] = 'checked';
		}
		else
		{
			unset($defaults['checked']);
		}

		return "<input "._parse_form_attributes($data, $defaults).$extra." />";
	}
}

// --------------------------------------------------------------------

/**
 * Drop-down Menu
 *
 * @access	public
 * @param	string
 * @param	array
 * @param	string
 * @param	string
 * @return	string
 */
if ( ! function_exists('form_nds_dropdown'))
{
	function form_nds_dropdown($name = '', $options = array(), $db_value_array = array(), $extra = '')
	{

		$selected = isset($db_value_array[$name]) ? $db_value_array[$name] : array();

		if ( ! is_array($selected))
		{
			$selected = array($selected);
		}

		// If no selected state was submitted we will attempt to set it automatically
		if (count($selected) === 0)
		{
			// If the form name appears in the $_POST array we have a winner!
			if (isset($_POST[$name]))
			{
				$selected = array($_POST[$name]);
			}
		}

		if ($extra != '') $extra = ' '.$extra;

		$multiple = (count($selected) > 1 && strpos($extra, 'multiple') === FALSE) ? ' multiple="multiple"' : '';

		$form = '<select name="'.$name.'"'.$extra.$multiple.">\n";

		foreach ($options as $key => $val)
		{
			$key = (string) $key;

			if (is_array($val) && ! empty($val))
			{
				$form .= '<optgroup label="'.$key.'">'."\n";

				foreach ($val as $optgroup_key => $optgroup_val)
				{
					$sel = (in_array($optgroup_key, $selected)) ? ' selected="selected"' : '';

					$form .= '<option value="'.$optgroup_key.'"'.$sel.'>'.(string) $optgroup_val."</option>\n";
				}

				$form .= '</optgroup>'."\n";
			}
			else
			{
				$sel = (in_array($key, $selected)) ? ' selected="selected"' : '';

				$form .= '<option value="'.$key.'"'.$sel.'>'.(string) $val."</option>\n";
			}
		}

		$form .= '</select>';

		return $form;
	}
}

// ------------------------------------------------------------------------

/**
 * Textarea field
 *
 * @access	public
 * @param	mixed
 * @param	string
 * @param	string
 * @return	string
 */
if ( ! function_exists('form_nds_textarea'))
{
	function form_nds_textarea($data = '', $db_value_array = array(), $extra = '')
	{
		//defaultのrowsとcolsは除去
		$defaults = array('name' => (( ! is_array($data)) ? $data : ''));

		$db_value = isset($db_value_array[$data]) ? $db_value_array[$data] : '';
		$value = set_value($data, $db_value);

		if ( ! is_array($data) OR ! isset($data['value']))
		{
			$val = $value;
		}
		else
		{
			$val = $data['value'];
			unset($data['value']); // textareas don't use the value attribute
		}

		$name = (is_array($data)) ? $data['name'] : $data;
		return "<textarea "._parse_form_attributes($data, $defaults).$extra.">".form_prep($val, $name)."</textarea>";
	}
}

// ------------------------------------------------------------------------

/**
 * チェックボックス、ラジオボタンで使用するカスタマイズしたメソッド
 *
 * Let's you set the selected value of a checkbox via the value in the POST array.
 * If Form Validation is active it retrieves the info from the validation class
 *
 * @access	public
 * @param	string
 * @param	string
 * @param	bool
 * @return	string
 */
if ( ! function_exists('nds_set_checkbox'))
{
	function nds_set_checkbox($field = '', $value = '', $default = FALSE)
	{
		if ( ! isset($_POST[$field]))
		{
			if ($default == TRUE)
			{
				return ' checked="checked"';
			}
			return '';
		}

		$field = $_POST[$field];

		if (is_array($field))
		{
			if ( ! in_array($value, $field))
			{
				return '';
			}
		}
		else
		{
			
			if (($field == '' OR $value == '') OR ($field != $value))
			{
				return '';
			}
		}

		return ' checked="checked"';
	}
}

// ------------------------------------------------------------------------

/**
 * 入力チェックエラーが存在する場合に、想定する戻り値を受け取る
 * 
 * @param unknown_type $field
 * @param unknown_type $prefix
 * @param unknown_type $suffix
 * @param unknown_type $ret_val
 */
function has_form_error($field = '', $prefix = '', $suffix = '', $ret_val = 'error')
{
	if (FALSE === ($OBJ =& _get_validation_object()))
	{
		return FALSE;
	}

	if (is_not_blank($OBJ->error($field, $prefix, $suffix)))
	{
		return $ret_val;
	}
	else
	{
		return FALSE;
	}
}
