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
class HapityControllerHapitySave extends JControllerAdmin
{
	/**
	 * Proxy for getModel.
	 *
	 * @param   string  $name    The model name. Optional.
	 * @param   string  $prefix  The class prefix. Optional.
	 * @param   array   $config  Configuration array for model. Optional.
	 *
	 * @return  object  The model.
	 *
	 * @since   1.6
	 */
	public function getForm()
	{

		$app = JFactory::getApplication();

		 if(isset($_POST['submit']) && isset($_POST['enable_key']) && isset($_POST['hapity_key']) && $_POST["hapity_key"] != ""){
             $model = $this->getModel('hapity'); 
             $model->updateStatus((int)$_POST['enable_key']);
             $app->redirect(JUri::base() ."index.php?option=com_hapity","Data Saved",'message');
          }

          

          $app->redirect(JUri::base() ."index.php?option=com_hapity");

	}

	public function validateKey(){

		$model = $this->getModel('hapity'); 

      

		$jinput = JFactory::getApplication()->input;
		$key = $jinput->get('hapity_key',"", 'STRING');
        $url_get_key = "http://api.hapity.com/webservice/validate_key?callback=joomla_callback&auth_key=".$key."&url=".str_replace("administrator/","",JUri::base())."&type=joomla"; //MOD REWRITE Disabled

       try {
		$ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url_get_key );
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE );
        curl_setopt($ch, CURLOPT_HEADER, 0 );

         $results = curl_exec($ch);
          $jsonp = substr($results , strpos($results , '('));
         $data =  (array)json_decode(trim($jsonp,'();'),true);
          if(isset($data["status"]) && $data["status"] == "success" && isset($data["message"]) && $data["message"] == 1){
          	$model->saveKey($key);
            die(json_encode(array("status"=>"ok","msg"=>1)));
          }else{
          die(json_encode(array("status"=>"error","msg"=>0)));
          }

         } catch (Exception $e) {
    
    die(json_encode(array("status"=>"error","msg"=>$e->getMessage())));
      }

		die($results);
	}


	function removeKey(){
		  $model = $this->getModel('hapity'); 
		  $model->removeKey();
	}

	function getBroadcastData(){

		// if(isset($_GET["action"]) 
		// 	&& isset($_GET["stream_url"])
		// 	&& isset($_GET["bid"])
		// 	&& isset($_GET["key"])
		// 	){
                $jinput = JFactory::getApplication()->input;
            var_dump($key = $jinput->get('key',"", 'STRING'));

			$model = $this->getModel('hapity'); 
			die;



		//}

	}
}