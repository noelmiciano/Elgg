<?php
/**
 * Elgg Actions
 *
 * Actions are one of the primary controllers (The C in MVC) in Elgg. They are
 * registered by {@link register_elgg_action()} and are called by URL
 * http://elggsite.org/action/action_name. For URLs, a rewrite rule in
 * .htaccess passes the action name to engine/handlers/action_handler.php,
 * which dispatches the request for the action.
 *
 * An action name must be registered to a file in the system. Core actions are
 * found in /actions/ and plugin actions are usually under /mod/<plugin>/actions/.
 * It is recommended that actions be namespaced to avoid collisions.
 *
 * All actions require security tokens.  Using the {@elgg_view input/form} view
 * will automatically add tokens as hidden inputs as will the elgg_view_form()
 * function.  To manually add hidden inputs, use the {@elgg_view input/securitytoken} view.
 *
 * To include security tokens for actions called via GET, use
 * {@link elgg_add_security_tokens_to_url()} or specify is_action as true when
 * using {@lgg_view output/url}.
 *
 * Action tokens can be manually generated by using {@link generate_action_token()}.
 *
 * @tip When registered, actions can be restricted to logged in or admin users.
 *
 * @tip Action URLs should be called with a trailing / to prevent 301 redirects.
 *
 * @package Elgg.Core
 * @subpackage Actions
 * @link http://docs.elgg.org/Actions
 * @link http://docs.elgg.org/Actions/Tokens
 */

/**
 * Perform an action.
 *
 * This function executes the action with name $action as registered
 * by {@link elgg_register_action()}.
 *
 * The plugin hook 'action', $action_name will be triggered before the action
 * is executed.  If a handler returns false, it will prevent the action script
 * from being called.
 *
 * @note If an action isn't registered in the system or is registered
 * to an unavailable file the user will be forwarded to the site front
 * page and an error will be emitted via {@link register_error()}.
 *
 * @warning All actions require {@link http://docs.elgg.org/Actions/Tokens Action Tokens}.
 *
 * @param string $action    The requested action
 * @param string $forwarder Optionally, the location to forward to
 *
 * @link http://docs.elgg.org/Actions
 * @see elgg_register_action()
 *
 * @return void
 * @access private
 */
function action($action, $forwarder = "") {
	return _elgg_services()->actions->execute($action, $forwarder);
}

/**
 * Registers an action.
 *
 * Actions are registered to a script in the system and are executed
 * either by the URL http://elggsite.org/action/action_name/.
 *
 * $filename must be the full path of the file to register, or a path relative
 * to the core actions/ dir.
 *
 * Actions should be namedspaced for your plugin.  Example:
 * <code>
 * elgg_register_action('myplugin/save_settings', ...);
 * </code>
 *
 * @tip Put action files under the actions/<plugin_name> directory of your plugin.
 *
 * @tip You don't need to include engine/start.php in your action files.
 *
 * @internal Actions are saved in $CONFIG->actions as an array in the form:
 * <code>
 * array(
 * 	'file' => '/location/to/file.php',
 * 	'access' => 'public', 'logged_in', or 'admin'
 * )
 * </code>
 *
 * @param string $action   The name of the action (eg "register", "account/settings/save")
 * @param string $filename Optionally, the filename where this action is located. If not specified,
 *                         will assume the action is in elgg/actions/<action>.php
 * @param string $access   Who is allowed to execute this action: public, logged_in, admin.
 *                         (default: logged_in)
 *
 * @see action()
 * @see http://docs.elgg.org/Actions
 *
 * @return bool
 */
function elgg_register_action($action, $filename = "", $access = 'logged_in') {
	return _elgg_services()->actions->register($action, $filename, $access);
}

/**
 * Unregisters an action
 *
 * @param string $action Action name
 * @return bool
 * @since 1.8.1
 */
function elgg_unregister_action($action) {
	return _elgg_services()->actions->unregister($action);
}

/**
 * Validate an action token.
 *
 * Calls to actions will automatically validate tokens. If tokens are not
 * present or invalid, the action will be denied and the user will be redirected.
 *
 * Plugin authors should never have to manually validate action tokens.
 *
 * @param bool  $visibleerrors Emit {@link register_error()} errors on failure?
 * @param mixed $token         The token to test against. Default: $_REQUEST['__elgg_token']
 * @param mixed $ts            The time stamp to test against. Default: $_REQUEST['__elgg_ts']
 *
 * @return bool
 * @see generate_action_token()
 * @link http://docs.elgg.org/Actions/Tokens
 * @access private
 */
function validate_action_token($visibleerrors = TRUE, $token = NULL, $ts = NULL) {
	return _elgg_services()->actions->validateActionToken($visibleerrors, $token, $ts);
}

/**
 * Validates the presence of action tokens.
 *
 * This function is called for all actions.  If action tokens are missing,
 * the user will be forwarded to the site front page and an error emitted.
 *
 * This function verifies form input for security features (like a generated token),
 * and forwards if they are invalid.
 *
 * @param string $action The action being performed 
 *
 * @return mixed True if valid or redirects.
 * @access private
 */
function action_gatekeeper($action) {
	return _elgg_services()->actions->gatekeeper($action);
}

/**
 * Generate an action token.
 *
 * Action tokens are based on timestamps as returned by {@link time()}.
 * They are valid for one hour.
 *
 * Action tokens should be passed to all actions name __elgg_ts and __elgg_token.
 *
 * @warning Action tokens are required for all actions.
 *
 * @param int $timestamp Unix timestamp
 *
 * @see @elgg_view input/securitytoken
 * @see @elgg_view input/form
 * @example actions/manual_tokens.php
 *
 * @return string|false
 * @access private
 */
function generate_action_token($timestamp) {
	return _elgg_services()->actions->generateActionToken($timestamp);
}

/**
 * Initialise the site secret hash.
 *
 * Used during installation and saves as a datalist.
 *
 * @return mixed The site secret hash or false
 * @access private
 * @todo Move to better file.
 */
function init_site_secret() {
	$secret = md5(rand() . microtime());
	if (datalist_set('__site_secret__', $secret)) {
		return $secret;
	}

	return FALSE;
}

/**
 * Returns the site secret.
 *
 * Used to generate difficult to guess hashes for sessions and action tokens.
 *
 * @return string Site secret.
 * @access private
 * @todo Move to better file.
 */
function get_site_secret() {
	$secret = datalist_get('__site_secret__');
	if (!$secret) {
		$secret = init_site_secret();
	}

	return $secret;
}

/**
 * Check if an action is registered and its script exists.
 *
 * @param string $action Action name
 *
 * @return bool
 * @since 1.8.0
 */
function elgg_action_exists($action) {
	return _elgg_services()->actions->exists($action);
}

/**
 * Checks whether the request was requested via ajax
 *
 * @return bool whether page was requested via ajax
 * @since 1.8.0
 */
function elgg_is_xhr() {
	return isset($_SERVER['HTTP_X_REQUESTED_WITH'])
		&& strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ||
		get_input('X-Requested-With') === 'XMLHttpRequest';
}

/**
 * Catch calls to forward() in ajax request and force an exit.
 *
 * Forces response is json of the following form:
 * <pre>
 * {
 *     "current_url": "the.url.we/were/coming/from",
 *     "forward_url": "the.url.we/were/going/to",
 *     "system_messages": {
 *         "messages": ["msg1", "msg2", ...],
 *         "errors": ["err1", "err2", ...]
 *     },
 *     "status": -1 //or 0 for success if there are no error messages present
 * }
 * </pre>
 * where "system_messages" is all message registers at the point of forwarding
 *
 * @param string $hook
 * @param string $type
 * @param string $reason
 * @param array $params
 * @return void
 * @access private
 */
function ajax_forward_hook($hook, $type, $reason, $params) {
	_elgg_services()->actions->ajaxForwardHook($hook, $type, $reason, $params);
}

/**
 * Buffer all output echo'd directly in the action for inclusion in the returned JSON.
 * @return void
 * @access private
 */
function ajax_action_hook() {
	_elgg_services()->actions->ajaxActionHook();
}

/**
 * Initialize some ajaxy actions features
 * @access private
 */
function actions_init() {
	elgg_register_action('security/refreshtoken', '', 'public');

	elgg_register_simplecache_view('js/languages/en');

	elgg_register_plugin_hook_handler('action', 'all', 'ajax_action_hook');
	elgg_register_plugin_hook_handler('forward', 'all', 'ajax_forward_hook');
}

elgg_register_event_handler('init', 'system', 'actions_init');
