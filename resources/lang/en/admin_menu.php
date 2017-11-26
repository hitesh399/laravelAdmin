<?php 

return [

	[
		'icon'=>'<i class="material-icons">home</i>',
		'title'=>'Dashboard',
		'visibile_if_permission_of'=>[],
		'tab_active_if_current_page_is'=>['dashboard'],
		'link'=>'dashboard',
		'child'=>[]
	],
	[
		'icon'=>'<i class="material-icons">verified_user</i>',
		'title'=>'Roles',
		'visibile_if_permission_of'=>['list-role'],
		'tab_active_if_current_page_is'=>['role*'],
		'link'=>'role',
		'child'=>[]
	],
	[
		'icon'=>'<i class="material-icons">settings_input_hdmi</i>',
		'title'=>'Admin Access Permissions',
		'visibile_if_permission_of'=>['list-permission'],
		'tab_active_if_current_page_is'=>['permission*'],
		'link'=>'permission',
		'child'=>[]
	],
	[
		'icon'=>'<i class="material-icons">subject</i>',
		'title'=>'Email Template',
		'visibile_if_permission_of'=>['list-email-template'],
		'tab_active_if_current_page_is'=>['email-template*'],
		'link'=>'email-template',
		'child'=>[]
	],

	[
		'icon'=>'<i class="material-icons">settings_applications</i>',
		'title'=>'Settings',
		'visibile_if_permission_of'=>['list-setting'],
		'tab_active_if_current_page_is'=>['setting*'],
		'link'=>'setting',
		'child'=>[]
	]
];