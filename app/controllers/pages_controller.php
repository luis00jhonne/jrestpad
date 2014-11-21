<?php

class PagesController extends BaseController {

    protected function _home() {
        $this->page_title = 'Home';
		$this->doctype = "html5";
        $this->render("pages/index");
    }

    protected function _notes(){
    	
    	if ( isset( $this->params['id']) ){
    		
    		$result = $this->_buscar( $this->params ['id']);
    		
    		if ( !$result ){ //Senão localizar nenhuma sala com o nome requisitado, redireciona para o index
    			header ( "Location: index.php");
    			exit();
    		} else {
    			$this->page_title = $this->params['id'];
    			$this->render("pages/notes");
    		}
    	}
    	
    }
    protected function _show(){
    	
    	if ( isset( $this->params['id']) ){
    		
    		$result = $this->_buscar( $this->params['id'] );

    		if ( is_array($result) ){
    			$result['changed'] = true;
    			return $this->JSONResponse( $result );
    		}
    	}
    	
    }

    protected function _atualiza() {
    	if ( isset ($this->request_params['text']) && isset( $this->params['id']) ){
    		
	   		$result = $this->_buscar( $this->params['id']);
	   		
	   		if ( $result ){
	   			$dados['cl_codigo_mensagem'] = $result['cl_codigo_mensagem'];
	   			$dados['cl_codigo_sala'] = $this->params['id'];
	   			$dados['cl_mensagem'] =  $this->request_params['text'];
	   			
	   			$conn = Connection::getConnection();
    			$conn->update($dados,"tb_mensagem","cl_codigo_mensagem", null, true); //Atualiza a mensagem no servidor
	   		}
    			
    	}
             
    }
    protected function _iniciar(){
    	
    	if ( isset($this->request_params['sala'])){
    		
    		//Busco a sala
    		$result = $this->_buscar( $this->request_params['sala']);
    		
    		if ( !$result && $this->_salvar() ){ //Senão localizar, salva. Se não salvar, reenvia para home
				return $this->JSONResponse( array ( 'novaUrl' => $this->request_params['sala'] ) ); 			
    		}
    		return $this->JSONResponse( array ( 'novaUrl' => 'index.php' ) );
    	}
    }
    
    private function _buscar( $idSala ){
    	
    	$conn = Connection::getConnection();
    	$conn->setQuery( "SELECT * FROM tb_mensagem WHERE cl_codigo_sala = '".$idSala."' " );
    	return $conn->execut_query('simplex');
    }
    
    private function _salvar(){
    	
    	$dados ['cl_codigo_sala'] = $this->request_params['sala'];
    	$dados ['cl_mensagem'] = '';
    	
    	$conn = Connection::getConnection();
    	return $conn->insert( $dados, 'tb_mensagem', 'cl_codigo_mensagem', TRUE );
    }
    
}

?>