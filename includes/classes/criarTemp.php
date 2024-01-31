<?php
class criarTemp {

    // Propriedades da classe
    private $con, $nomeUsuario;

    // Construtor que recebe a conexão e o nome de usuário como parâmetros
    public function __construct($con, $nomeUsuario){
        $this->con = $con;
        $this->nomeUsuario = $nomeUsuario;
    }

    public function criar($entidade){
        // Obtém as temporadas da entidade
        $temporadas = $entidade->getTemporadas();

        // Verifica se há temporadas
        if(sizeof($temporadas) == 0){
            return;
        }

        // Inicializa a string de HTML para as temporadas
        $temporadasHTML = "";

        // Loop pelas temporadas
        foreach ($temporadas as $temporada) {
            // Obtém o número da temporada
            $numeroTemporada = $temporada->getNumeroTemporada();

            // Inicializa a string de HTML para os vídeos
            $videosHTML = "";

            // Loop pelos vídeos da temporada
            foreach ($temporada->getVideos() as $video) {
                // Adiciona o HTML do vídeo à string
                $videosHTML .= $this->criarVideo($video);
            }

            // Adiciona o HTML da temporada à string
            $temporadasHTML .= "<div class='temporada'> 
                                    <h3> Temporada $numeroTemporada </h3>
                                    <div class='videos'>
                                        $videosHTML
                                    </div>
                                </div>";
        }

        // Retorna o HTML final das temporadas e vídeos
        return $temporadasHTML;
    }

    // Método privado para criar o HTML de um vídeo
    private function criarVideo($video){
        // Obtém informações do vídeo
        $id = $video->getId();
        $thumbnail = $video->getThumb();
        $titulo = $video->getTitulo();
        $descricao = $video->getDescricao();
        $numeroEpisodio = $video->getNumeroEpisodio();
        $jaAssistido = $video->jaAssistido($this->nomeUsuario) ? "<i class='fas fa-check-circle seen'></i>" : "";

        // Retorna o HTML do vídeo
        return "<a href='assistir.php?id=$id'> 
                    <div class='episodio'>
                        <div class='conteudo'>

                            <img src='$thumbnail'>

                            <div class='informacaoVideo'>
                                <h4>$numeroEpisodio. $titulo</h4>
                                <span>$descricao</span>
                            </div>
                            
                            $jaAssistido

                        </div>
                    </div>
                </a>";
    }
}
?>
