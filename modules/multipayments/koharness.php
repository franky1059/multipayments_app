<?php
// Configuration for koharness - builds a standalone skeleton Kohana app for running unit tests
return array(
	'modules' => array(
		'multipayments' => __DIR__,
		'database'   => __DIR__ . '/vendor/kohana/database',   // Database access
		'orm'        => __DIR__ . '/vendor/kohana/orm',        // Object Relationship Mapping
		'unittest' => __DIR__ . '/vendor/kohana/unittest'
	),
);
