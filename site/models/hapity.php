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
	





	function checkKey($key){


		// Get a db connection.
			$db = JFactory::getDbo();
			 
			// Create a new query object.
			$query = $db->getQuery(true);


			$query->select($db->quoteName(array('key', 'published')));
			$query->from($db->quoteName('#__hapity'));
			$query->where($db->quoteName("key").'="'.$key.'" AND '.$db->quoteName("published")."= 1");
			
			 
			// Reset the query using our newly populated query object.
			$db->setQuery($query);
			 
			// Load the results as a list of stdClass objects (see later for more options on retrieving data).
			return $results = $db->loadObjectList();

	}

	function createArticle($bid,$title,$sUrl,$status,$key,$broadcast_image){
		$table = JTable::getInstance('Content', 'JTable', array());

		$iframe = '<iframe height="600" width="100%" scrolling="no" frameborder="0" src="http://api.hapity.com/widget.php?broadcast_image='.$broadcast_image.'&stream='.$sUrl.'&title='.$title.'&status='.$status.'&bid='.$bid.'"></iframe>';
                
		$data = array(
			'alias'=>"broad-cast-".rand(100,100000000000000),
		    'catid' => 0,
		    'title' => $title,
		    'introtext' => '',
		    'fulltext' => $iframe,
		    'state' => 1,
		    "featured"=>1,
		    'metadata' => '{"og:description":"'.$title.'","og:image":"'.$broadcast_image.'","og:title":"'.$title.'"}',
		    "created_by_alias"=>"Hapity.com"
		);


		// Bind data
if (!$table->bind($data))
{
    
    die("failed 1");
}

// Check the data.
if (!$table->check())
{
    
    die("failed 2");
}

// Store the data.
if (!$table->store())
{


    
    die($table->getError());
}
else{

   $id = $table->id; 
   $article_url = JURI::root().'index.php?option=com_content&view=article&id='.$id;
   $table->load($id);
   $data = array(
            'alias'=>"broad-cast-".rand(100,100000000000000),
        'catid' => 0,
        'title' => $title,
        'introtext' => '',
        'fulltext' => $iframe,
        'state' => 1,
        "featured"=>1,
        'metadata' => '{"og:description":"'.$title.'","og:image":"'.$broadcast_image.'","og:title":"'.$title.'","og:url":"'.$article_url.'"}',
        "created_by_alias"=>"Hapity.com"
    );
   $table->bind($data);
   $table->store();
   echo $article_url;
   die();
}




	}



	function removeIframe(){

		// Get a db connection.
			$db = JFactory::getDbo();
			 
			// Create a new query object.
			$query = $db->getQuery(true);


			$query->select($db->quoteName(array('params')));
			$query->from($db->quoteName('#__extensions'));
			$query->where($db->quoteName("name").'="plg_editors_tinymce"');


			// Reset the query using our newly populated query object.
			$db->setQuery($query);
			 
			// Load the results as a list of stdClass objects (see later for more options on retrieving data).
			 $results = $db->loadObjectList();

			 foreach ($results as $key => $value) {

			 	if(!isset($value->params)) continue;

			 	$data = json_decode($value->params);

			 	if(!isset($data->invalid_elements)) continue;

			 	$data->invalid_elements = str_replace("iframe","",$data->invalid_elements);

			 	$json = json_encode($data);



			 	// Insert columns.
			$columns = array($db->quoteName("params")."='".$json."'");
			

			$query
			    ->update($db->quoteName('#__extensions'))
			    ->set($columns);
			    // Set the query using our newly populated query object and execute it.
			$db->setQuery($query);
			$db->execute();

			 	
			 	# code...
			 }
			

	}
}