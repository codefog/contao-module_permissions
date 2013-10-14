<?php

/**
 * module_permissions extension for Contao Open Source CMS
 *
 * Copyright (C) 2013 Codefog Ltd
 *
 * @package module_permissions
 * @author  Codefog Ltd <http://codefog.pl>
 * @author  Kamil Kuzminski <kamil.kuzminski@codefog.pl>
 * @license LGPL
 */


/**
 * Add the "onload_callback" to tl_module
 */
$GLOBALS['TL_DCA']['tl_module']['config']['onload_callback'][] = array('tl_module_permissions', 'checkPermission');


/**
 * Class tl_module_permissions
 *
 * Provide miscellaneous methods that are used by the data configuration array.
 */
class tl_module_permissions extends Backend
{

	/**
	 * Check the permissions
	 */
	public function checkPermission()
	{
		$this->import('BackendUser', 'User');

		if ($this->User->isAdmin || !is_array($this->User->feModules) || empty($this->User->feModules))
		{
			return;
		}

		$GLOBALS['TL_DCA']['tl_module']['list']['sorting']['root'] = $this->User->feModules;
	}
}
