<?php 
class criarPrevia{
	private $con, $nomeUsuario;

	public function __construct($con, $nomeUsuario){
		$this->con = $con;
		$this->nomeUsuario = $nomeUsuario;
	}

	public function criadorCategoriaPreview($idCategoria){
		$arrayEntidades = gerarEnt::getEntidades($this->con, $idCategoria, 1);

		if(sizeof($arrayEntidades) == 0){
			mensagemErro::show("Sem filmes para mostrar");
		}
		return $this->criadorPreview($arrayEntidades[0]);
	}

	public function criadorPreviewSobre(){
		$arrayEntidades = gerarEnt::getEntidadesSobre($this->con, null, 1);

		if(sizeof($arrayEntidades) == 0){
			mensagemErro::show("Sem filmes para mostrar");
		}
		return $this->criadorPreview($arrayEntidades[0]);
	}

	public function criadorPreview($entidade){
		if($entidade == null){
			$entidade = $this->getEntRandom();
		}

		$id = $entidade->getId();
		$nome = $entidade->getNome();
		$thumbnail = $entidade->getThumb();
		$preview = $entidade->getPreview();

		$idVideo = gerarVideo::getEntidadePorUsuario($this->con, $id, $this->nomeUsuario);
		$video = new video($this->con, $idVideo);

		$emProgresso = $video->emProgresso($this->nomeUsuario);
		$botaoPlay = $emProgresso ? " Continue a assistir" : " Play";
		$episodioTemporada = $video->getTempEpi();
		$subCabecalho = $video->verificaFilme() ? "" : "<h4>$episodioTemporada</h4>";


		return "<div class='previewContainer'>
					<img src='$thumbnail' class='imagemPreview' hidden>

					<video autoplay muted class='videoPreview' onended='finalPreview()'>
						<source src='$preview' type='video/mp4'>
					</video>

					<div class='interfacePreview'>
						<div class='detalhesPrincipais'>
							<h2>$nome</h2>
							$subCabecalho
								<div class='botoes'>
									<button onclick='playVideo($idVideo)'><i class='fas fa-play-circle'></i>$botaoPlay</button>
									<button onclick='desMutar(this)'><i class='fas fa-volume-mute'></i></button>
								</div>
						</div>
					</div>	
				</div>"; 

				
	}

	public function criadorTelaPreview($entidade){
		$id = $entidade->getId();
		$thumbnail = $entidade->getThumb();
		$nome = $entidade->getNome();

		return "<a href='Entidade.php?id=$id'>
					<div class='previewContainer small'>
						<img src='$thumbnail' title='$nome'>
					</div>
				</a>";
	}

	private function getEntRandom(){
		
		$entidade = gerarEnt::getEntidades($this->con, null, 1);
		return $entidade[0];
	}
}
?>