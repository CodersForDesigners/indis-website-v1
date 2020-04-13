<?php

require_once __DIR__ . '/../inc/above.php';

global $wp_roles;


// Roles and their corresponding capabilities
$rolesAndCorrespondingCapabilities = $wp_roles->roles;


// Capabilities of the user user
$capabilities__currentUser = get_userdata( get_current_user_id() );


// Edit capabilities of roles


dd( [
	// $administratorRole,
	$capabilities__currentUser,
	$rolesAndCorrespondingCapabilities
] );
