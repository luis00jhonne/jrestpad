<?php

class PagesController extends BaseController {

    protected function _home() {
        $this->page_title = 'Home';

        $this->render("pages/index");
    }

    protected function _notes(){
    	$this->page_title = 'Experimente';
    	$this->render("pages/notes");
    	
    }
    protected function _show(){
    	
    	if ( isset( $this->params['id']) ){
    		
    		$conn = Connection::getConnection();
    		$conn->setQuery( "SELECT * FROM tb_mensagem WHERE cl_codigo_sala = '". $this->params['id']."' ");
    		$result = $conn->execut_query('simplex');
    		
    		$result['changed'] = true;
    		
    		return $this->JSONResponse( $result );
    	}
    	
    }

    protected function _salva() {
    	if ( isset ($this->request_params['text']) && isset( $this->params['id']) ){
    		
    		$conn = Connection::getConnection();
    		$conn->setQuery( "SELECT * FROM tb_mensagem WHERE cl_codigo_sala = '". $this->params['id']."' " );
    		$result = $conn->execut_query('simplex');
    		
    		$dados['cl_codigo_mensagem'] = '1';
    		$dados['cl_codigo_sala'] = $this->params['id'];
    		$dados['cl_mensagem'] =  $this->request_params['text'];
    		
    		$conn->update($dados,"tb_mensagem","cl_codigo_mensagem", null, true); //Atualiza a mensagem no servidor
    		
    	}
             
    }
    
}

?>