<?php

$this->group([

	/**
	*
	* Backend routes main config
	*/
	'namespace' => "System", 
	'as' => "system.", 
	'prefix'	=> "admin",
	// 'middleware' => "", 

], function(){

	$this->group(['middleware' => ["web","system.guest"]], function(){
		$this->get('register/{_token?}',['as' => "register",'uses' => "AuthController@register"]);
		$this->post('register/{_token?}',['uses' => "AuthController@store"]);
		$this->get('login/{redirect_uri?}',['as' => "login",'uses' => "AuthController@login"]);
		$this->post('login/{redirect_uri?}',['uses' => "AuthController@authenticate"]);
	});

	$this->group(['middleware' => ["web","system.auth","system.client_partner_not_allowed"]], function(){
		
		$this->get('lock',['as' => "lock", 'uses' => "AuthController@lock"]);
		$this->post('lock',['uses' => "AuthController@unlock"]);
		$this->get('logout',['as' => "logout",'uses' => "AuthController@destroy"]);

		$this->group(['as' => "account."],function(){
			$this->get('p/{username?}',['as' => "profile",'uses' => "AccountController@profile"]);
			$this->group(['prefix' => "setting"],function(){
				$this->get('info',['as' => "edit-info",'uses' => "AccountController@edit_info"]);
				$this->post('info',['uses' => "AccountController@update_info"]);
				$this->get('password',['as' => "edit-password",'uses' => "AccountController@edit_password"]);
				$this->post('password',['uses' => "AccountController@update_password"]);
			});
		});

		$this->group(['middleware' => ["system.update_profile_first"]], function() {
			$this->get('/',['as' => "dashboard",'uses' => "DashboardController@index"]);

	
			$this->group(['prefix' => "article", 'as' => "article."], function () {
				$this->get('/',['as' => "index", 'uses' => "ArticleController@index"]);
				$this->get('create',['as' => "create", 'uses' => "ArticleController@create"]);
				$this->post('create',['uses' => "ArticleController@store"]);
				$this->get('edit/{id?}',['as' => "edit", 'uses' => "ArticleController@edit"]);
				$this->post('edit/{id?}',['uses' => "ArticleController@update"]);
				$this->any('delete/{id?}',['as' => "destroy", 'uses' => "ArticleController@destroy"]);
			});


		

			$this->group(['prefix' => "news", 'as' => "news."], function () {
				$this->get('/',['as' => "index", 'uses' => "NewsController@index"]);
				$this->get('create',['as' => "create", 'uses' => "NewsController@create"]);
				$this->post('create',['uses' => "NewsController@store"]);
				$this->get('edit/{id?}',['as' => "edit", 'uses' => "NewsController@edit"]);
				$this->post('edit/{id?}',['uses' => "NewsController@update"]);
				$this->any('delete/{id?}',['as' => "destroy", 'uses' => "NewsController@destroy"]);
			});

		
		});
	});
});