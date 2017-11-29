<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_hapity
 *
 * @copyright   Copyright (C) 2005 - 2015 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */
// No direct access to this file
defined('_JEXEC') or die('Restricted access');
 
/**
 * hapityList Model
 *
 * @since  0.0.1
 */
class HapityModelHapity extends JModelList
{
	



	function Savekey($key,$en = 1){
					// Get a db connection.
			$db = JFactory::getDbo();
			 
			// Create a new query object.
			$query = $db->getQuery(true);

			$query->delete($db->quoteName('#__hapity'));
			$query->where(1);
				
				 
				$db->setQuery($query);
				 
				$result = $db->execute();
			 
			// Insert columns.
			$columns = array('key',"published");
			 
			// Insert values.
			$values = array( $db->quote($key),$en);
			// Prepare the insert query.
			$query
			    ->insert($db->quoteName('#__hapity'))
			    ->columns($db->quoteName($columns))
			    ->values(implode(',', $values));
			 
			// Set the query using our newly populated query object and execute it.
			$db->setQuery($query);
			$db->execute();
	}



	function updateStatus($d){

				// Get a db connection.
			$db = JFactory::getDbo();
			 
			// Create a new query object.
			$query = $db->getQuery(true);

			// Insert columns.
			$columns = array($db->quoteName("published")."=".(int)$d);
			

			$query
			    ->update($db->quoteName('#__hapity'))
			    ->set($columns);
			    
			 
			// Set the query using our newly populated query object and execute it.
			$db->setQuery($query);
			$db->execute();

	}


	function formSavedData(){

			// Get a db connection.
			$db = JFactory::getDbo();
			 
			// Create a new query object.
			$query = $db->getQuery(true);


			$query->select($db->quoteName(array('key', 'published')));
			$query->from($db->quoteName('#__hapity'));
			$query->where(1);
			
			 
			// Reset the query using our newly populated query object.
			$db->setQuery($query);
			 
			// Load the results as a list of stdClass objects (see later for more options on retrieving data).
			return $results = $db->loadObjectList();

	}



	function removeKey(){

				// Get a db connection.
			$db = JFactory::getDbo();
			 
			// Create a new query object.
			$query = $db->getQuery(true);

			$query->delete($db->quoteName('#__hapity'));
			$query->where(1);
				
				 
				$db->setQuery($query);
				 
				$result = $db->execute();

	}

	function checkKey($key){


		// Get a db connection.
			$db = JFactory::getDbo();
			 
			// Create a new query object.
			$query = $db->getQuery(true);


			$query->select($db->quoteName(array('key', 'published')));
			$query->from($db->quoteName('#__hapity'));
			$query->where(array("key"=>$key,"published"=>1));
			
			 
			// Reset the query using our newly populated query object.
			$db->setQuery($query);
			 
			// Load the results as a list of stdClass objects (see later for more options on retrieving data).
			return $results = $db->loadObjectList();

	}
}
