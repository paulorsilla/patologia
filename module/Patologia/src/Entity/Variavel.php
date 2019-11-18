<?php

namespace Patologia\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe Variável
 * @author silla
 * @ORM\Entity
 * @ORM\Table(name="variavel")
 *
 */

class Variavel
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(name="id")
	 */
	private $id;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Determinacao")
	 * @ORM\JoinColumn(name="determinacao_id", referencedColumnName="id")
	 */
	private $determinacao;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Analise", inversedBy="variaveis")
	 * @ORM\JoinColumn(name="analise_id", referencedColumnName="id")
	 */
	private $analise;
	
	public function getId() {
		return $this->id;
	}
	
	public function setId($id) {
		$this->id = $id;
	}
	
	/**
	 *
	 * @return Determinacao
	 */
	public function getDeterminacao() {
		return $this->determinacao;
	}
	
	/**
	 *
	 * @param Determinacao $determinacao        	
	 */
	public function setDeterminacao($determinacao) {
		$this->determinacao = $determinacao;
	}
	
	/**
	 *
	 * @return Analise
	 */
	public function getAnalise() {
		return $this->analise;
	}
	
	/**
	 *
	 * @param Analise $analise        	
	 */
	public function setAnalise($analise) {
		$this->analise = $analise;
	}
	
	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
}