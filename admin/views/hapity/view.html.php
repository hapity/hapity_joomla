<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_helloworld
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
 
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
/**
 * HelloWorlds View
 *
 * @since  0.0.1
 */
class HapityViewHapity extends JViewLegacy
{



	protected $form = null;

	/**
	 * Display the Hello World view
	 *
	 * @param   string  $tpl  The name of the template file to parse; automatically searches through the template paths.
	 *
	 * @return  void
	 */
	function display($tpl = null)
	{

         

		
     $this->formData = $this->_models["hapity"]->formSavedData();
      

 
		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			$application->enqueueMessage(JText::_('SOME_ERROR_OCCURRED'), 'error');
 
			return false;
		}
		// Set the toolbar
		$this->addToolBar();
 
		// Display the template
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @return  void
	 *
	 * @since   1.6
	 */
	protected function addToolBar()
	{

        



		JToolBarHelper::title("Hapity Configuration");
	
		
		
	}
}
