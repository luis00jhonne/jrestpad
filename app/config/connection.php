<?php

/**
 * Classe de conexão com o banco de dados.
 * Atributos:
 *
 *  Gera a query de INSERT
 *  Gera a query de UPDATE
 *  Gara a query de DELETE
 *  Gera a query de SELECT, com criação da condição da query
 *  Registra o log de todas as querys executadas
 *  junto com o nome do usuário logado no sistema.
 *
 */
class Connection {

    private $endereco = ENDERECO_BANCO; //Endereço do banco de dados
    private $user = USUARIO; //Nome do usuário
    private $senha = SENHA; //Senha de acesso
    private $banco = NOME_BANCO; //Nome do banco de dados
    private $sgdb = SGDB; //Tipo de SGDB ha ser usado para a conexão.
    private $portaPg = PORT_POSTGRES; //Porta de comunicação do banco de dados POSTGRES
    private $usuarioSistema = USUARIO_SISTEMA; //A variavel que quarda o nome do usuario do sistema.
    private $query; //Query para ser executado.
    private $queryLog; //Query para registrar o log
    private static $instance;
    public $id; //ID de conexão com o banco

    private function __construct() {
        $this->connection(); //Inicia a Conexão
    }

    public static function getConnection() {

        if (!isset(self::$instance)) {
            self::$instance = new Connection();
        }
        return self::$instance;
    }

    /**
     * Realiza a conexação com o sgdb informado.
     * @param $sgdb = [mysql||postgres]
     * @return unknown_type
     */
    function connection() {

        //Se já existir a conexão, retorna verdadeiro
        if (isset($this->id) && is_resource($this->id)) {
            $this->id->set_charset('utf-8');
            return true;
        }

        if ($this->sgdb == "mysql" || $this->sgdb == "") {

            $this->conexao_mysql();
        }

        if ($this->sgdb == "postgres") {

            $this->conexao_pg();
        }
    }

    /**
     * Conexão com banco de dados MYSQL.
     * @return unknown_type
     */
    private function conexao_mysql() {

        // Faz a conexão bom Banco de Dados
        $this->id = new mysqli($this->endereco, $this->user, $this->senha, $this->banco);

        // Verifica se foi realiza a conexão com o banco de dados
        if (!$this->id) {
            die("ERRO: Não foi possível realizar a conexão ao banco de dados!");
        }

        $this->id->set_charset('utf-8');
    }

    /**
     * Realiza a conexão bom o banco de dados POSTGRES.
     * @return unknown_type
     */
    private function conexao_pg() {

        $this->id = pg_connect("host=" . $this->endereco . " port=" . $this->portaPg . " dbname=" . $this->banco . " user=" . $this->user . " password=" . $this->senha . " ");

        pg_set_client_encoding('utf8', $this->id);

        if (!$this->id) {
            die("ERRO: Não foi possível realizar a conexão ao banco de dados!");
        }

        return;
    }

    private function close_connection() {

        if ($this->sgdb == "mysql" || $this->sgdb == "") {

            mysqli_close($this->id);
        }

        if ($this->sgdb == "postgres") {

            pg_close($this->id);
        }

        return;
    }

    public function getIdConection() {

        $this->connection(); //Recheca a conexão

        return $this->id;
    }

    public function setQuery($query) {

        $this->query = $query;

        return;
    }

    /**
     * Executa a query.
     * @param $type_query = [null||simplex||insert||update||delete]
     * @return null
     */
    public function execut_query($type_query = null, $log = false) {

        $this->connection();

        if ($this->sgdb == "mysql" || $this->sgdb == "") {

            return $this->execut_query_mysql($type_query, $log);
        }

        if ($this->sgdb == "postgres") {

            $this->execut_query_pg($type_query);

            return;
        }

        return;
    }

    private function execut_query_mysql($type_query = null, $log = false) {

        $result = mysqli_query($this->id, $this->query);

        if (empty($type_query)) {

            if (mysqli_affected_rows($this->id) > 0) {
                return $this->resultQuery($result);
            }
        }

        //Select com apenas um linha de resultado.
        if ($type_query == "simplex") {

            if (mysqli_affected_rows($this->id) > 0) {

                return mysqli_fetch_assoc($result);
            }
        }

        if ($type_query == "insert") {
            if ($result) {
                return mysqli_insert_id($this->id);
            }
        }

        if ($type_query == "update") {
            if (mysqli_affected_rows($this->id) > 0) {
                return true;
            }
        }

        if ($type_query == "delete") {

            if (mysqli_affected_rows($this->id) > 0) {
                return true;
            }
        }

        //Se o tipo resource, retorna o $result
        if ($type_query == "resource") {

            if (mysqli_affected_rows($this->id) > 0) {

                if ($log) {
                    $this->queryLog = $this->query;
                    $this->salvaLog();
                }
                return $result;
            }
        }

        return false;
    }

    private function execut_query_pg($type_query = null) {

        $result_insert_id = null;

        $this->connection();

        $result = pg_query($this->query, $this->id);

        if (empty($type_query)) {

            if (pg_affected_rows() > 0) {

                $this->close_connection();

                $result = $this->resultQuery($result);

                return $result;
            }
        }

        if ($type_query == "simplex") {

            if (pg_affected_rows() > 0) {

                $this->close_connection();

                return pg_fetch_assoc($result);
            }
        }

        if ($type_query == "insert") {

            if ($result) {

                $this->close_connection();

                return $result_insert_id;
            }
        }

        if ($type_query == "update") {

            if (pg_affected_rows() > 0) {

                $this->close_connection();

                return true;
            }
        }

        if ($type_query == "delete") {

            if (pg_affected_rows() > 0) {

                $this->close_connection();

                return true;
            }
        }

        return false;
    }

    /**
     * Retorna o nome das colunas de um tabela.
     *
     * @param unknown_type $table_name
     * @return array
     */
    public function select_columns($table_name) {

        $this->connection();

        $sql = "SHOW COLUMNS FROM $table_name ";

        $result = mysql_query($sql, $this->id);

        if ($result) {

            $flag = 0;

            if (mysql_num_rows($result) > 0) {

                while ($row = mysql_fetch_assoc($result)) {

                    if ($row ['Key'] != 'PRI' and $flag == 0) {

                        $flag = 1;
                    }

                    $columns [$flag] = $row ['Field'];

                    $flag ++;
                }
            }
        }

        $this->close_connection();

        return $columns;
    }

    /**
     * Gera a string de pesquisa.
     *
     * @return $result
     */
    public function generation_string_condition($data_form, $name_table) {

        $columns = $this->select_columns($name_table);

        if (!empty($data_form)) {

            foreach ($data_form as $chave => $valor) {

                /**
                 * Verifica se o nome da coluna existe.
                 */
                $key = array_search($chave, $columns);

                if (!empty($key)) {

                    if (!empty($valor) or $valor === 0) {

                        /**
                         * Retorna a informação da coluna selectada.
                         */
                        $infoColuna = $this->infor_column_table($name_table, $chave);

                        /**
                         * Gera a string de condição.
                         */
                        $this->string_condition($name_table, $infoColuna, $chave, $valor);
                    }
                }
            }

            $this->string_data();

            /**
             * Cancela todo o processo de geração da STRING de SELECT.
             */
            if (empty($this->stringCondicao)) {
                return false;
            }

            /**
             * Pega a quantidade de colunas.
             */
            $totalColunas = sizeof($this->stringCondicao);

            /**
             * Retira a "," do final do array.
             */
            $newStringSelect = array_slice($this->stringCondicao, 0, $totalColunas - 1);

            $stringSql = null;

            /**
             * Transforma o array em uma string ex:
             * update tabela set coluna01 = 'valor01' , coluna02 = 'valor02'
             */
            for ($i = 0; $i < sizeof($newStringSelect); $i ++) {

                //Contruir a string das colunas
                $stringSql .= $newStringSelect [$i];
            }
        } else {

            return false;
        }

        #FIM_CONDIÇÃO#

        return $stringSql;
    }

    /**
     * Restorna todas as informaçães de uma tabela no banco de dados.
     *
     */
    public function infor_column_table($name_table, $colunas = '*') {

        $this->connection();

        $result = mysql_query('SELECT ' . $colunas . ' FROM ' . $name_table, $this->id);

        $i = 0;
        while ($i < mysql_num_fields($result)) {

            $meta = mysql_fetch_field($result, $i);

            if (!$meta) {

                return false;
            }

            $i ++;
        }

        $this->close_connection();

        return $meta;
    }

    /**
     * Gera a string de condição baseado no tipo da coluna.
     *
     */
    private function string_condition($name_table, $infoColuna, $chave, $valor) {

        $valor = addslashes($valor);

        if ($infoColuna->type == "string") {

            //Gera as linhas da coluna
            $this->stringCondicao [] = $name_table . "." . $chave . " LIKE '%" . $valor . "%'";
            $this->stringCondicao [] = " AND ";
            return;
        }

        if ($infoColuna->type == "blob") {

            //Gera as linhas da coluna
            $this->stringCondicao [] = $name_table . "." . $chave . " LIKE '%" . $valor . "%'";
            $this->stringCondicao [] = " AND ";
            return;
        }

        if ($infoColuna->type == "year" || $infoColuna->type == "datetime") {

            $this->stringCondicaoDataColuna [] = $name_table . "." . $chave;
            $this->stringCondicaoDataValor [] = $valor;

            return;
        } else {

            $this->stringCondicao [] = $name_table . "." . $chave . " = '" . $valor . "'";
            $this->stringCondicao [] = " AND ";

            return;
        }

        return;
    }

    private function string_data() {

        if (!empty($this->stringCondicaoDataColuna) and ! empty($this->stringCondicaoDataValor)) {

            /**
             * Inseri a configuração da data.
             */
            $this->stringCondicao [] = $this->stringCondicaoDataColuna [0] . " BETWEEN ('" . $this->stringCondicaoDataValor [0] . "') and ('" . $this->stringCondicaoDataValor [1] . "')";
            $this->stringCondicao [] = " AND ";
            $this->stringCondicao [] = $this->stringCondicaoDataColuna [1] . " BETWEEN ('" . $this->stringCondicaoDataValor [0] . "') and ('" . $this->stringCondicaoDataValor [1] . "')";
            $this->stringCondicao [] = " AND ";
        }

        return;
    }

    /**
     * Inseri o resultado em um array.
     *
     * @param mysql_result $result
     * @return array
     */
    private function resultQuery($result) {

        $list = null;
        $i = 0;

        if ($this->sgdb == "mysql" || $this->sgdb == "") {

            while ($dados = mysqli_fetch_assoc($result)) {

                foreach ($dados as $key => $value) {

                    if ($value !== '' and $value != null) {
                        $list [$key] [$i] = $value;
                    }
                }
                $i ++;
            }
        }

        if ($this->sgdb == "postgres") {

            while ($dados = pg_fetch_assoc($result)) {

                foreach ($dados as $key => $value) {

                    if (!empty($value)) {

                        $list [$key] [$i] = $value;
                    }
                }

                $i ++;
            }
        }

        return $list;
    }

    /**
     * Inseri as informações no banco de dados.
     *
     * @param array $request
     * @param string $table_name
     * @param string $chavePrimaria
     * @return unknown
     */
    public function insert($request, $table_name, $chavePrimaria, $caseSensitive = null) {

        $this->caseSensitive = $caseSensitive;

        if ($this->sgdb == "mysql" || $this->sgdb == "") {

            $this->setQuery($this->generatorQueryinsert($request, $table_name, $chavePrimaria));
            return $this->execut_query("insert");
        }

        if ($this->sgdb == "postgres") {

            $this->insert_pg();
        }
    }

    /**
     * Inseri as informações no banco de dados POSTGRES.
     * @param $request = Informações recebidas para atualizar.
     * @param $table_name =  Nome da tabela ha ser afetada.
     * @return boolean [true||false]
     */
    private function insert_pg($request, $table_name) {

        return pg_copy_from($this->id, $table_name, $request);
    }

    /**
     * Atualiza as informações no banco de dados.
     *
     * @param array $request
     * @param string $table_name
     * @param string $chavePrimaria
     * @param boolean $caseSensitive
     * @return unknown
     */
    public function update($request, $table_name, $chavePrimaria = null, $condicao = null, $caseSensitive = false) {

        $this->caseSensitive = $caseSensitive;

        if ($this->sgdb == "mysql" || $this->sgdb == "") {

            $this->setQuery($this->generatorQueryUpdate($request, $table_name, $chavePrimaria));

            return $this->execut_query("update");
        }

        if ($this->sgdb == "postgres") {

            return $this->update_pg($request, $table_name, $condicao);
        }
    }

    /**
     * Reazila a atualização das informações no banco de dados POSTGRES.
     * @param $request = Informações recebidas para atualizar.
     * @param $table_name =  Nome da tabela ha ser afetada.
     * @param $condicao = Condição para realizar a atualização.
     * @return boolean [true||false]
     */
    private function update_pg($request, $table_name, $condicao) {

        return pg_update($this->id, $table_name, $request, $condicao);
    }

    private function generatorQueryinsert($request, $table_name, $chavePrimaria) {

        $i = 0;

        //recebe os dados do fomulário//-----------------------
        foreach ($request as $key => $value) {

            /**
             * Verifica se o valor esta nulo, caso esteja, não é incluído na string de insert.
             */
            if (!empty($key) and ! empty($value)) {

                if ($chavePrimaria != $key) {

                    $string_columns [$i] = $key;
                    $string_value [$i] = "'" . @addslashes($value) . "'";
                }
            }

            $i ++;
        }

        /**
         * Pega todos os elementos do array e inseri em uma string.
         */
        $string_columns = implode(',', $string_columns);

        /**
         * Values string query.
         */
        $string_value = implode(',', $string_value);

        if (empty($this->caseSensitive)) {

            $string_value = strtoupper($string_value);

            $buscar = array("ç", "á", "ó", "é", "ã", "õ", "ẽ", "â", "ô");
            $subs = array("Ç", "Á", "Ó", "É", "Ã", "Õ", "Ẽ", "Â", "Ô");

            $string_value = str_replace($buscar, $subs, $string_value);
        }

        /**
         * String sql full.
         */
        $query = "INSERT INTO " . $table_name . " (" . $string_columns . ") VALUES (" . $string_value . ")";

        $this->queryLog = "INSERT INTO $table_name ( $chavePrimaria, $string_columns) VALUES ([ID],$string_value) ";

        return $query;
    }

    /**
     * Gera String do Update apartir dos compos de texto.
     *
     * @param unknown_type $request
     * @param unknown_type $columns_table
     * @param unknown_type $condition
     * @return unknown
     */
    public function generatorQueryUpdate($request, $table_name, $chavePrimaria) {

        $string_update = array();
        $condition = null;
        $i = 0;

        foreach ($request as $key => $value) {

            //Define o campo que vai ser utilizado como condição para o update
            if ($chavePrimaria == $key and ! empty($key) and ( $value !== '') and ( $value !== null)) {

                $value = addslashes($value);

                if (empty($this->caseSensitive)) {
                    $value = strtoupper($value);
                }

                $condition = $key . " = '" . $value . "'";
            } else {

                if (($value !== '') and ( $value !== null)) {
                    $value = addslashes($value);

                    if (empty($this->caseSensitive)) {
                        $value = strtoupper($value);
                    }
                    $string_update [$i] = $key . " = '" . $value . "'";
                }
            }

            $i ++;
        }

        if (empty($this->caseSensitive)) {

            $buscar = array("ç", "á", "ó", "é", "ã", "õ", "ẽ", "â", "ô");
            $subs = array("Ç", "Á", "Ó", "É", "Ã", "Õ", "Ẽ", "Â", "Ô");

            $string_update = str_replace($buscar, $subs, $string_update);
        }

        /**
         * Pega todos os elementos do array e inseri em uma string.
         */
        $string_update = implode(',', $string_update);

        if (empty($condition)) {
            return null;
        }

        //Concatena toda a string
        $sql = "UPDATE " . $table_name . " SET " . $string_update . " WHERE " . $condition;

        $this->queryLog = "UPDATE " . $table_name . " SET " . $string_update . " WHERE " . $condition;

        return $sql;
    }

    /**
     * Retorna a query de pesquisa.
     * @param $dados = dados do formulario.
     * @param $nomeTabela =  nome da tabela.
     * @return unknown_type
     */
    public function geraSelect($dados, $nomeTabela) {

        if (empty($dados)) {
            return "SELECT * FROM " . $nomeTabela;
        }

        $condicao = $this->generation_string_condition($dados, $nomeTabela);
        return "SELECT * FROM " . $nomeTabela . " WHERE " . $condicao;
    }

    /**
     * Registra um log de todas os dados postados pelo usuário
     * Salva as querys executadas com outras características
     * executadas pela classe de conexão.
     * @param $id = chave primaria resultante do insert.
     * @return unknown_type
     */
    private function salvaLog($id = null) {

        //TODO: Testar se na pesquisa foi informado algum valor
        if (!empty($_POST)) {

            $this->setQueryLog($id);

            mysql_query($this->queryLog, $this->id);
        }
        return;
    }

    private function setQueryLog($id = null) {

        //Faz a substituição se for uma query de INSERT
        if (!empty($id)) {
            $this->queryLog = str_replace("[ID]", $id, $this->queryLog);
        }

        //Informações do log
        $usuario = !empty($this->usuarioSistema) ? $this->usuarioSistema : null;
        $view = !empty($_SESSION['Navegacao']['MenuLateral']) ? $_SESSION['Navegacao']['MenuLateral'] : null;
        $post = print_r($_POST, true);
        $navegador = Server::navegador();
        $ip = Server::ip();
        $tipo = substr($this->queryLog, 0, 6);
        $dataCadastro = date("Y-m-d H:i:s");
        $municipio = defined('MUNICIPIO') ? MUNICIPIO : null;

        $this->queryLog = mysql_real_escape_string($this->queryLog);

        $this->queryLog = "INSERT INTO tb_log ( cl_codigo_view, cl_ip, cl_navegador, cl_tipo, cl_post, cl_query, cl_usuario, cl_data_cadastro, cl_codigo_municipio )
		VALUES ( '$view', '$ip', '$navegador', '$tipo', '$post', '$this->queryLog','$usuario','$dataCadastro', '$municipio') ";
    }

}

?>
