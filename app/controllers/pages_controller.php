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

    protected function _salva() {
        
        $this->JSONResponse( array('conteudo'=> 'amor'));
        if ( isset( $this->request_params ['conteudo'] ) ){
           $this->JSONResponse( array( 'conteudo' => $this->request_params ['conteudo'] ) );
        } else {
           $this->JSONResponse(['conteudo'=> 'amor']);
        }
        
        
        
    }
    
}

?>