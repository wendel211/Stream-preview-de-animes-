<?php 
class categorias{

	public function mostrarPaginaSobre(){
		$html = "<div class='paginaSobre'>
	
				<h1>Sobre o IFBAFLIX</h1>
				<p>Bem-vindo ao IFBAFLIX, a sua plataforma de streaming de anime favorita! Aqui, estamos comprometidos em proporcionar uma experiência excepcional para os apaixonados por anime. Desde os clássicos atemporais até os mais recentes lançamentos, o IFBAFLIX é o seu destino definitivo para explorar e desfrutar do vasto universo dos animes.</p>
	  
				<h2>Nossa Missão</h2>
				<p>A nossa missão é alimentar a paixão dos fãs de anime, oferecendo uma plataforma inovadora que torna a descoberta e a visualização de animes mais acessíveis do que nunca. Queremos criar uma comunidade vibrante e engajada, onde os entusiastas possam compartilhar suas experiências, recomendações e descobertas.</p>
	  
				<h2>Variedade de Conteúdo</h2>
				<p>No IFBAFLIX, acreditamos na diversidade de escolhas. Nossa extensa biblioteca abrange uma ampla gama de gêneros, desde ação e aventura até romance e fantasia. Seja você um fã de longa data ou um recém-chegado ao mundo dos animes, temos algo especial para todos.</p>
	  
				<h2>Categorias Recomendadas</h2>";
	  
		             $html .= "<h2>Assistir a qualquer hora, em qualquer lugar</h2>
				<p>Estamos comprometidos em fornecer conveniência aos nossos usuários. O AnimeStreamer está disponível em várias plataformas, permitindo que você assista aos seus animes favoritos a qualquer hora, em qualquer lugar. Seja no conforto de sua casa ou em movimento, a magia dos animes está sempre ao seu alcance.</p>
	  
				<h2>Feedback e Suporte</h2>
				<p>A opinião da nossa comunidade é fundamental. Estamos sempre abertos a feedback e sugestões para melhorar a sua experiência no IFBAFLIX. Além disso, nossa equipe de suporte está pronta para ajudar com qualquer dúvida ou problema que você possa encontrar. Entre em contato conosco:</p>
				<ul>
				    <li>Email: suporte@ifbaflix.com</li>
				    <li>Telefone: (123) 456-7890</li>
				</ul>
	  
				<h2>Junte-se à Comunidade IFBAFLIX</h2>
				<p>Se você compartilha da mesma paixão por animes, convidamos você a se juntar à nossa comunidade. Siga-nos nas redes sociais, participe de discussões e faça parte de uma comunidade que celebra a diversidade e a magia dos animes.</p>
	  
				<h2>Endereço</h2>
				<p>Rua Cristovão Barreto, 123 - Cidade Otaku, OC, 998000-02</p>
	  
				<p>Descubra, assista e compartilhe a emoção dos animes no IFBAFLIX - onde a jornada nunca termina!</p>
			  </div>";
	
	  
		return $html;
	  }
	  

	private $con, $nomeUsuario;

	public function __construct($con, $nomeUsuario){
		$this->con = $con;
		$this->nomeUsuario = $nomeUsuario;
	}

	public function mostrarCategorias(){
		$query = $this->con->prepare("SELECT * FROM categories");
		$query->execute();

		$html = "<div class='previewCategorias'>";

		while($row = $query->fetch(PDO::FETCH_ASSOC)){
			$html .= $this->getCategoriasHTML($row, null, true, true);
		}

		return $html . "</div>";
	}

	private function getCategoriasHTML($dataSQL, $titulo, $sobre){
		$idCategoria = $dataSQL == null ? null : $dataSQL["id"];
		$titulo = $titulo == null ? $dataSQL["name"] : $titulo;

		if($sobre){
			$entidades = gerarEnt::getEntidades($this->con, $idCategoria, 30);
		}

		else {
			$entidades = gerarEnt::getEntidadesSobre($this->con, $idCategoria, 30);			
		}

		if(sizeof($entidades)==0){
			return;
		}

		$entidadesHTML = "";
		$provedorPreview = new criarPrevia($this->con, $this->nomeUsuario);
		foreach ($entidades as $entidade) {
			$entidadesHTML .= $provedorPreview->criadorTelaPreview($entidade);
			
		}

		return "<div class='categorias'>
					<a href='categoria.php?id=$idCategoria'>
						<h3>$titulo</h3>
					</a>
					<div class='entidades'>
						$entidadesHTML
					</div>
				</div>";
	}
}
?>