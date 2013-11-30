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
 * Extend the tl_user palettes
 */
$GLOBALS['TL_DCA']['tl_user']['palettes']['extend'] = str_replace('themes;', 'themes,feModules;', $GLOBALS['TL_DCA']['tl_user']['palettes']['extend']);
$GLOBALS['TL_DCA']['tl_user']['palettes']['custom'] = str_replace('themes;', 'themes,feModules;', $GLOBALS['TL_DCA']['tl_user']['palettes']['custom']);


/**
 * Add the fields to tl_user
 */
$GLOBALS['TL_DCA']['tl_user']['fields']['feModules'] = array
(
	'label'                   => &$GLOBALS['TL_LANG']['tl_user']['feModules'],
	'exclude'                 => true,
	'inputType'               => 'checkbox',
	'options_callback'        => array('tl_user_module_permissions', 'getFrontendModules'),
	'eval'                    => array('multiple'=>true, 'tl_class'=>'clr'),
	'sql'                     => "blob NULL"
);


/**
 * Class tl_user_module_permissions
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 */
class tl_user_module_permissions extends Backend
{

	/**
	 * Return the front end modules as an array
	 * @return array
	 */
	public function getFrontendModules()
	{
		$arrModules = array();
		$objModules = $this->Database->execute("SELECT id, name, (SELECT name FROM tl_theme WHERE tl_theme.id=tl_module.pid) AS theme FROM tl_module ORDER BY theme, name");

		while ($objModules->next())
		{
			$arrModules[$objModules->theme][$objModules->id] = $objModules->name;
		}

		return $arrModules;
	}
}
