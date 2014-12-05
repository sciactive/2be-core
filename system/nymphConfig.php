<?php
/**
 * Nymph configuration.
 *
 * @package Core
 * @license http://www.gnu.org/licenses/agpl-3.0.html
 * @author Hunter Perrin <hperrin@gmail.com>
 * @copyright SciActive.com
 * @link http://sciactive.com/
 */
/* @var $_ core */
defined('P_RUN') or die('Direct access prohibited');

$nymph_config = include("{$libDir}nymph/conf/defaults.php");

$nymph_config->MySQL->database['value'] = '2be';
$nymph_config->MySQL->user['value'] = '2be';
$nymph_config->MySQL->password['value'] = 'password';

return $nymph_config;