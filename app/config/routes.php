<?php
Router\Helper::map ( "pages", array (
		"(/|/home)/?" => array (
				"get" => "home",
				"put" => "iniciar"
		),
		"(/|/home)/:id?" => array (
				"get" => "notes",
         		"post" => "atualiza" 
		), // A rota do POST é index também
		"(/|/home)/:id/json?" => array (
				"get" => "show" 
		) 
) );
