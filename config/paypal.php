<?php
return array(
	// set your paypal credential
//	'client_id' => 'AVCyO27zdBHdSw8rPP4ePsrqsrRsURY1GYf-rQFaFo1ip6eTGPRcwiPaf-DT56ZjKATnTt3Q-QG989bv',
//	'secret' => 'EFW6iff8Q7iXeXbYCctbRpFvUulOJ2OHf-8PTr_bmi9USdmnNBaDkJUDnUek5skSXcijXee-elNwnf-q',
	'client_id' => 'AZpJNw8vaNNalobfkIqJT5JKz0tw8qQv_Ks5avWJLMskgWwFiw_9WjdcF6A5bacTxLapb1806wHbq2l6',
	'secret' => 'EMFJHhVORn09HEAX1Zsboch0Qb5r8Zivg6yQklebSSjFaZESxNOh49MGwFno6Uweg-K5v08xfHn0a0yn',

	/**
	 * SDK configuration
	 */
	'settings' => array(
		/**
		 * Available option 'sandbox' or 'live'
		 */
		'mode' => 'live',

		/**
		 * Specify the max request time in seconds
		 */
		'http.ConnectionTimeOut' => 30,

		/**
		 * Whether want to log to a file
		 */
		'log.LogEnabled' => true,

		/**
		 * Specify the file that want to write on
		 */
		'log.FileName' => storage_path() . '/logs/paypal.log',

		/**
		 * Available option 'FINE', 'INFO', 'WARN' or 'ERROR'
		 *
		 * Logging is most verbose in the 'FINE' level and decreases as you
		 * proceed towards ERROR
		 */
		'log.LogLevel' => 'FINE'
	),
);