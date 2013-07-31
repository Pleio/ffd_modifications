<?php

	elgg_register_event_handler("init", "system", "ffd_modifications_init");
	
	function ffd_modifications_init() {
		// register actions
		elgg_register_action("ffd_modifications/fix_access", dirname(__FILE__) . "/actions/fix_access.php", "admin");
	}