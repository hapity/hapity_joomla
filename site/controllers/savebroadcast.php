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
class HapityControllerSavebroadcast extends JControllerLegacy {

    function getBroadcastData() {
        $result_array = array();
        if (isset($_POST["key"]) && isset($_POST["bid"]) ) {
            $jinput = JFactory::getApplication()->input;
            $key = $jinput->get('key', '', 'STRING');
            $status = $jinput->get('status', '', 'STRING');
            $bid = $jinput->get('bid', '', 'STRING');
            $stream_url = $jinput->get('stream_url', '', 'STRING');
            $title = $jinput->get('title', '', 'STRING');
            $broadcast_image = $jinput->get('broadcast_image', '', 'STRING');
            $description = $jinput->get('description', '', 'STRING');

            $model = $this->getModel('hapity');
            $model->removeIframe();

            if(empty($title)){
                $title = 'no title';
            }

            $is_key = $model->checkKey($key);
            

            if ($is_key[0]->key == $key && $is_key[0]->published == "1") {
                $get_result = $model->createArticle($bid, $title, $stream_url, $status, $key, $broadcast_image, $description);

                if ($get_result['article_id']) {
                    $result_array['post_id_joomla'] = $get_result['article_id'];
                    $result_array['post_url'] = $get_result['article_url'];
                    $result_array['status'] = 'success';
                } else {
                    $result_array['status'] = 'failure';
                }
            } else {
                $result_array['status'] = 'failure';
            }
        }
        print_r(json_encode($result_array));
        die();
    }

    function editBroadcastData() {
        $result_array = array();
        if (isset($_POST["key"]) && isset($_POST["bid"]) && isset($_POST["post_id_joomla"])) {
            $jinput = JFactory::getApplication()->input;
            $key = $jinput->get('key', '', 'STRING');
            $status = $jinput->get('status', '', 'STRING');
            $bid = $jinput->get('bid', '', 'STRING');
            $stream_url = $jinput->get('stream_url', '', 'STRING');
            $title = $jinput->get('title', '', 'STRING');
            $broadcast_image = $jinput->get('broadcast_image', '', 'STRING');
            $description = $jinput->get('description', '', 'STRING');
            $post_id = $jinput->get('post_id_joomla', '', 'STRING');

            $model = $this->getModel('hapity');
            $model->removeIframe();

            if(empty($title)){
                $title = 'no title';
            }
            
            $is_key = $model->checkKey($key);


            if ($is_key[0]->key == $key && $is_key[0]->published == "1") {
                $get_result = $model->editArticle($bid, $title, $stream_url, $status, $key, $broadcast_image, $description, $post_id);

                if ($get_result['article_id']) {
                    $result_array['post_id_joomla'] = $get_result['article_id'];
                    $result_array['post_url'] = $get_result['article_url'];
                    $result_array['status'] = 'success';
                } else {
                    $result_array['status'] = 'failure';
                }
            } else {
                $result_array['status'] = 'failure';
            }
        }
        print_r(json_encode($result_array));
        die();
    }

    function deleteBroadcastData() {
        
        if (isset($_GET["bid"]) && isset($_GET["key"]) && isset($_GET["post_id_joomla"])) {
            $jinput = JFactory::getApplication()->input;
            $key = $jinput->get('key', '', 'STRING');
            $bid = $jinput->get('bid', '', 'STRING');
            $post_id = $jinput->get('post_id_joomla', '', 'STRING');
            $model = $this->getModel('hapity');
            $is_key = $model->checkKey($key);
           
            if ($is_key[0]->key == $key && $is_key[0]->published == "1") {
              $get_result = $model->deleteArticle($post_id);
              if($get_result){
                  $result_array['status'] = 'success';
              } else {
                  $result_array['status'] = 'failure';
              }
              
            } else {
                $result_array['status'] = 'invalid key';
            }
        }
        
        
        print_r(json_encode($result_array));
        die();
    }

}
