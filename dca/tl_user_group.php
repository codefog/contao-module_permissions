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
 * Load the tl_user data container
 */
$this->loadDataContainer('tl_user');
\System::loadLanguageFile('tl_user');


/**
 * Extend the tl_user_group palettes
 */
$GLOBALS['TL_DCA']['tl_user_group']['palettes']['default'] = str_replace('themes;', 'themes,feModules;', $GLOBALS['TL_DCA']['tl_user_group']['palettes']['default']);


/**
 * Add the fields to tl_user_group
 */
$GLOBALS['TL_DCA']['tl_user_group']['fields']['feModules'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_user']['feModules'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'options_callback'        => array('tl_user_module_permissions', 'getFrontendModules'),
	'eval'                    => array('multiple'=>true, 'tl_class'=>'clr'),
	'sql'                     => "blob NULL"
);
