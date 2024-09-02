<?php

namespace QThybrid;

class QThybrid_SDK {

	protected $endpoint;
	protected $auth_token;

	function __construct($endpoint, $auth_token = null) {

		$this->endpoint = $endpoint;
		$this->auth_token = $auth_token;
	}

	private function apiRequest($api_url, $app_method = 'GET', $api_data) {

		$url = "{$this->endpoint}$api_url";

		$init = curl_init();
		curl_setopt($init, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($init, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($init, CURLOPT_URL, $url);
		curl_setopt($init, CURLOPT_POST, true);

		$content = curl_exec($init);

		curl_close($init);

		return json_decode($content, true);
	}

	/**
	 * AUthenticate application then returns a token
	 * @param mixed $email 
	 * @param mixed $password 
	 * @return mixed 
	 */

	public function apiLogin($credentials)
	{
		$url = 'auth/login';

		return $this->apiRequest($url, 'POST', $credentials);
	}

}
