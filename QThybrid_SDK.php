<?php

namespace QThybrid;

class QThybrid_SDK {

	protected $endpoint;
	protected $auth_token;

	/**
	 * 
	 * @param mixed $endpoint example http://test.cloudvlt.net/api
	 * @param mixed $auth_token optianal when calling unauthenticated requests
	 * @return void 
	 */

	function __construct($endpoint, $auth_token = null) {

		$this->endpoint = $endpoint;
		$this->auth_token = $auth_token;
	}

	private function apiRequest($api_url, $app_method = 'GET', $api_data = []) {

		$url = "{$this->endpoint}/$api_url";

		$init = curl_init();

		$headers = ['Content-Type: application/json'];

		if ($this->auth_token) {
			$authorization = "Authorization: Bearer {$this->auth_token}";
			$headers = ['Content-Type: application/json', $authorization];			
		}
		curl_setopt($init, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($init, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt($init, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($init, CURLOPT_URL, $url);
		curl_setopt( $init, CURLOPT_CUSTOMREQUEST, $app_method );
		curl_setopt( $init, CURLOPT_POSTFIELDS, $api_data );

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

	public function apiGetLoginByUrl()
	{
		$url = 'auth/link';

		return $this->apiRequest($url, 'GET');
	}

	public function apiGetPlayer()
	{
		$url = 'account/user';

		return $this->apiRequest($url, 'GET');
	}

}
