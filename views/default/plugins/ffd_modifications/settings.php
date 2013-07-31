<?php

	if ($registered_objects = get_registered_entity_types("object")) {
		$default_access = (int) elgg_get_config("default_access");
		
		// unset thewire
		if (($key = array_search("thewire", $registered_objects) !== false)) {
			unset($registered_objects[$key]);
		}
		
		// check if we need to fix stuff
		$options = array(
			"type" => "object",
			"subtypes" => $registered_objects,
			"count" => true,
			"wheres" => array("(e.access_id <> " . $default_access . ")")
		);
		
		if ($count = elgg_get_entities($options)) {
			echo "<div>";
			
			$access_id_string = get_readable_access_level($default_access);
			$access_id_string = htmlspecialchars($access_id_string, ENT_QUOTES, 'UTF-8', false);
			
			echo elgg_view("output/longtext", array("value" => elgg_echo("ffd_modifications:settings:fix_access:description", array($count, $access_id_string))));
			
			echo elgg_view("output/confirmlink", array(
				"text" => elgg_echo("ffd_modifications:settings:fix_access"),
				"href" => "action/ffd_modifications/fix_access",
				"class" => "elgg-button elgg-button-submit"
			));
			
			echo "</div>";
		}
	}