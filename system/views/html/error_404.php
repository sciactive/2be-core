<?php
/**
 * A generic 404 error notice.
 *
 * @package Core
 * @license http://www.gnu.org/licenses/agpl-3.0.html
 * @author Hunter Perrin <hperrin@gmail.com>
 * @copyright SciActive.com
 * @link http://sciactive.com/
 * @deprecated Replaced by error.php
 */
/* @var $_ pines *//* @var $this module */
defined('P_RUN') or die('Direct access prohibited');
$this->title = 'Error 404';
$this->note = 'Page not Found.';
?>
<p>The page you requested cannot be found on this server.</p>
<div>Suggestions:
	<ul>
		<li>Check the spelling of the address you requested.</li>
		<li>If you are still having problems, please <a href="<?php e(pines_url()); ?>">visit the homepage</a>.</li>
	</ul>
</div>