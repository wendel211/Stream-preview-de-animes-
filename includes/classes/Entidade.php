<?php
class Entidade {

  
    private $con, $dataSQL;


    public function __construct($con, $input) {
        $this->con = $con;

    
        if(is_array($input)){
            $this->dataSQL = $input;
        }
        // Caso contrário, busca os dados no banco de dados
        else {
            $query = $this->con->prepare("SELECT * FROM entities WHERE id=:id");
            $query->bindValue(":id", $input);
            $query->execute();

            // Armazena os dados obtidos no formato de array associativo
            $this->dataSQL = $query->fetch(PDO::FETCH_ASSOC);
        }
    }

    // Método para obter o ID da entidade
    public function getId(){
        return $this->dataSQL["id"];
    }

    // Método para obter o nome da entidade
    public function getNome(){
        return $this->dataSQL["name"];
    }

    // Método para obter a thumbnail da entidade
    public function getThumb(){
        return $this->dataSQL["thumbnail"];
    }

    // Método para obter o ID da categoria da entidade
    public function getIdCategoria(){
        return $this->dataSQL["categoryId"];
    }

    // Método para obter a prévia da entidade
    public function getPreview(){
        return $this->dataSQL["preview"];
    }

    // Método para obter as temporadas associadas à entidade
    public function getTemporadas(){
        // Query para selecionar vídeos relacionados à entidade, ordenados por temporada e episódio
        $query = $this->con->prepare("SELECT * FROM videos WHERE entityId=:id AND isMovie = 0 ORDER BY season, episode ASC");
        $query->bindValue(":id", $this->getId());
        $query->execute();

        // Inicializa arrays para armazenar temporadas e vídeos
        $temporadas = array();
        $videos = array();
        $temporadaAtual = null;

        // Loop através dos resultados da query
        while($row = $query->fetch(PDO::FETCH_ASSOC)){

            // Verifica se há uma nova temporada
            if($temporadaAtual != null && $temporadaAtual != $row["season"]){
                // Cria uma nova temporada com os vídeos da temporada anterior
                $temporadas[] = new temporada($temporadaAtual, $videos);
                $videos = array(); // Reinicializa o array de vídeos
            }

            // Atualiza a temporada atual
            $temporadaAtual = $row["season"];
            
            // Adiciona um novo vídeo ao array de vídeos
            $videos[] = new video($this->con, $row);
        }

        // Se ainda houver vídeos não processados, cria uma temporada para eles
        if(sizeof($videos) != 0){
            $temporadas[] = new temporada($temporadaAtual, $videos);
        }

        // Retorna o array de temporadas
        return $temporadas;
    }
}
?>
