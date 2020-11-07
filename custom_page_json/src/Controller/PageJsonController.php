<?php

namespace Drupal\custom_page_json\Controller;

use Drupal\node\Entity\Node;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class PageJsonController{

	public function pagejson(){

		$params = \Drupal::routeMatch()->getParameters();
		$siteapikey = $params->get('siteapikey');
		$nodeid = $params->get('nodeid');

		$site_key = \Drupal::state()->get('siteapikey');
		if ($site_key != $siteapikey) {
			//access denied exeption
			throw new AccessDeniedHttpException();
		}

	    $serializer = \Drupal::service('serializer');
		$node = Node::load($nodeid);
		$data = $serializer->serialize($node, 'json', ['plugin_id' => 'entity']);

	    return new JsonResponse($data);
	}
}