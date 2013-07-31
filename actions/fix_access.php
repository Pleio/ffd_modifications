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
			"limit" => false,
			"wheres" => array("(e.access_id <> " . $default_access . ")")
		);
		
		// this could take a while
		set_time_limit(0);
		
		// loop through all
		$batch = new ElggBatch("elgg_get_entities", $options);
		$total = 0;
		
		foreach ($batch as $entity) {
			$entity->access_id = $default_access;
			
			if ($entity->save()) {
				$total++;
			}
		}
		
		system_message(elgg_echo("ffd_modifications:action:fix_access", array($total)));
	}
	
	forward(REFERER);