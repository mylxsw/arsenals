<?php
return array(
	'before_system' => array(
		array(
			'class'	=> 'Demo\\hooks\\DemoHook',
			'method' => 'beforeSystem1'
		),
		array(
			'class'	=> 'Demo\\hooks\\DemoHook',
			'method' => 'beforeSystem2',
			'static' => true
		)
	)	
);