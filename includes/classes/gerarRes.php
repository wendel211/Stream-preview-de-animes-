<?php
class gerarRes{

	private $con, $nomeUsuario;

	public function __construct($con, $nomeUsuario){
		$this->con = $con;
		$this->nomeUsuario = $nomeUsuario;
	}

	public function getResultados($inputText){
		$entidades = gerarEnt::getEntidadesBusca($this->con, $inputText);
		$html = "<div class='previewCategorias noScroll'>";
		$html .= $this->getResultadosHTML($entidades);

		return $html . "</div>";
	}

	private function getResultadosHTML($entidades){
		if(sizeof($entidades)==0){
			return;
		}

		$entidadesHTML = "";
		$provedorPreview = new criarPrevia($this->con, $this->nomeUsuario);
		foreach ($entidades as $entidade) {
			$entidadesHTML .= $provedorPreview->criadorTelaPreview($entidade);
			
		}

		return "<div class='categorias'>
					<div class='entidades'>
						$entidadesHTML
					</div>
				</div>";
	}
}
?>