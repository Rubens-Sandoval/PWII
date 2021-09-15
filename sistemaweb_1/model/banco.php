<?php
//timezone
date_default_timezone_set('America/Sao_Paulo');

// conexão com o banco de dados
define('BD_SERVIDOR','localhost');
define('BD_USUARIO','root');
define('BD_SENHA','');
define('BD_BANCO','sistema_cadastros');
    
class Banco{

    protected $mysqli;
    private $cadastro;

    public function __construct(){
        $this->conexao();
    }

    private function conexao(){
        $this->mysqli = new mysqli(BD_SERVIDOR, BD_USUARIO , BD_SENHA, BD_BANCO);
    }

    public function setAgendamentos($nome,$telefone,$origem,$data_contato,$observacao){
        $stmt = $this->mysqli->prepare("INSERT INTO cadastros (`Nome`, `Telefone`, `Origem`, `Data_ctt`, `Obs`) VALUES (?,?,?,?,?);");
        $stmt->bind_param("sssss",$nome,$telefone,$origem,$data_contato,$observacao);
        if( $stmt->execute() == TRUE){
            return true;
        }else{
            return false;
        }
    }

    public function getAgendamentos($id) {
        try {
            if(isset($id) && $id > 0){
                $stmt = $this->mysqli->query("SELECT * FROM cadastros WHERE id = '" . $id . "';");
            }else{
                $stmt = $this->mysqli->query("SELECT * FROM cadastros;");
            }
            
            $lista = $stmt->fetch_all(MYSQLI_ASSOC);
            $f_lista = array();
            $i = 0;
            foreach ($lista as $l) {
                $f_lista[$i]['id'] = $l['id'];
                $f_lista[$i]['nome'] = $l['Nome'];
                $f_lista[$i]['telefone'] = $l['Telefone'];
                $f_lista[$i]['origem'] = $l['Origem'];
                $f_lista[$i]['data_contato'] = $l['Data_ctt'];
                $f_lista[$i]['observacao'] = $l['Obs'];
                $i++;
            }
            return $f_lista;
        } catch (Exception $e) {
            echo "Ocorreu um erro ao tentar Buscar Todos." . $e;
        }
    }

}    
?>