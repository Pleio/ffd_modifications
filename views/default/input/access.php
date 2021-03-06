<?php
/**
 * Elgg access level input
 * Displays a dropdown input field
 *
 * @uses $vars['value']          The current value, if any
 * @uses $vars['options_values'] Array of value => label pairs (overrides default)
 * @uses $vars['name']           The name of the input field
 * @uses $vars['entity']         Optional. The entity for this access control (uses access_id)
 * @uses $vars['class']          Additional CSS class
 */

if (isset($vars['class'])) {
	$class = "elgg-input-access {$vars['class']}";
} else {
	$class = "elgg-input-access";
}

$defaults = array(
	'disabled' => false,
	'value' => get_default_access(),
	'options_values' => get_write_access_array(),
);

if (isset($vars['entity'])) {
	$defaults['value'] = $vars['entity']->access_id;
	unset($vars['entity']);
}

$vars = array_merge($defaults, $vars);

if ($vars['value'] == ACCESS_DEFAULT) {
	$vars['value'] = get_default_access();
}

if (!elgg_in_context("admin") && !elgg_in_context("widgets") && !elgg_in_context("thewire") && !elgg_in_context("menu_builder_form")) {
	$value = elgg_extract("value", $vars);
	
	$access_id_string = get_readable_access_level($value);
	$access_id_string = htmlspecialchars($access_id_string, ENT_QUOTES, 'UTF-8', false);
	
	echo "<span class='" . $class . "'>" . $access_id_string . "</span>";
	echo elgg_view("input/hidden", $vars);
} elseif (is_array($vars['options_values']) && sizeof($vars['options_values']) > 0) {
	echo elgg_view('input/dropdown', $vars);
}
