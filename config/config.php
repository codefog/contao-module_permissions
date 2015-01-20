<?php

/**
 * module_permissions extension for Contao Open Source CMS
 *
 * Copyright (C) 2013 Codefog
 *
 * @package module_permissions
 * @author  Codefog <http://codefog.pl>
 * @author  Kamil Kuzminski <kamil.kuzminski@codefog.pl>
 * @license LGPL
 */


/**
 * Extension version
 */
@define('MODULE_PERMISSIONS_VERSION', '1.0');
@define('MODULE_PERMISSIONS_BUILD', '4');


/**
 * Add permissions
 */
$GLOBALS['TL_PERMISSIONS'][] = 'feModules';
