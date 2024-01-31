<?php
class conta {

    private $con;
    private $arrayErro = array();


     public function adicionarEntidade($nome, $thumbnail, $preview, $categoriaId) {
    // Método para adicionar uma nova entidade
    $query = $this->con->prepare("INSERT INTO entities (name, thumbnail, preview, categoryId) VALUES (:nome, :thumbnail, :preview, :categoriaId)");
    $query->bindValue(":nome", $nome);
    $query->bindValue(":thumbnail", $thumbnail);
    $query->bindValue(":preview", $preview);
    $query->bindValue(":categoriaId", $categoriaId);
    return $query->execute();
    }

      public function editarEntidade($id, $novoNome, $novaThumbnail, $novaPreview, $novaCategoriaId) {
    // Método para editar as informações de uma entidade
    $query = $this->con->prepare("UPDATE entities SET name=:nome, thumbnail=:thumbnail, preview=:preview, categoryId=:categoriaId WHERE id=:id");
    $query->bindValue(":nome", $novoNome);
    $query->bindValue(":thumbnail", $novaThumbnail);
    $query->bindValue(":preview", $novaPreview);
    $query->bindValue(":categoriaId", $novaCategoriaId);
    $query->bindValue(":id", $id);
    return $query->execute();
    }

    public function listarEntidades() {
    $query = $this->con->query("SELECT * FROM entities");
    return $query->fetchAll(PDO::FETCH_ASSOC);
    }

  public function excluirEntidade($id) {
    // Método para excluir uma entidade
    $query = $this->con->prepare("DELETE FROM entities WHERE id=:id");
    $query->bindValue(":id", $id);
    return $query->execute();
    }



    // Construtor que recebe uma conexão como parâmetro
    public function __construct($con){
        $this->con = $con;
    }

    // Método para atualizar detalhes do usuário no banco de dados
    public function atualizarDetalhes($n, $sn, $em, $nu){
        $this->validarNome($n);
        $this->validarSobrenome($sn);
        $this->validarNovoEmail($em, $nu);

        if(empty($this->arrayErro)){
            // Prepara a query de atualização e executa
            $query = $this->con->prepare("UPDATE usuarios SET nome=:n, sobrenome=:sn, email=:em 
                                            WHERE nomeUsuario=:nu");

            $query->bindValue(":n", $n);
            $query->bindValue(":sn", $sn);
            $query->bindValue(":em", $em);
            $query->bindValue(":nu", $nu);
        
            return $query->execute();
        }

        return false;
    }

    // Método para registrar um novo usuário no banco de dados
    public function registro($n, $sn, $nu, $em, $em2, $se, $se2){
        $this->validarNome($n);
        $this->validarSobrenome($sn);
        $this->validarNomeUsuario($nu);
        $this->validarEmail($em, $em2);
        $this->validarSenhas($se, $se2);

        if(empty($this->arrayErro)){
            // Chama o método inserirDetalhes se não houver erros
            return $this->inserirDetalhes($n, $sn, $nu, $em, $se);
        }
        
        return false;
    }

    // Método para realizar o login do usuário
    public function login($nu, $se){
        $se = hash("sha512", $se);
    
        // Prepara a query de seleção para login e executa
        $query = $this->con->prepare("SELECT * FROM usuarios WHERE nomeUsuario=:nu AND senha=:se");
    
        $query->bindValue(":nu", $nu);
        $query->bindValue(":se", $se);
    
        $query->execute();
    
        // Obtém os dados do usuário
        $usuario = $query->fetch(PDO::FETCH_ASSOC);
    
        // Verifica se a query retornou um resultado
        if($query->rowCount() == 1){
            return array("sucesso" => true, "isAdmin" => $usuario['admin']);
        }
    
        // Adiciona mensagem de erro se o login falhar
        array_push($this->arrayErro, Constantes::$loginFalhou);
    
        return array("sucesso" => false);
    }

    // Método para verificar se o usuário é um administrador
    public function isAdmin($nu){

        // Prepara a query para verificar se o usuário é um administrador
        $query = $this->con->prepare("SELECT admin FROM usuarios WHERE nomeUsuario=:nu");
        $query->bindValue(":nu", $nu);
        $query->execute();

        // Obtém os dados do usuário
        $usuario = $query->fetch(PDO::FETCH_ASSOC);

        // Retorna true se o usuário for um administrador, caso contrário, retorna false
        return $usuario['admin'] == 1;
    }

    // Métodos privados para realizar a inserção no banco de dados e validar dados

    private function inserirDetalhes($n, $sn, $nu, $em, $se){
        $se = hash("sha512", $se);

        // Prepara a query de inserção e executa
        $query = $this->con->prepare("INSERT INTO usuarios (nome, sobrenome, nomeUsuario, email, senha) VALUES (:n, :sn, :nu, :em, :se)");
        $query->bindValue(":n", $n);
        $query->bindValue(":sn", $sn);
        $query->bindValue(":nu", $nu);
        $query->bindValue(":em", $em);
        $query->bindValue(":se", $se);


        return $query->execute();
    }

    // Métodos privados para validação de dados

    private function validarNome($n){
        if(strlen($n) < 2 || strlen($n) > 25){
            array_push($this->arrayErro, constantes::$caracteresNome);
        }
    }

    private function validarSobrenome($sn){
        if(strlen($sn) < 2 || strlen($sn) > 30){
            array_push($this->arrayErro, constantes::$caracteresSobrenome);
        }
    }

    private function validarNomeUsuario($nu){
        if(strlen($nu) < 2 || strlen($nu) > 30){
            array_push($this->arrayErro, constantes::$caracteresNomeUsuario);
            return;
        }

        // Verifica se o nome de usuário já existe no banco de dados
        $query = $this->con->prepare("SELECT * FROM usuarios WHERE nomeUsuario=:nu");
        $query->bindValue(":nu", $nu);

        $query->execute();

        // Adiciona mensagem de erro se o nome de usuário já estiver em uso
        if($query->rowCount() !=0){
            array_push($this->arrayErro, constantes::$nomeUsuarioUsado);
        }
    }

    private function validarEmail($em, $em2){
        // Verifica se os emails coincidem
        if($em != $em2){
            array_push($this->arrayErro, constantes::$emailNaoConfere);
            return;
        }

        // Verifica se o formato do email é válido
        if(!filter_var($em, FILTER_VALIDATE_EMAIL)){
            array_push($this->arrayErro, constantes::$emailInvalido);
            return;
        }

        // Verifica se o email já está em uso no banco de dados
        $query = $this->con->prepare("SELECT * FROM usuarios WHERE email=:em");
        $query->bindValue(":em", $em);

        $query->execute();

        // Adiciona mensagem de erro se o email já estiver em uso
        if($query->rowCount() !=0){
            array_push($this->arrayErro, constantes::$emailUsado);
        }
    }

    public function listarUsuarios(){
        $query = $this->con->query("SELECT * FROM usuarios");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    private function validarNovoEmail($em, $nu){
        // Verifica se o formato do novo email é válido
        if(!filter_var($em, FILTER_VALIDATE_EMAIL)){
            array_push($this->arrayErro, constantes::$emailInvalido);
            return;
        }

        // Verifica se o novo email já está em uso por outro usuário
        $query = $this->con->prepare("SELECT * FROM usuarios WHERE email=:em AND nomeUsuario != :nu");
        $query->bindValue(":em", $em);
        $query->bindValue(":nu", $nu);

        $query->execute();

        // Adiciona mensagem de erro se o novo email já estiver em uso
        if($query->rowCount() !=0){
            array_push($this->arrayErro, constantes::$emailUsado);
        }
    }

    private function validarSenhas($se, $se2){
        // Verifica se as senhas coincidem
        if($se != $se2){
            array_push($this->arrayErro, constantes::$senhaNaoConfere);
            return;
        }
        // Verifica se a senha tem o tamanho adequado
        if(strlen($se) < 5 || strlen($se) > 25){
            array_push($this->arrayErro, constantes::$caracteresSenha);
        }
    }

    // Métodos para obter mensagens de erro

    public function getErro($erro){
        if(in_array($erro, $this->arrayErro)){
            return "<span class='mensagemErro'>$erro</span>";
        }
    }

    public function getPrimeiroErro(){
        if(!empty($this->arrayErro)){
            return $this->arrayErro[0];
        }
    }

    // Método para atualizar a senha do usuário

    public function atualizarSenha($seA, $se, $se2, $nu){
        $this->validarSenhaAntiga($seA, $nu);
        $this->validarSenhas($se, $se2);

        if(empty($this->arrayErro)){
            // Prepara a query de atualização de senha e executa
            $query = $this->con->prepare("UPDATE usuarios SET senha=:se	WHERE nomeUsuario=:nu");
            $se = hash("sha512", $se);
            $query->bindValue(":se", $se);
            $query->bindValue(":nu", $nu);
        
            return $query->execute();
        }

        return false;
    }

    // Método para validar a senha antiga do usuário

    public function validarSenhaAntiga($seA, $nu){
        $se = hash("sha512", $seA);

        // Verifica se a senha antiga está correta
        $query = $this->con->prepare("SELECT * FROM usuarios WHERE nomeUsuario=:nu AND senha=:se");
        $query->bindValue(":nu", $nu);
        $query->bindValue(":se", $se);

        $query->execute();

        // Adiciona mensagem de erro se a senha antiga estiver incorreta
        if($query->rowCount() == 0){
            array_push($this->arrayErro, constantes::$senhaIncorreta);
        }
    }

    // Método para excluir a conta do usuário

    public function excluirConta($nu){
        // Prepara a query de exclusão de conta e executa
        $query = $this->con->prepare("DELETE FROM usuarios WHERE nomeUsuario=:nu");

        $query->bindValue(":nu", $nu);		
        $query->execute();
    }
    public function editarUsuario($id, $novoNome, $novoSobrenome, $novoEmail) {
        // Método para editar as informações de um usuário
        $query = $this->con->prepare("UPDATE usuarios SET nome=:n, sobrenome=:sn, email=:em WHERE id=:id");
        $query->bindValue(":n", $novoNome);
        $query->bindValue(":sn", $novoSobrenome);
        $query->bindValue(":em", $novoEmail);
        $query->bindValue(":id", $id);
        return $query->execute();
    }

    public function excluirUsuario($id) {
        // Método para excluir um usuário
        $query = $this->con->prepare("DELETE FROM usuarios WHERE id=:id");
        $query->bindValue(":id", $id);
        return $query->execute();
    }
// Dentro da classe Conta, logo após o método editarUsuario

    public function editarCategoria($id, $novoNomeCategoria) {
    // Método para editar as informações de uma categoria
    $query = $this->con->prepare("UPDATE categories SET name=:name WHERE id=:id");
    $query->bindValue(":name", $novoNomeCategoria);
    $query->bindValue(":id", $id);
    return $query->execute();
    }

   public function listarCategorias() {
    $query = $this->con->query("SELECT * FROM categories");
    return $query->fetchAll(PDO::FETCH_ASSOC);
   }



   }


?>


