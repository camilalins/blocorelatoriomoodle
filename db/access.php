<?php
$capabilities = array(

		'local/moodleversion:myaddinstance' => array
		(
			'captype' => 'write',
			'contextlevel' => CONTEXT_SYSTEM,
			'archetypes' => array
			(
				'manager' => CAP_ALLOW
			),
			//'clonepermissionsfrom' => 'moodle/my:manageblocks'
		),

		'local/moodleversion:addinstance' => array
		(
			'riskbitmask' => RISK_SPAM | RISK_XSS,
			'captype' => 'write',
			'contextlevel' => CONTEXT_SYSTEM,
			'archetypes' => array
			(
				'manager' => CAP_ALLOW
			),
			//'clonepermissionsfrom' => 'moodle/site:manageblocks'
		),
);
?>