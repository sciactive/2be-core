<?php
/**
 * Get RequirePHP and Nymph.
 *
 * @package Core
 * @license http://www.gnu.org/licenses/agpl-3.0.html
 * @author Hunter Perrin <hperrin@gmail.com>
 * @copyright SciActive.com
 * @link http://sciactive.com/
 */
/* @var $_ core */
defined('P_RUN') or die('Direct access prohibited');

if (file_exists(dirname(__FILE__).DIRECTORY_SEPARATOR."../../bower_components/requirephp/require.php")) {
	$libDir = dirname(__FILE__).DIRECTORY_SEPARATOR."../../bower_components/";
} elseif (file_exists(dirname(__FILE__).DIRECTORY_SEPARATOR."../../vendor/sciactive/requirephp/require.php")) {
	$libDir = dirname(__FILE__).DIRECTORY_SEPARATOR."../../vendor/sciactive/";
} elseif (file_exists("../../requirephp/require.php")) {
	$libDir = dirname(__FILE__).DIRECTORY_SEPARATOR."../../";
} else {
	echo <<< EOF
It looks like you haven't downloade RequirePHP yet. You can do this with Bower,
Composer, or manually.<br>
<br>
Bower:<br>
<code>bower install</code><br>
<br>
Composer:<br>
<code>php composer.phar install</code> or <code>composer install</code> depending on your installation.<br>
<br>
Manually:<br>
<ol>
	<li>Go to <a href="https://github.com/sciactive/requirephp/releases" target="_blank">https://github.com/sciactive/requirephp/releases</a></li>
	<li>Go to <a href="https://github.com/sciactive/nymph/releases" target="_blank">https://github.com/sciactive/nymph/releases</a></li>
	<li>Download the latest releases.</li>
	<li>Extract the require.php file, and the nymph source files and place require.php in a dir called "requirephp" and Nymph's source in a dir called "nymph", both in the root of this repository.</li>
</ol>
EOF;
	exit;
}

require "{$libDir}requirephp/require.php";
require "{$libDir}nymph/src/Nymph.php";

// Initialize Nymph config.
RPHP::_('NymphConfig', array(), function() use ($libDir){
	return include dirname(__FILE__).DIRECTORY_SEPARATOR.'../nymphConfig.php';
});

// TODO: remove this
$nymph = RPHP::_('Nymph');
unset($libDir);
unset($nymph);
