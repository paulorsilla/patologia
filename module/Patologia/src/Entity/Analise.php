<?php

namespace Patologia\Entity;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;
		
 /**
  * Classe Analise
  * @author silla
 * @ORM\Entity(repositoryClass="Patologia\Repository\Analise")
  * @ORM\Table(name="analise")
  *
  */

 class Analise extends AbstractEntity
 {
 	/**
 	 * @ORM\Id
 	 * @ORM\GeneratedValue
 	 * @ORM\Column(name="id")
 	 */
 	protected $id;

 	/**
 	 * @ORM\Column(type="datetime", name="data_inicio")
 	 */
 	protected $dataInicio;

 	/**
 	 * @ORM\Column(type="datetime", name="data_termino")
 	 */
 	protected $dataTermino;
	
 	/**
 	 * @ORM\Column(type="integer", name="numero_sementes")
 	 */
 	protected $numeroSementes;
	
 	/**
 	 * @ORM\Column(type="string", name="observacoes")
 	 */
 	protected $observacoes;

 	/**
 	 * @ORM\ManyToOne(targetEntity="Metodo")
 	 * @ORM\JoinColumn(name="metodo_id", referencedColumnName="id")
 	 */
 	protected $metodo;
 	
 	/**
 	 * @ORM\ManyToOne(targetEntity="\User\Entity\User")
 	 * @ORM\JoinColumn(name="usuario_id", referencedColumnName="id")
 	 */
 	protected $analista;
	
 	/**
 	 * @ORM\OneToOne(targetEntity="Amostra", mappedBy="analise")
 	 * 
 	 */
 	protected $amostra;
 	
 	/**
 	 * @ORM\OneToMany(targetEntity="Variavel", mappedBy="analise")
	 */
 	protected $variaveis;
 	
 	/**
 	 * @ORM\ManyToMany(targetEntity="Saprofita")
 	 * @ORM\JoinTable(name="analise_saprofita",
 	 * 		joinColumns={@ORM\JoinColumn(name="analise_id", referencedColumnName="id")},
 	 * 		inverseJoinColumns={@ORM\JoinColumn(name="saprofita_id", referencedColumnName="id")}
 	 * )
 	 */
 	protected $saprofitas;
 	
	public function __construct() 
	{
		$this->variaveis = new ArrayCollection();
		$this->saprofitas = new ArrayCollection();
	}
	
	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id = $id;
	}
	
	public function getDataInicio() {
		return $this->dataInicio;
	}
	
	public function setDataInicio($dataInicio) {
		$this->dataInicio = $dataInicio;
	}
	
	public function getDataTermino() {
		return $this->dataTermino;
	}
	
	public function setDataTermino($dataTermino) {
		$this->dataTermino = $dataTermino;
	}
	
	public function getNumeroSementes() {
		return $this->numeroSementes;
	}
	
	public function setNumeroSementes($numeroSementes) {
		$this->numeroSementes = $numeroSementes;
	}
	
	public function getObservacoes() {
		return $this->observacoes;
	}
	
	public function setObservacoes($observacoes) {
		$this->observacoes = $observacoes;
	}
	
	public function getMetodo() {
		return $this->metodo;
	}
	
	public function setMetodo($metodo) {
		$this->metodo = $metodo;
	}
	
	public function getAnalista() {
		return $this->analista;
	}
	
	public function setAnalista($analista) {
		$this->analista = $analista;
	}
	
	public function getAmostra() {
		return $this->amostras;
	}
	
	public function setAmostra($amostra) {
		$this->amostra = $amostra;
	}
	
	public function getVariaveis() {
		return $this->variaveis;
	}

	public function setVariaveis($variaveis) {
		$this->variaveis = $variaveis;
	}
	
	public function getSaprofitas() {
		return $this->saprofitas;
	}
	
	public function setSaprofitas($saprofitas) {
		$this->saprofitas = $saprofitas;
	}
	
	public function getArrayCopy() 	{
		return get_object_vars($this);
	}
	
	
 }