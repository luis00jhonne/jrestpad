<?php

class PagesController extends BaseController {

    protected function _home() {
        $this->page_title = 'Home';

        $this->render("pages/index");
    }

    protected function _about_us() {
        $this->page_title = 'About us';

        $this->view_assign(array(
            'param1' => 'value1',
            'param2' => array('param2-value1' => 'value1')
        ));

        $this->render("pages/about_us");
    }
    protected function _notes(){
    	$this->page_title = 'Experimente';
    	
    	$this->render("pages/notes");
    	
    }

    protected function _salva() {
    	
    	if ( !empty($this->request_params['conteudo']) ){
    		//$session = !empty($_SESSION['conteudo']) ? $_SESSION['conteudo'] : null;
    		//        if ( isset( $this->request_params ['conteudo'] ) ){
    		//           $this->JSONResponse( array( 'conteudo' => $this->request_params ['conteudo'] ) );
    		//        } else {
    		//           $this->JSONResponse(['conteudo'=> 'amor']);
    		//        }
    		//
    		///echo !empty( $this->request_params['conteudo'] ) ? $this->request_params['conteudo'] : 'no content';
    
    				// var_dump($_POST);
    				//echo 'conteudo';
    				//$_SESSION['conteudo'] = $saida;
    				//$this->JSONResponse( ['conteudo' => $saida] );
    		echo 'Die';
    	}
        
       
             
    }
    
}

?>