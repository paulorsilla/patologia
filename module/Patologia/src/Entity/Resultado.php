<?php

namespace Patologia\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Classe Resultado
 * @author silla
 * @ORM\Entity
 * @ORM\Table(name="resultado")
 */

class Resultado
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(name="id")
	 */
	private $id;

	/**
	 * @ORM\Column(name="resultado", type="integer") 
	 */
	private $resultado;
	
	/**
	 * @ORM\Column(name="dataLeitura", type="datetime")
	 */
	private $dataLeitura;
	
	/**
	 * @ORM\ManyToOne(targetEntity="\User\Entity\User")
	 * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
	 */
	private $analista;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Repeticao")
	 * @ORM\JoinColumn(name="repeticao_id", referencedColumnName="id")
	 */
	private $repeticao;
	
	/**
	 * @ORM\OneToOne(targetEntity="Variavel")
	 * @ORM\JoinColumn(name="variavel_id", referencedColumnName="id") 
	 */
	private $variavel;

	
	public function getId() {
		return $this->id;
	}
	
	public function setId($id) {
		$this->id = $id;
	}
	
	public function getDataLeitura() {
		return $this->dataLeitura;
	}
	
	public function setDataLeitura($dataLeitura) {
		$this->dataLeitura = $dataLeitura;
	}
	
	public function getAnalista() {
		return $this->analista;
	}
	
	public function setAnalista($analista) {
		$this->analista = $analista;
	}
	
	public function getRepeticao() {
		return $this->repeticao;
	}
	
	public function setRepeticao($repeticao) {
		$this->repeticao = $repeticao;
	}
	
	public function getVariavel() {
		return $this->variavel;
	}
	
	public function setVariavel($variavel) {
		$this->variavel = $variavel;
	}
	
	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
	
	public function getResultado() {
		return $this->resultado;
	}
	
	public function setResultado($resultado) {
		$this->resultado = $resultado;
	}
	
}