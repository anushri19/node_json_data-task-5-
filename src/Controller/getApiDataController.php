<?php

namespace Drupal\node_json_data\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Drupal\Core\Database\Database;

class getApiDataController extends ControllerBase {
    

public function getApiDataController($apikey, $node_id, $content_type) {
 //header table
 $header_table = array(
 'node_id'=> t('id'),
 'content_type'=> t('content type'),
 'apiKey' => t('apikey'),
 
 );

// fetching api key from config data
$config = \Drupal::service('config.factory')->getEditable('system.site');
$api=$config->get('api');

// verifying config apikey from entered api key in url
if($api==$apikey){

	$node_storage = \Drupal::entityTypeManager()->getStorage('node');
	$node = $node_storage->load($node_id);
	$type=$node->bundle();
	
	// verifying that content tytpe exist and it include the node of give node_ID
	if($type == $content_type){



			 $rows=array();

			    $rows[] = array(
			    'apikey' => $apikey,
			    'content_type'=> $content_type,
			    'title'=>$node->get('title')->value,
			    'type'=>$node->bundle(),
			 );

			 //display data in site
			 $form['table'] = [
			 '#type' => 'table',
			 '#header' => $header_table,
			 '#rows' => $rows,
			 '#empty' => t('No users found'),
			 ];
			 return new JsonResponse( $form );


			}
			else{
				die("Error: Content type does not exist.");
			}

	}



	else{
		die("Error: API key does not exist.");
	}

}}
