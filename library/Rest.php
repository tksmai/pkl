<?php
/**
 * @name rest
 * @author Tsukasa Yukinoshita
 */
abstract class Rest extends Yaf_Controller_Abstract {
	protected $_post_data;
	protected function init()
	{
		$this->_post_data = json_decode(file_get_contents('php://input'), true);
	}

	protected function respone(array $data, int $http_code = null, array $option = null)
	{
		// @$json_option = (int)$option['json_option'] ?? 0;
		// @$json_depth = (int)$option['json_depth'] ?? 512;
		$http_code = $http_code ?? 200;
		$status_text = (string)$option['status_text'] ?? null;
		header('Content-Type:application/json; charset=utf-8');
		$this->sendHttpStatus($http_code, $status_text);
		// exit(json_encode($data, $json_option, $json_depth));
		exit(json_encode($data));
	}
	protected function sendHttpStatus(int $code, string $custom_text = null) {
		static $_status = array(
			// Informational 1xx
			100 => 'Continue',
			101 => 'Switching Protocols',
			// Success 2xx
			200 => 'OK',
			201 => 'Created',
			202 => 'Accepted',
			203 => 'Non-Authoritative Information',
			204 => 'No Content',
			205 => 'Reset Content',
			206 => 'Partial Content',
			// Redirection 3xx
			300 => 'Multiple Choices',
			301 => 'Moved Permanently',
			302 => 'Moved Temporarily ',  // 1.1
			303 => 'See Other',
			304 => 'Not Modified',
			305 => 'Use Proxy',
			// 306 is deprecated but reserved
			307 => 'Temporary Redirect',
			// Client Error 4xx
			400 => 'Bad Request',
			401 => 'Unauthorized',
			402 => 'Payment Required',
			403 => 'Forbidden',
			404 => 'Not Found',
			405 => 'Method Not Allowed',
			406 => 'Not Acceptable',
			407 => 'Proxy Authentication Required',
			408 => 'Request Timeout',
			409 => 'Conflict',
			410 => 'Gone',
			411 => 'Length Required',
			412 => 'Precondition Failed',
			413 => 'Request Entity Too Large',
			414 => 'Request-URI Too Long',
			415 => 'Unsupported Media Type',
			416 => 'Requested Range Not Satisfiable',
			417 => 'Expectation Failed',
			// Server Error 5xx
			500 => 'Internal Server Error',
			501 => 'Not Implemented',
			502 => 'Bad Gateway',
			503 => 'Service Unavailable',
			504 => 'Gateway Timeout',
			505 => 'HTTP Version Not Supported',
			509 => 'Bandwidth Limit Exceeded'
		);
		$custom_text = $custom_text ?? $_status[$code];
		if(isset($_status[$code])) {
			header('HTTP/1.1 '.$code.' '.$custom_text);
			// 确保FastCGI模式下正常
			header('Status:'.$code.' '.$custom_text);
		}
	}
}
?>