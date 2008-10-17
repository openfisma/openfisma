<?php
/**
 * Define common paths used for locating specific types of files.
 *
 * @package    Root
 * @author     Xhorse <xhorse@users.sourceforge.net>
 * @copyright  (c) Endeavor Systems, Inc. 2008 (http://www.endeavorsystems.com)
 * @license    http://www.openfisma.org/mw/index.php?title=License
 * @version    $Id: paths.php 998 2008-10-17 08:47:11Z xhorse $
 */

// Sets the root path of the OpenFISMA application
define('ROOT', 			realpath('../')); 
 
define('APPS', 			ROOT . '/apps');

define('CONFIGS', 		APPS . '/config');
define('CONTROLLERS', 	APPS . '/controllers');
define('MODELS', 		APPS . '/models');
define('VIEWS', 		APPS . '/views');

define('LOG', 			ROOT . '/log');
define('MIGRATIONS', 	ROOT . '/migrations');
define('TEST', 			ROOT . '/test');
define('VENDORS', 		ROOT . '/library');
define('LOCAL', 		ROOT . '/library/local');
define('WEB_ROOT', 		ROOT . '/public');

// Update the class path for includes
$includeDirectories = array(
	APPS,
	CONFIGS,
    CONTROLLERS,
    MODELS,
	VIEWS,
	LOG,
	MIGRATIONS,
    VENDORS,
	LOCAL,
    // Have to hack in the path to Pear since it doesn't follow ZF standards:
    VENDORS . '/Pear'
);
ini_set('include_path',
    implode(PATH_SEPARATOR, $includeDirectories) . PATH_SEPARATOR . ini_get('include_path'));