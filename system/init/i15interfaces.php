<?php
/**
 * Define system service interfaces.
 *
 * @package Core
 * @license http://www.gnu.org/licenses/agpl-3.0.html
 * @author Hunter Perrin <hperrin@gmail.com>
 * @copyright SciActive.com
 * @link http://sciactive.com/
 */
/* @var $_ core */
defined('P_RUN') or die('Direct access prohibited');

if (P_SCRIPT_TIMING) pines_print_time('Define Service Interfaces');

/**
 * A base interface for all components.
 * @package Core
 */
interface component_interface { }

/**
 * Objects which support abilities, such as users and groups.
 * @package Core
 */
interface able_object_interface extends DataObjectInterface {
	/**
	 * Grant an ability.
	 *
	 * Abilities should be named following this form!!
	 *
	 *	 com_componentname/abilityname
	 *
	 * If it is a system ability (ie. not part of a component, substitute
	 * "com_componentname" with "system". The system ability "all" means the
	 * user has every ability available.
	 *
	 * @param string $ability The ability.
	 */
	public function grant($ability);
	/**
	 * Revoke an ability.
	 *
	 * @param string $ability The ability.
	 */
	public function revoke($ability);
}

/**
 * 2be system users.
 * @package Core
 * @property int $guid The GUID of the user.
 * @property string $username The user's username.
 * @property string $name_first The user's first name.
 * @property string $name_middle The user's middle name.
 * @property string $name_last The user's last name.
 * @property string $name The user's full name.
 * @property string $email The user's email address.
 * @property string $phone The user's telephone number.
 * @property string $address_type The user's address type. "us" or "international".
 * @property string $address_1 The user's address line 1 for US addresses.
 * @property string $address_2 The user's address line 2 for US addresses.
 * @property string $city The user's city for US addresses.
 * @property string $state The user's state abbreviation for US addresses.
 * @property string $zip The user's ZIP code for US addresses.
 * @property string $address_international The user's full address for international addresses.
 * @property string $pin The user's PIN.
 * @property group $group The user's primary group.
 * @property array $groups The user's secondary groups.
 * @property bool $inherit_abilities Whether the user should inherit the abilities of his groups.
 */
interface user_interface extends able_object_interface {
	/**
	 * Load a user.
	 *
	 * @param int|string $id The ID or username of the user to load, 0 for a new user.
	 */
	public function __construct($id = 0);
	/**
	 * Create a new instance.
	 *
	 * @param int|string $id The ID or username of the user to load, 0 for a new user.
	 * @return user A user instance.
	 */
	public static function factory($id = 0);
	/**
	 * Add the user to a (secondary) group.
	 *
	 * @param group $group The group.
	 * @return mixed True if the user is already in the group. The resulting array of groups if the user was not.
	 */
	public function add_group($group);
	/**
	 * Check the given password against the user's.
	 *
	 * @param string $password The password in question.
	 * @return bool True if the passwords match, otherwise false.
	 */
	public function check_password($password);
	/**
	 * Remove the user from a (secondary) group.
	 *
	 * @param group $group The group.
	 * @return mixed True if the user wasn't in the group. The resulting array of groups if the user was.
	 */
	public function del_group($group);
	/**
	 * Disable the user.
	 */
	public function disable();
	/**
	 * Enable the user.
	 */
	public function enable();
	/**
	 * Return the user's timezone.
	 *
	 * @param bool $return_date_time_zone_object Whether to return an object of the DateTimeZone class, instead of an identifier string.
	 * @return string|DateTimeZone The timezone identifier or the DateTimeZone object.
	 */
	public function get_timezone($return_date_time_zone_object = false);
	/**
	 * Check whether the user is in a (primary or secondary) group.
	 *
	 * @param mixed $group The group, or the group's GUID.
	 * @return bool True or false.
	 */
	public function in_group($group = null);
	/**
	 * Check whether the user is a descendant of a group.
	 *
	 * @param mixed $group The group, or the group's GUID.
	 * @return bool True or false.
	 */
	public function is_descendant($group = null);
	/**
	 * Alias of is_descendant.
	 *
	 * @param mixed $group The group, or the group's GUID.
	 * @return bool True or false.
	 * @deprecated
	 */
	public function is_descendent($group = null);
	/**
	 * Change the user's password.
	 *
	 * @param string $password The new password.
	 * @return string The resulting MD5 sum which is stored in the entity.
	 */
	public function password($password);
	/**
	 * Print a form to edit the user.
	 *
	 * @return module The form's module.
	 */
	public function print_form();
}

/**
 * 2be system groups.
 *
 * Note: When delete() is called all descendants of this group will also be
 * deleted.
 *
 * @package Core
 * @property int $guid The GUID of the group.
 * @property string $groupname The group's groupname.
 * @property string $name The group's name.
 * @property string $email The group's email address.
 * @property string $phone The group's telephone number.
 * @property string $address_type The group's address type. "us" or "international".
 * @property string $address_1 The group's address line 1 for US addresses.
 * @property string $address_2 The group's address line 2 for US addresses.
 * @property string $city The group's city for US addresses.
 * @property string $state The group's state abbreviation for US addresses.
 * @property string $zip The group's ZIP code for US addresses.
 * @property string $address_international The group's full address for international addresses.
 * @property group $parent The group's parent.
 */
interface group_interface extends able_object_interface {
	/**
	 * Load a group.
	 *
	 * @param int $id The ID of the group to load, 0 for a new group.
	 */
	public function __construct($id = 0);
	/**
	 * Create a new instance.
	 *
	 * @param int $id The ID of the group to load, 0 for a new group.
	 * @return group A group instance.
	 */
	public static function factory($id = 0);
	/**
	 * Disable the group.
	 */
	public function disable();
	/**
	 * Enable the group.
	 */
	public function enable();
	/**
	 * Check whether the group is a descendant of a group.
	 *
	 * @param mixed $group The group, or the group's GUID.
	 * @return bool True or false.
	 */
	public function is_descendant($group = null);
	/**
	 * Alias of is_descendant.
	 *
	 * @param mixed $group The group, or the group's GUID.
	 * @return bool True or false.
	 * @deprecated
	 */
	public function is_descendent($group = null);
	/**
	 * Gets an array of the group's child groups.
	 *
	 * @return array An array of groups.
	 */
	public function get_children();
	/**
	 * Gets an array of the group's descendant groups.
	 *
	 * @param bool $and_self Include this group in the returned array.
	 * @return array An array of groups.
	 */
	public function get_descendants($and_self = false);
	/**
	 * Alias of get_descendants.
	 *
	 * @param bool $and_self Include this group in the returned array.
	 * @return array An array of groups.
	 * @deprecated
	 */
	public function get_descendents($and_self = false);
	/**
	 * Get the number of parents the group has.
	 *
	 * If the group is a top level group, this will return 0. If it is a child
	 * of a top level group, this will return 1. If it is a grandchild of a top
	 * level group, this will return 2, and so on.
	 *
	 * @return int The level of the group.
	 */
	public function get_level();
	/**
	 * Find the location of the group's current logo image.
	 *
	 * @param bool $full Return a full URL, instead of a relative one.
	 * @return string The URL of the logo image.
	 */
	public function get_logo($full = false);
	/**
	 * Gets an array of users in the group.
	 *
	 * Some user managers may return only enabled users.
	 *
	 * @param bool $descendants Include users in all descendant groups too.
	 * @return array An array of users.
	 */
	public function get_users($descendants = false);
	/**
	 * Print a form to edit the group.
	 *
	 * @return module The form's module.
	 */
	public function print_form();
}

/**
 * A 2be template.
 * @package Core
 * @property-read string $format The template's format.
 * @property-read string $editor_css The filename of a CSS file to use for editing content.
 */
interface template_interface {
	/**
	 * Format a menu.
	 *
	 * @param array $menu The menu.
	 * @return string The menu's resulting code.
	 */
	public function menu($menu);
	/**
	 * Return a URL in the necessary format to be usable on the current
	 * installation.
	 *
	 * url() is designed to work with the URL rewriting features of 2be,
	 * so it should be called whenever outputting a URL is required. If url() is
	 * called with no parameters, it will return the URL of the index page.
	 *
	 * @param string $component The component the URL should point to.
	 * @param string $action The action the URL should point to.
	 * @param array $params An array of parameters which should be part of the URL's query string.
	 * @param bool $full_location Whether to return an absolute URL or a relative URL.
	 * @return string The URL in a format to work with the current configuration of 2be.
	 */
	public function url($component = null, $action = null, $params = array(), $full_location = false);
}

/**
 * Manages 2be configuration.
 * @package Core
 */
interface configurator_interface extends component_interface {
	/**
	 * Disables a component.
	 *
	 * This function renames the component's directory by adding a dot (.) in
	 * front of the name. This causes 2be to ignore the component.
	 *
	 * @param string $component The name of the component.
	 * @return bool True on success, false on failure.
	 */
	public function disable_component($component);
	/**
	 * Enables a component.
	 *
	 * This function renames the component's directory by removing the dot (.)
	 * in front of the name. This causes 2be to recognize the component.
	 *
	 * @param string $component The name of the component.
	 * @return bool True on success, false on failure.
	 */
	public function enable_component($component);
	/**
	 * Creates and attaches a module which lists configurable components.
	 * @return module The module.
	 */
	public function list_components();
}

/**
 * A configurable component.
 * @package Core
 * @property array $defaults The configuration defaults.
 * @property array $config The current configuration.
 * @property array $config_keys The current configuration in an array with key => values.
 * @property array $info The info object of the component.
 * @property string $name The component.
 */
interface configurator_component_interface {
	/**
	 * Load a component's configuration and info.
	 * @param string $component The component to load.
	 */
	public function __construct($component);
	/**
	 * Create a new instance.
	 * @param string $component The component to load.
	 * @return configurator_component A component configuration object instance.
	 */
	public static function factory($component);
	/**
	 * Get a full config array. (With defaults replaced.)
	 * @return array The array.
	 */
	public function get_full_config_array();
	/**
	 * Check if a component is configurable.
	 * @return bool True or false.
	 */
	public function is_configurable();
	/**
	 * Check if a component is disabled.
	 * @return bool True or false.
	 */
	public function is_disabled();
	/**
	 * Print a form to edit the configuration.
	 * @return module The form's module.
	 */
	public function print_form();
	/**
	 * Print a view of the configuration.
	 * @return module The view's module.
	 */
	public function print_view();
	/**
	 * Write the configuration to the config file.
	 * @return bool True on success, false on failure.
	 */
	public function save_config();
	/**
	 * Set the current config by providing an array of key => values.
	 * @param array $config_keys An array of configuration values.
	 */
	public function set_config($config_keys);
}

/**
 * Logs activity within the framework.
 * @package Core
 */
interface log_manager_interface extends component_interface {
	/**
	 * Log an entry to the 2be log.
	 *
	 * @param string $message The message to be logged.
	 * @param string $level The level of the message. (debug, info, notice, warning, error, or fatal)
	 * @return bool True on success, false on error.
	 */
	public function log($message, $level = 'info');
}

/**
 * User and group manager.
 *
 * User managers need to hook entity transactions and filter certain
 * functionality based on an access control variable.
 *
 * @package Core
 * @todo Finish describing user manager's entity obligations.
 */
interface user_manager_interface extends component_interface {
	/**
	 * Check an entity's permissions for the currently logged in user.
	 *
	 * This will check the variable "ac" (Access Control) of the entity. It
	 * should be an object that contains the following properties:
	 *
	 * - user
	 * - group
	 * - other
	 *
	 * The property "user" refers to the entity's owner, "group" refers to all
	 * users in the entity's group and all ancestor groups, and "other" refers
	 * to any user who doesn't fit these descriptions.
	 *
	 * Each variable should be either 0, 1, 2, or 3. If it is 0, the user has no
	 * access to the entity. If it is 1, the user has read access to the entity.
	 * If it is 2, the user has read and write access to the entity. If it is 3,
	 * the user has read, write, and delete access to the entity.
	 *
	 * "ac" defaults to:
	 *
	 * - user = 3
	 * - group = 3
	 * - other = 0
	 *
	 * The following conditions will result in different checks, which determine
	 * whether the check passes:
	 *
	 * - No user is logged in. (Always true, should be managed with abilities.)
	 * - The entity has no "user" and no "group". (Always true.)
	 * - The user has the "system/all" ability. (Always true.)
	 * - The entity is the user. (Always true.)
	 * - It is the user's primary group. (Always true.)
	 * - The entity is a user or group. (Always true.)
	 * - Its "user" is the user. (It is owned by the user.) (Check user AC.)
	 * - Its "group" is the user's primary group. (Check group AC.)
	 * - Its "group" is one of the user's secondary groups. (Check group AC.)
	 * - Its "group" is a descendant of one of the user's groups. (Check group
	 *   AC.)
	 * - None of the above. (Check other AC.)
	 *
	 * @param object &$entity The entity to check.
	 * @param int $type The lowest level of permission to consider a pass. 1 is read, 2 is write, 3 is delete.
	 * @return bool Whether the current user has at least $type permission for the entity.
	 */
	public function check_permissions(&$entity, $type = 1);
	/**
	 * Fill the $_SESSION['user'] variable with the logged in user's data.
	 *
	 * Also sets the default timezone to the user's timezone.
	 *
	 * This must be called at the i11 position in the init script processing.
	 */
	public function fill_session();
	/**
	 * Check to see if a user has an ability.
	 *
	 * If $ability and $user are null, it will check to see if a user is
	 * currently logged in.
	 *
	 * If the user has the "system/all" ability, this function will return true.
	 *
	 * @param string $ability The ability.
	 * @param user $user The user to check. If none is given, the current user is used.
	 * @return bool True or false.
	 */
	public function gatekeeper($ability = null, $user = null);
	/**
	 * Gets all groups.
	 *
	 * @param bool $all Include disabled groups in addition to enabled groups.
	 * @return array An array of groups.
	 */
	public function get_groups($all = false);
	/**
	 * Gets all users.
	 *
	 * @param bool $all Include disabled users in addition to enabled users.
	 * @return array An array of users.
	 */
	public function get_users($all = false);
	/**
	 * Sort an array of groups hierarchically.
	 *
	 * An additional property of the groups can be used to sort them under their
	 * parents.
	 *
	 * @param array &$array The array of groups.
	 * @param string|null $property The name of the property to sort groups by. Null for no additional sorting.
	 * @param bool $case_sensitive Sort case sensitively.
	 * @param bool $reverse Reverse the sort order.
	 */
	public function group_sort(&$array, $property = null, $case_sensitive = false, $reverse = false);
	/**
	 * Logs the given user into the system.
	 *
	 * @param user $user The user.
	 * @return bool True on success, false on failure.
	 */
	public function login($user);
	/**
	 * Logs the current user out of the system.
	 */
	public function logout();
	/**
	 * Creates and attaches a module which lets the user log in.
	 *
	 * @param string $position The position in which to place the module.
	 * @param string $url An optional url to redirect to after login.
	 * @return module The new module.
	 */
	public function print_login($position = 'content', $url = null);
	/**
	 * Kick the user out of the current page.
	 *
	 * Note that this method completely terminates execution of the script when
	 * it is called. Code after this method is called will not run.
	 *
	 * Though not required, the user manager should give the user an opportunity
	 * to log in and return to the page.
	 *
	 * @param string $message An optional message to display to the user. For no message, provide an empty string. If left null, a default message will be displayed.
	 * @param string $url An optional URL to return to. (E.g. if the user logs in.)
	 */
	public function punt_user($message = null, $url = null);
}

/**
 * Content editor.
 * @package Core
 */
interface editor_interface extends component_interface {
	/**
	 * Load the editor.
	 *
	 * This will transform textareas with the "peditor" class into editors,
	 * textareas with the "peditor-simple" class into simple editors, and
	 * textareas with the "peditor-email" class into email editors.
	 *
	 * Simple editors may be the same as editors, depending on the
	 * implementation.
	 *
	 * Email editors should format content for emails. This includes full URLs
	 * for links and images, no stylesheets, etc.
	 */
	public function load();
	/**
	 * Add a custom CSS file to style the editor's page.
	 *
	 * The file, along with the template's editor CSS, will style WYSIWYG editor
	 * content.
	 *
	 * @param string $url The URL of the stylesheet.
	 */
	public function add_css($url);
}

/**
 * File uploader.
 * @package Core
 */
interface uploader_interface extends component_interface {
	/**
	 * Load the uploader.
	 *
	 * This will transform any text inputs with the "puploader" class into file
	 * uploaders. The uploader will contain the URL of the selected file.
	 *
	 * Add the class "puploader-folders" to be able to select folders, and the
	 * class "puploader-multiple" to be able to select multiple files/folders.
	 *
	 * When selecting multiple files, they will be separated by two forward
	 * slashes "//".
	 *
	 * Add the class "puploader-temp" to emulate a single file upload. Only one
	 * file will be allowed, and it will be placed into a temporary directory.
	 * Note that the check method is not needed when you are using a temp file.
	 */
	public function load();
	/**
	 * Check whether a user provided URL is valid.
	 *
	 * Whenever you use the uploader, you should use this method to check the
	 * user input. If it returns false, DO NOT use that value. It is VERY likely
	 * that the user is attempting to hack the system.
	 *
	 * @param string $url The user provided file URL.
	 * @return bool True if the URL is valid, false if it is not.
	 */
	public function check($url);
	/**
	 * Get the real path to a file.
	 *
	 * This path can be used in server side code to access the file.
	 *
	 * @param string $url The user provided file URL.
	 * @return string The real path to the file.
	 */
	public function real($url);
	/**
	 * Get the real path to a temp file.
	 *
	 * When you use "puploader-temp" to receive a single file upload, pass the
	 * string you receive on to this function to get the real file path.
	 *
	 * @param string $temp_string The string submitted by the form.
	 * @return string The real path to the file, located in a temp folder.
	 */
	public function temp($temp_string);
	/**
	 * Get the URL to a file.
	 *
	 * This path can be used in client side code to access the file.
	 *
	 * @param string $real The real path to the file.
	 * @param bool $full Whether to return a full URL, instead of relative to the server root.
	 * @return string The file's URL.
	 */
	public function url($real, $full = false);
}

/**
 * 2be Icon theme.
 * @package Core
 */
interface icons_interface extends component_interface {
	/**
	 * Load the icon theme.
	 *
	 * This will provide CSS styling for the 2be Icon styles.
	 */
	public function load();
}

if (P_SCRIPT_TIMING) pines_print_time('Define Service Interfaces');