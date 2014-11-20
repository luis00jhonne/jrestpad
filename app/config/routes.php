<?php 

Router\Helper::map("pages", array(
	"(/|/home)/?"	=> array("get" => "home" ), //A rota do POST é index também
	"(/|/home)/:id?"	=> array("get" => "notes", "post" => "salva" ),
	"(/|/home)/:id/json?"	=> array("get" => "show" ),
));

// For more(more!!) examples see : //
// https://gist.github.com/fidelisrafael/6592558 //

?>