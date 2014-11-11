<?php 

class AppConfig {

	/**
	* Default Framework(Slim) Configs
	* @access protected
	* @var array
	*/
	protected static $defaultConfig = array(
		"templates.path" => VIEWS_FOLDER ,
		"layout.file"    =>  "./layouts/layout.php"
	);
	
	/**
	* Get configuration
	* 
	* Set app configurations and return array of configurations
	* @return array Web App configs
	*/
	public static function get() {
		self::showAllErrors();
		self::defineConstants();
		self::loadFiles();
		return self::$defaultConfig ;
	}

	/**
	 * Set PHP directives to notify of all errors
	 *
	 **/
	public static function showAllErrors() {
		error_reporting(E_ALL);
		ini_set('display_errors', '1');
	}

	/**
	* Load Files
	* 
	* Loads all base files
	*/
	public static function loadFiles() {
		$autoload = array(
			CONTROLLERS_FOLDER 			. "/base_controller.php" , 
			LIB_FOLDER			 		. "/routes_helper.php"	 , 
		);
		foreach ($autoload as $file) require_once($file);
	}

	/**
	 * Define app top level constants
	 *
	 **/
	public static function defineConstants() {
		define("APP_FOLDER" 			, ROOT 				. "/app"				); 
		define("VIEWS_FOLDER" 			, APP_FOLDER		. "/views/"				); 
		define("MODELS_FOLDER" 			, APP_FOLDER		. "/models/"			); 
		define("MAILS_FOLDER" 			, APP_FOLDER		. "/mailers/"			); 
		define("CONTROLLERS_FOLDER" 	, APP_FOLDER		. "/controllers/"		); 
		define("CONFIG_FOLDER" 			, APP_FOLDER		. "/config/"			); 
		define("PRESENTERS_FOLDER"		, APP_FOLDER		. "/presenters/"		); 
		define("VENDOR_FOLDER" 			, ROOT 				. "/vendor/"			); 
		define("LIB_FOLDER" 			, ROOT 				. "/libs/"				);
		define("ENDERECO_BANCO", "localhost"); //Endereço do banco de dados
		define("USUARIO", "root"); //Nome do usuário
		define("SENHA", "qu3MMeDERAaoM3n051X"); //Senha de acesso ao banco de dados
		define("NOME_BANCO", "jrestpad"); //Nome do banco de dados
		define("PORT_POSTGRES", null); //POSTGRES do banco de dados
		define("SGDB", null); //
	}
}
?>