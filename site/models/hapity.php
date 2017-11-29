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
class HapityModelHapity extends JModelList {

    function checkKey($key) {


        // Get a db connection.
        $db = JFactory::getDbo();

        // Create a new query object.
        $query = $db->getQuery(true);


        $query->select($db->quoteName(array('key', 'published')));
        $query->from($db->quoteName('#__hapity'));
        $query->where($db->quoteName("key") . '="' . $key . '" AND ' . $db->quoteName("published") . "= 1");


        // Reset the query using our newly populated query object.
        $db->setQuery($query);

        // Load the results as a list of stdClass objects (see later for more options on retrieving data).
        return $results = $db->loadObjectList();
    }

    function createArticle($bid, $title, $sUrl, $status, $key, $broadcast_image, $description) {
        $result_data = array();
        $table = JTable::getInstance('Content', 'JTable', array());
        $id = $table->id;
        $alias = "broad-cast-" . rand(100, 100000000000000);
        $article_url = JURI::root().'index.php/' . $id . '-' . $alias;

        $data_content = '';
        if (!empty($sUrl)) {
            $iframe = '<iframe height="600" width="100%" scrolling="no" frameborder="0" src="http://api.hapity.com/widget.php?broadcast_image=' . $broadcast_image . '&stream=' . $sUrl . '&title=' . $title . '&status=' . $status . '&bid=' . $bid . '"></iframe>';
            $data_content = $iframe;
        } else if (!empty($broadcast_image)) {
            $data_content = '<div style="width:100%;"><img src="' . $broadcast_image . '"></div>';
        }
        if (!empty($description)) {
            $data_content .= '<p style="margin-top:20px">' . $description . '</p>';
        }



        $data = array(
            'alias' => "broad-cast-" . rand(100, 100000000000000),
            'catid' => 2,
            'title' => $title,
            'introtext' => '',
            'fulltext' => $data_content,
            'state' => 1,
            "featured" => 1,
            'metadata' => '{
                "og:description":"' . $title . '",
                "og:image":"' . $broadcast_image . '",
                "og:title":"' . $title . '",
                "og:url":"' . $article_url . '",
                "twitter:card":"summery",
                "twitter:title":"' . $title . '",
                "twitter:description":"' . $description . '",
                "twitter:url":"' . $article_url . '",
                "twitter:image":"' . $broadcast_image . '"
            }',
            "created_by_alias" => "Hapity.com"
        );


        // Bind data
        if (!$table->bind($data)) {

            die("failed 1");
        }

        // Check the data.
        if (!$table->check()) {

            die("failed 2");
        }

        // Store the data.
        if (!$table->store()) {



            die($table->getError());
        } else {

            $id = $table->id;
            $alias = "broad-cast-" . rand(100, 100000000000000);
            $article_url = JURI::root().'index.php/' . $id . '-' . $alias;

            $table->load($id);
            $data = array(
                'alias' => $alias,
                'catid' => 2,
                'title' => $title,
                'introtext' => '',
                'fulltext' => $data_content,
                'state' => 1,
                "featured" => 1,
                'metadata' => '{
                    "og:description":"' . $title . '",
                    "og:image":"' . $broadcast_image . '",
                    "og:title":"' . $title . '",
                    "og:url":"' . $article_url . '",
                    "twitter:card":"summery",
                    "twitter:title":"' . $title . '",
                    "twitter:description":"' . $description . '",
                    "twitter:url":"' . $article_url . '",
                    "twitter:image":"' . $broadcast_image . '"
                }',
                "created_by_alias" => "Hapity.com"
            );
            $table->bind($data);
            $table->store();

            $result_data['article_id'] = $id;
            $result_data['article_url'] = $article_url;
            return $result_data;
        }
    }

    function editArticle($bid, $title, $sUrl, $status, $key, $broadcast_image, $description, $post_id) {
        $result_data = array();
        $table = JTable::getInstance('Content', 'JTable', array());

        $id = $table->id;
        $alias = "broad-cast-" . rand(100, 100000000000000);
        $article_url = JURI::root().'index.php/' . $id . '-' . $alias;

        $data_content = '';
        if (!empty($sUrl)) {
            $iframe = '<iframe height="600" width="100%" scrolling="no" frameborder="0" src="http://api.hapity.com/widget.php?broadcast_image=' . $broadcast_image . '&stream=' . $sUrl . '&title=' . $title . '&status=' . $status . '&bid=' . $bid . '"></iframe>';
            $data_content = $iframe;
        } else if (!empty($broadcast_image)) {
            $data_content = '<div style="width:100%;"><img src="' . $broadcast_image . '"></div>';
        }
        if (!empty($description)) {
            $data_content .= '<p style="margin-top:20px">' . $description . '</p>';
        }

        $data = array(
            'id' => $post_id,
            //'alias' => "broad-cast-" . rand(100, 100000000000000),
            'catid' => 2,
            'title' => $title,
            'introtext' => '',
            'fulltext' => $data_content,
            'state' => 1,
            "featured" => 1,
            'metadata' => '{
                "og:description":"' . $title . '",
                "og:image":"' . $broadcast_image . '",
                "og:title":"' . $title . '",
                "og:url":"' . $article_url . '",
                "twitter:card":"summery",
                "twitter:title":"' . $title . '",
                "twitter:description":"' . $description . '",
                "twitter:url":"' . $article_url . '",
                "twitter:image":"' . $broadcast_image . '"
            }',
            "created_by_alias" => "Hapity.com"
        );


        // Bind data
        if (!$table->bind($data)) {
            die("failed 1");
        }

        // Check the data.
        if (!$table->check()) {
            die("failed 2");
        }

        // Store the data.
        if (!$table->store()) {
            die($table->getError());
        } else {

            $id = $table->id;
            $alias = "broad-cast-" . rand(100, 100000000000000);
            $article_url = JURI::root().'index.php/' . $id . '-' . $alias;

            $table->load($id);
            $data = array(
                'id' => $post_id,
                'title' => $title,
                'fulltext' => $data_content,
                'metadata' => '{
                    "og:description":"' . $description . '",
                    "og:image":"' . $broadcast_image . '",
                    "og:title":"' . $title . '",
                    "og:url":"' . $article_url . '",
                    "twitter:card":"summery",
                    "twitter:title":"' . $title . '",
                    "twitter:description":"' . $description . '",
                    "twitter:url":"' . $article_url . '",
                    "twitter:image":"' . $broadcast_image . '"
                }',
            );
            $table->bind($data);
            $table->store();

            $result_data['article_id'] = $id;
            //$result_data['article_url'] = $url;
            return $result_data;
        }
    }

    function deleteArticle($post_id) {
     
        $table = JTable::getInstance('Content', 'JTable', array());

        $data = array(
            'id' => $post_id,
        );
        
        $table->delete($data);
        $result_data = $table->id;
        return $result_data;
    }

    function removeIframe() {

        // Get a db connection.
        $db = JFactory::getDbo();

        // Create a new query object.
        $query = $db->getQuery(true);


        $query->select($db->quoteName(array('params')));
        $query->from($db->quoteName('#__extensions'));
        $query->where($db->quoteName("name") . '="plg_editors_tinymce"');


        // Reset the query using our newly populated query object.
        $db->setQuery($query);

        // Load the results as a list of stdClass objects (see later for more options on retrieving data).
        $results = $db->loadObjectList();

        foreach ($results as $key => $value) {

            if (!isset($value->params))
                continue;

            $data = json_decode($value->params);

            if (!isset($data->invalid_elements))
                continue;

            $data->invalid_elements = str_replace("iframe", "", $data->invalid_elements);

            $json = json_encode($data);



            // Insert columns.
            $columns = array($db->quoteName("params") . "='" . $json . "'");


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
