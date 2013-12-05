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

		// Dynamically add the record to the user profile
		if (\Input::get('act') == 'edit' && !in_array(\Input::get('id'), $GLOBALS['TL_DCA']['tl_module']['list']['sorting']['root']))
		{
			$arrNew = $this->Session->get('new_records');

			if (is_array($arrNew['tl_module']) && in_array(\Input::get('id'), $arrNew['tl_module']))
			{
				// Add permissions on user level
				if ($this->User->inherit == 'custom' || !$this->User->groups[0])
				{
					$objUser = $this->Database->prepare("SELECT feModules FROM tl_user WHERE id=?")
											   ->limit(1)
											   ->execute($this->User->id);

					if ($objUser->numRows)
					{
						$arrModules = deserialize($objUser->feModules);
						$arrModules[] = \Input::get('id');

						$this->Database->prepare("UPDATE tl_user SET feModules=? WHERE id=?")
									   ->execute(serialize($arrModules), $this->User->id);
					}
				}

				// Add permissions on group level
				elseif ($this->User->groups[0] > 0)
				{
					$objGroup = $this->Database->prepare("SELECT feModules FROM tl_user_group WHERE id=?")
											   ->limit(1)
											   ->execute($this->User->groups[0]);

					if ($objGroup->numRows)
					{
						$arrModules = deserialize($objGroup->feModules);
						$arrModules[] = \Input::get('id');

						$this->Database->prepare("UPDATE tl_user_group SET feModules=? WHERE id=?")
									   ->execute(serialize($arrModules), $this->User->groups[0]);
					}
				}

				// Add new element to the user object
				$GLOBALS['TL_DCA']['tl_module']['list']['sorting']['root'][] = \Input::get('id');
				$this->User->feModules = $GLOBALS['TL_DCA']['tl_module']['list']['sorting']['root'];
			}
		}
	}
}
