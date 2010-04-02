<?php
/**
 * pines class.
 *
 * @package Pines
 * @license http://www.gnu.org/licenses/agpl-3.0.html
 * @author Hunter Perrin <hunter@sciactive.com>
 * @copyright Hunter Perrin
 * @link http://sciactive.com/
 */
defined('P_RUN') or die('Direct access prohibited');

/**
 * A dynamic component loading class. The class for the $pines object.
 *
 * Component classes will be automatically loaded into their variables. In other
 * words, when you call $pines->com_xmlparser->parse(), if $pines->com_xmlparser
 * is empty, the com_xmlparser class will attempt to be loaded into it. It will
 * then be hooked by the hook manager.
 *
 * @package Pines
 */
class pines extends p_base {
	/**
	 * Pines' and components' info.
	 * @var info
	 */
	public $info;
	/**
	 * Pines' and components' configuration.
	 * @var config
	 */
	public $config;
	/**
	 * The hook system.
	 * @var hook
	 */
	public $hook;
	/**
	 * The dependency system.
	 * @var depend
	 */
	public $depend;
	/**
	 * The menu system.
	 * @var menu
	 */
	public $menu;
	/**
	 * The display controller.
	 * @var page
	 */
	public $page;
	/**
	 * An array of the enabled components.
	 * @var array
	 */
	public $components = array();
	/**
	 * An array of all components.
	 * @var array
	 */
	public $all_components = array();
	/**
	 * An array of the possible system services.
	 * @var array
	 */
	public $service_names = array('template', 'configurator', 'log_manager', 'entity_manager', 'user_manager', 'ability_manager', 'editor');
	/**
	 * An array of the system services.
	 * @var array
	 */
	public $services = array();
	/**
	 * The name of the current template.
	 * @var string
	 */
	public $current_template;
	/**
	 * List of class files for autoloading classes.
	 *
	 * Note that templates have a classes dir, but the only file loaded from it is
	 * the file of the same name as the template. Also, only the current template's
	 * class is loaded.
	 *
	 * @var array
	 */
	public $class_files = array();
	/**
	 * The requested component/option.
	 * @var string
	 */
	public $request_component;
	/**
	 * The requested action.
	 * @var string
	 */
	public $request_action;
	/**
	 * The currently running component/option.
	 * @var string
	 */
	public $component;
	/**
	 * The currently running action.
	 * @var string
	 */
	public $action;

	/**
	 * Load and run an action.
	 *
	 * @param string $component The component in which the action resides.
	 * @param string $action The action to run.
	 * @return mixed The value returned by the action, or 'error_404' if it doesn't exist.
	 */
	public function action($component, $action) {
		global $pines;
		$component = str_replace('..', 'fail-danger-dont-use-hack-attempt', $component);
		$action = str_replace('..', 'fail-danger-dont-use-hack-attempt', $action);
		$action_file = ($component == 'system' ? $component : "components/$component")."/actions/$action.php";
		if ( file_exists($action_file) ) {
			$this->component = $component;
			$this->action = $action;
			unset($component);
			unset($action);
			/**
			 * Run the action's file.
			 */
			return require($action_file);
		} else {
			return 'error_404';
		}
	}

	/**
	 * Set up the Pines object.
	 */
	public function __construct() {
		if (P_SCRIPT_TIMING) pines_print_time('Load the Pines base system services.');
		$this->info = new info;
		$this->config = new config;
		$this->hook = new hook;
		$this->depend = new depend;
		$this->menu = new menu;
		$this->page = new page;
		if (P_SCRIPT_TIMING) pines_print_time('Load the Pines base system services.');

		if (P_SCRIPT_TIMING) pines_print_time('Load System Config');
		$this->current_template = ( !empty($_REQUEST['template']) && $this->config->allow_template_override ) ?
			$_REQUEST['template'] : $this->config->default_template;
		$this->template = $this->current_template;
		date_default_timezone_set($this->config->timezone);

		// Check the offline mode, and load the offline page if enabled.
		if ($this->config->offline_mode)
			require('system/offline.php');
		if (P_SCRIPT_TIMING) pines_print_time('Load System Config');

		if (P_SCRIPT_TIMING) pines_print_time('Find Component Classes');
		// Fill the lists of components.
		if ( file_exists('components/') && file_exists('templates/') ) {
			$this->components = array_merge(pines_scandir('components/'), pines_scandir('templates/'));
			$this->all_components = array_merge(pines_scandir('components/', 0, null, false), pines_scandir('templates/', 0, null, false));
			foreach ($this->all_components as &$cur_value) {
				if (substr($cur_value, 0, 1) == '.')
					$cur_value = substr($cur_value, 1);
			}
			sort($this->components);
			sort($this->all_components);
		}

		// Fill the list of component classes.
		$temp_classes = glob('components/com_*/classes/*.php');
		foreach ($temp_classes as $cur_class) {
			$this->class_files[preg_replace('/^\/|\.php$/S', '', strrchr($cur_class, '/'))] = $cur_class;
		}
		// If the current template is missing its class, display the template error page.
		$template_class_file = "templates/{$this->current_template}/classes/{$this->current_template}.php";
		if ( !file_exists($template_class_file) )
			require('system/template_error.php');
		$this->class_files[$this->current_template] = $template_class_file;
		if (P_SCRIPT_TIMING) pines_print_time('Find Component Classes');
		
		if (P_SCRIPT_TIMING) pines_print_time('Get Requested Action');
		// Load any post or get vars for our component/action.
		$this->request_component = str_replace('..', 'fail-danger-dont-use-hack-attempt', $_REQUEST['option']);
		$this->request_action = str_replace('..', 'fail-danger-dont-use-hack-attempt', $_REQUEST['action']);

		// URL Rewriting Engine (Simple, eh?)
		// The values from URL rewriting override any post or get vars, so don't submit
		// forms to a url you shouldn't.
		// /index.php/user/edituser/id-35/ -> /index.php?option=com_user&action=edituser&id=35
		if ( $this->config->url_rewriting ) {
			// Get an array of the pseudo directories from the URI.
			$args_array = explode('/',
				// Get rid of index.php/ at the beginning, and / at the end.
				preg_replace('/(^'.preg_quote(P_INDEX).'\/?)|(\/$)/', '', substr(
					substr($_SERVER['REQUEST_URI'], 0,
						// Use the whole string, or if there's a query part, subtract that.
						strlen($_SERVER['REQUEST_URI']) - (strlen($_SERVER['QUERY_STRING']) ? strlen($_SERVER['QUERY_STRING']) + 1 : 0)
					),
					// This takes off the path to Pines.
					strlen($this->config->rela_location)
				))
			);
			if ( !empty($args_array[0]) ) $this->request_component = ($args_array[0] == 'system' ? $args_array[0] : 'com_'.$args_array[0]);
			if ( !empty($args_array[1]) ) $this->request_action = $args_array[1];
			$arg_count = count($args_array);
			for ($i = 2; $i < $arg_count; $i++) {
				$_REQUEST[preg_replace('/-.*$/', '', $args_array[$i])] = preg_replace('/^[^-]*-/', '', $args_array[$i]);
			}
		}

		// Fill in any empty request vars.
		if ( empty($this->request_component) ) $this->request_component = $this->config->default_component;
		if ( empty($this->request_action) ) $this->request_action = 'default';
		if (P_SCRIPT_TIMING) pines_print_time('Get Requested Action');
	}

	/**
	 * Retrieve a variable.
	 *
	 * You do not need to explicitly call this method. It is called by PHP when
	 * you access the variable normally.
	 * 
	 * This function will try to load a component's class into any variables
	 * beginning with com_. Standard variables will be loaded into their correct
	 * variables as well.
	 *
	 * @param string $name The name of the variable.
	 * @return mixed The value of the variable or nothing if it doesn't exist.
	 */
	public function &__get($name) {
		if (substr($name, 0, 4) == 'com_') {
			global $pines;
			try {
				$this->$name = new $name;
				$pines->hook->hook_object($this->$name, "\$pines->{$name}->");
				return $this->$name;
			} catch (Exception $e) {
				return;
			}
		}
		if (in_array($name, $this->service_names) && isset($this->services[$name])) {
			global $pines;
			$this->$name = new $this->services[$name];
			$pines->hook->hook_object($this->$name, "\$pines->{$name}->");
			return $this->$name;
		}
	}

	/**
	 * Checks whether a variable is set.
	 *
	 * You do not need to explicitly call this method. It is called by PHP when
	 * you access the variable normally.
	 *
	 * This functions checks whether a class can be loaded for class variables.
	 *
	 * @param string $name The name of the variable.
	 * @return bool
	 */
	public function __isset($name) {
		global $pines;
		if (substr($name, 0, 4) == 'com_')
			return (class_exists($name) || (is_array($pines->class_files) && isset($pines->class_files[$name])));
		return (in_array($name, $this->service_names) && isset($this->services[$name]));
	}

	/**
	 * Sets a variable.
	 *
	 * You do not need to explicitly call this method. It is called by PHP when
	 * you access the variable normally.
	 * 
	 * This function catches any standard system classes, so they don't get set
	 * to the name of their class. This allows them to be dynamically loaded
	 * when they are first called.
	 *
	 * @param string $name The name of the variable.
	 * @param string $value The value of the variable.
	 * @return mixed The value of the variable.
	 */
	public function __set($name, $value) {
		if (in_array($name, $this->service_names) && is_string($value)) {
			return $this->services[$name] = $value;
		} else {
			return $this->$name = $value;
		}
	}
}

?>