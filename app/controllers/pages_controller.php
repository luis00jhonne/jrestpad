<?php

class PagesController extends BaseController {

    protected function _home() {
        $this->page_title = 'Home';

        $this->render("pages/index");
    }

    protected function _notes(){
    	
    	if ( isset( $this->params['id']) ){
    		
    		$result = $this->__buscar( $this->params ['id']);
    		
    		if ( !$result ){ //Senão localizar nenhuma sala com o nome requisitado, redireciona para o index
    			$this->render("pages/index");
    		} else {
    			$this->render("pages/notes");
    		}
    	}
    	
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
    		
	   		$result = $this->__buscar( $this->params['id']);
    		
    		$dados['cl_codigo_mensagem'] = $result['cl_codigo_mensagem'];
    		$dados['cl_codigo_sala'] = $this->params['id'];
    		$dados['cl_mensagem'] =  $this->request_params['text'];
    		
    		$conn = Connection::getConnection();
    		$conn->update($dados,"tb_mensagem","cl_codigo_mensagem", null, true); //Atualiza a mensagem no servidor
    		
    	}
             
    }
    protected function _iniciar(){
    	
    	if ( isset($this->request_params['sala'])){
    		
    		//Busco a sala
    		$result = $this->__buscar( $this->request_params['sala']);
    		
    		if ( !$result ){
    			$this->__salvar();
    		}
    		
    		return $this->JSONResponse( array ( 'novaUrl' => $this->request_params['sala'] ) );
    		
    	}
    }
    
    private function __buscar( $idSala ){
    	
    	$conn = Connection::getConnection();
    	$conn->setQuery( "SELECT * FROM tb_mensagem WHERE cl_codigo_sala = '".$idSala."' " );
    	$result = $conn->execut_query('simplex');
    	return $result;
    }
    private function __salvar(){
    	
    	$dados ['cl_codigo_sala'] = $this->request_params['sala'];
    	$dados ['cl_mensagem'] = null;
    	
    	$conn = Connection::getConnection();
    	return $conn->insert( $dados, 'tb_mensagem', 'cl_codigo_mensagem', TRUE );
    }
    
}

?>