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
 * hapitys Controller
 *
 * @since  0.0.1
 */
class HapityControllerSavebroadcast  extends JControllerLegacy
{
    
	function getBroadcastData(){
            
            
            
            
            

    
		if(isset($_GET["key"]) && isset($_GET["bid"]) && isset($_GET["stream_url"]) 
                        && isset($_GET["title"]) && isset($_GET["broadcast_image"]) ){
                            
                         

                        $jinput = JFactory::getApplication()->input;
                        $key = $jinput->get('key','', 'STRING');
                        $status = $jinput->get('status','', 'STRING');
                        $bid = $jinput->get('bid','', 'STRING');
                        $stream_url = $jinput->get('stream_url','', 'STRING');
                        $title = $jinput->get('title','', 'STRING');
                        $broadcast_image = $jinput->get('broadcast_image','', 'STRING');
                        
                        $model = $this->getModel('hapity');
                        $model->removeIframe();


                        $is_key = $model->checkKey($key);
                  
                        if(true){
                            $model->createArticle($bid,$title,$stream_url,$status,$key,$broadcast_image);
                       
                        }


                }
                    
		
                    
	}
}