<?php

	elgg_register_event_handler("init", "system", "ffd_modifications_init");
	
	function ffd_modifications_init() {
		// deregister group tools group default access
		elgg_unregister_plugin_hook_handler("access:default", "user", "group_tools_access_default_handler");
		elgg_unextend_view("groups/edit", "group_tools/forms/default_access");
		
		// register actions
		elgg_register_action("ffd_modifications/fix_access", dirname(__FILE__) . "/actions/fix_access.php", "admin");
	}