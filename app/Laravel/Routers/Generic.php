<?php

$this->group([

	/**
	*
	* Backend routes main config
	*/
	'namespace' => "Generic", 
	'as' => "generic.", 
	// 'prefix'	=> "admin",
	// 'middleware' => "", 

	], function(){

		// $this->get('e71752a2f77b3e407762e7e6fd5df57e.txt',function(){
		// 	echo "Hell World!";
		// });

		// $this->get('webmail',function(){
		// 	return redirect()->to('http://mail.sonicexpress.com.ph/webmail');
		// });

		$this->get('reset-password/{token?}',['as' => "reset_password",'uses' => "ResetPasswordController@index" ]);
		$this->post('reset-password/{token?}',['uses' => "ResetPasswordController@submit" ]);

		$this->get('verify/{token?}',['as' => "verify",'uses' => "VerifyAccountController@verify_email" ]);



		// $this->get('/',['as' => "homepage",'uses' => "MainController@homepage"]);
		// $this->get('track',['as' => "track",'uses' => "MainController@track"]);
		// $this->get('faq',['as' => "faq",'uses' => "MainController@faq"]);

		// $this->get('contact',['as' => "contact",'uses' => "MainController@contact"]);
		// $this->post('contact',['uses' => "MainController@submit_inquiry"]);


		// $this->get('book-now',['as' => "booking",'uses' => "MainController@booking"]);
		// $this->post('book-now',['as' => "submit_booking",'uses' => "MainController@submit_booking"]);

});