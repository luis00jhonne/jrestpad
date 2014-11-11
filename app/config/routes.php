<?php 

Router\Helper::map("pages", array(
	"(/|/home)/?"	=> array("get" => "home", "post" => "salva"), //A rota do POST é index também
	"(/|/home)/index?"	=> array("get" => "home" ),
	"(/|/home)/about_us?"	=> array("get" => "about_us"),
	"(/|/home)/notes/?"	=> array("get" => "notes")
));

// For more(more!!) examples see : //
// https://gist.github.com/fidelisrafael/6592558 //

?>