<?php
/**
 * Load script timing.
 *
 * @package Core
 * @license http://www.gnu.org/licenses/agpl-3.0.html
 * @author Hunter Perrin <hperrin@gmail.com>
 * @copyright SciActive.com
 * @link http://sciactive.com/
 */
/* @var $_ core */
defined('P_RUN') or die('Direct access prohibited');

if (P_SCRIPT_TIMING) {
	/**
	 * Display a message for 2be Script Timing.
	 *
	 * Messages will be displayed in the FireBug console, if available, or an
	 * alert() if not.
	 *
	 * @param string $message The message.
	 * @param bool $print_now Whether to print the page now.
	 */
	function pines_print_time($message, $print_now = false) {
		static $time_output;
		static $message_level = 0;
		static $time_array = array();
		static $subtract_time = 0;
		$microtime = microtime(true);
		if (!isset($time_array[$message]) || $time_array[$message]['level'] > $message_level) {
			$time_array[$message] = array('level' => $message_level);
			$message_level++;
		} else
			$message_level--;
		$time_array[$message][] = $microtime;
		$subtract_time += microtime(true) - $microtime;
		if (!$print_now)
			return;

		$total_time = $microtime - P_EXEC_TIME;
		$run_time = $total_time - $subtract_time;
		foreach($time_array as $message => $times) {
			$prefix = str_repeat('>', ($times['level'] < 0 ? 0 : $times['level']));
			$time = $times[count($times)-2] - $times[0];
			$percent = $time / $total_time * 100;
			$time_output .= sprintf(str_pad($prefix.$message, 70).'%.6F (% 5.2F%%)\n', $time, $percent);
		}
		echo '<script type="text/javascript">
(function(message){
if (console.log)
	console.log(message);
else
	alert(message);
})("';
		echo '2be Script Timing\n\nTimes are measured in seconds.\n';
		echo $time_output;
		echo '--------------------\n';
		printf(str_pad('Time Spent Timing', 70).'%F\n', $subtract_time);
		printf(str_pad('Script Run', 70).'%F\n', $run_time);
		printf(str_pad('Total Time', 70).'%F\n', $total_time);
		printf(str_pad('Peak Mem', 70).'%u\n', memory_get_peak_usage());
		printf(str_pad('Peak Real Mem', 70).'%u\n', memory_get_peak_usage(true));
		echo '");</script>';
	}
	pines_print_time('Script Timing Start');
	pines_print_time('Script Timing Start');
}