<?php

	elgg_register_event_handler("init", "system", "ffd_modifications_init");
	
	function ffd_modifications_init() {
		
		elgg_extend_view("css/elgg", "css/ffd_modifications/site");
		// deregister group tools group default access
		elgg_unregister_plugin_hook_handler("access:default", "user", "group_tools_access_default_handler");
		elgg_unextend_view("groups/edit", "group_tools/forms/default_access");
		
		// register actions
		elgg_register_action("ffd_modifications/fix_access", dirname(__FILE__) . "/actions/fix_access.php", "admin");
		
		// extend discussion page handler
		elgg_register_plugin_hook_handler("route", "discussion", "ffd_modifications_route_discussion_handler");
	}
	
	function ffd_modifications_route_discussion_handler($hook, $type, $return_value, $params){
		/**
		 * $return_value contains:
		 * $return_value['handler'] => requested handler
		 * $return_value['segments'] => url parts ($page)
		 */
		$result = $return_value;
	
		if(!empty($return_value) && is_array($return_value)){
			$page = $return_value['segments'];
				
			if ($page[0] = "all") {
				$result = false;
				
				elgg_pop_breadcrumb();
				elgg_push_breadcrumb(elgg_echo('discussion'));
				
				$content = elgg_list_entities(array(
						'type' => 'object',
						'subtype' => 'groupforumtopic',
						'order_by' => 'e.last_action desc',
						'limit' => 25,
						'full_view' => false,
				));
				
				$params = array(
						'content' => $content,
						'title' => elgg_echo('discussion:latest'),
						'filter' => '',
				);
				$body = elgg_view_layout('one_column', $params);
				
				echo elgg_view_page($title, $body);
			}
		}
		
		return $result;
	}
