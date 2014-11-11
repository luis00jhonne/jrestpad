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
    	if ( isset ($this->request_params['conteudo']) ){
    		
    		$conn = Connection::getConnection();
    		$conn->setQuery( 'SELECT * FROM tb_mensagem WHERE cl_codigo_mensagem = 1' );
    		$result = $conn->execut_query('simplex');
    		
    		//Concatena com a nova mensagem
    		$novaMsg = $result['cl_mensagem'] . '\n' . $this->request_params['conteudo'];
    		$dados['cl_codigo_mensagem'] = '1';
    		$dados['cl_codigo_sala'] = '1';
    		$dados['cl_mensagem'] = $novaMsg;
    		
    		$conn->update($dados,"tb_mensagem","cl_codigo_mensagem", null, true); //Atualiza a mensagem no servidor
    		
    		//Retorna a mensagem nova
    		echo $novaMsg;
    		
    	}
             
    }
    
}

?>