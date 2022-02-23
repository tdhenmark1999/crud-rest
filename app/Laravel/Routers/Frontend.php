<?php

$this->group([

	/**
	*
	* Backend routes main config
	*/
	'namespace' => "Frontend", 
	'as' => "frontend.", 
	// 'prefix'	=> "admin",
	// 'middleware' => "", 

	], function(){

		$this->get('/', ['as' => "main",'uses' => "MainController@index"]);

	
		$this->group(['prefix' => "api", 'as' => "api."], function () {
			$this->get('/',['uses' => "NewsController@index"]);
			$this->post('create',['uses' => "NewsController@create"]);
			$this->post('/edit/{id?}',['as'=>"update",'uses' => "NewsController@update"]);
			$this->delete('/destroy/{id?}',['as' => "delete",'uses' => "NewsController@destroy"]);
		});



		
	
});