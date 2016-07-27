<?php
if (! defined ( 'SIMPLE_CORE_INITED' ))
	exit ( 'No direct script access allowed' );

/**
 *  @brief Conditional define
 *
 *  @param [in] $name name of define
 *  @param [in] $value value of define
 */
if ( ! function_exists('my_conditional_define')){
	function my_conditional_define($name, $value)
	{
		if(defined($name)===FALSE)
		{
			define($name, $value);
		}
	}
}
/*Hibakiíráshoz a hiba típusa*/
my_conditional_define('SEVERITY_ERROR', 1);
my_conditional_define('SEVERITY_WARNING', 2);
my_conditional_define('SEVERITY_NOTICE', 3);

/*Logolási szintek*/
my_conditional_define ( 'LOGGER_SYSTEM', - 1 );
my_conditional_define ( 'LOGGER_DISABLED', 0 );
my_conditional_define ( 'LOGGER_ERROR', 1 );
my_conditional_define ( 'LOGGER_WARNING', 2 );
my_conditional_define ( 'LOGGER_INFO', 3 );
my_conditional_define ( 'LOGGER_DEBUG', 4 );


/*
Hibakódok
 */
my_conditional_define('ERR_OK', 0);
my_conditional_define('ERR_URL', 1); /*hibás url cím*/
my_conditional_define('ERR_UNK_ROUTE', 2); /*ismertlen útvonal*/
my_conditional_define('ERR_UNK_METHOD', 3); /*metódus nem található*/

