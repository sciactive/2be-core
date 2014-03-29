<?php
/**
 * 2be's information.
 *
 * @package Core
 * @license http://www.gnu.org/licenses/agpl-3.0.html
 * @author Hunter Perrin <hperrin@gmail.com>
 * @copyright SciActive.com
 * @link http://sciactive.com/
 */
/* @var $_ core */
defined('P_RUN') or die('Direct access prohibited');

return array(
	'name' => '2be',
	'author' => 'SciActive',
	'version' => '2.0.1dev',
	'license' => 'http://www.gnu.org/licenses/agpl-3.0.html',
	'website' => 'http://2be.io/',
	'short_description' => '2be core system.',
	'description' => 'The core system of the 2be PHP framework.',
	'depend' => array(
		'php' => '>=5.3.0'
	),
	'abilities' => array(
		array('all', 'All Abilities', 'Let user do anything, regardless of whether they have the ability.')
	),
);