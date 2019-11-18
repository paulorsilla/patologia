<?php


namespace Patologia\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Classe Amostra
 * @author silla
 * @ORM\Entity(repositoryClass="Patologia\Repository\Amostra")
 * @ORM\Table(name="amostra")
 *
 */

class Amostra extends AbstractEntity 
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(name="id")
	 */
	private $id;
	
	/**
	 * @ORM\Column(type="string", name="numero_laboratorio")
	 */
	private $numeroLaboratorio;
	
	/**
	 * @ORM\Column(type="string", name="local_colheita")
	 */
	private $localColheita;

	/**
	 * @ORM\Column(type="datetime", name="data_colheita")
	 */
	private $dataColheita;
	
	/**
	 * @ORM\Column(type="datetime", name="data_recebimento")
	 */
	private $dataRecebimento;
	
	/**
	 * @ORM\Column(type="string", name="remetente")
	 */
	private $remetente;
	
	/**
	 * @ORM\Column(type="string", name="numero_repeticoes")
	 */
	private $numeroRepeticoes;
	
	/**
	 * @ORM\ManyToOne(targetEntity="Especie")
	 * @ORM\JoinColumn(name="especie_id", referencedColumnName="id")
	 */
	private $especie;
	
	/** 
	 * @ORM\OneToOne(targetEntity="Analise", inversedBy="amostra")
	 * @ORM\JoinColumn(name="analise_id", referencedColumnName="id")
	 */
	private $analise;
	
	/**
	 * @ORM\Column(type="integer", name="status")
	 */
	private $status;
	
	/**
	 * @ORM\OneToMany(targetEntity="Repeticao", mappedBy="amostra")
	 */
	private $repeticoes;
	
	public function __construct()
	{
		$this->repeticoes = new ArrayCollection();
	}
	public function getId() {
		return $this->id;
	}
	
	public function setId($id) {
		$this->id = $id;
	}
	
	public function getNumeroLaboratorio() {
		return $this->numeroLaboratorio;
	}
	
	public function setNumeroLaboratorio($numeroLaboratorio) {
		$this->numeroLaboratorio = $numeroLaboratorio;
	}
	
	public function getLocalColheita() {
		return $this->localColheita;
	}
	
	
	public function setLocalColheita($localColheita) {
		$this->localColheita = $localColheita;
	}
	
	public function getDataColheita() {
		return $this->dataColheita;
	}
	
	public function setDataColheita($dataColheita) {
		$this->dataColheita = $dataColheita;
	}
	
	public function getDataRecebimento() {
		return $this->dataRecebimento;
	}
	
	public function setDataRecebimento($dataRecebimento) {
		$this->dataRecebimento = $dataRecebimento;
	}
	
	public function getRemetente() {
		return $this->remetente;
	}
	
	public function setRemetente($remetente) {
		$this->remetente = $remetente;
	}
	
	public function getEspecie() {
		return $this->especie;
	}
	
	public function setEspecie($especie) {
		$this->especie = $especie;
	}
	
	public function getNumeroRepeticoes() {
		return $this->numeroRepeticoes;
	}
	
	public function setNumeroRepeticoes($numeroRepeticoes) {
		$this->numeroRepeticoes = $numeroRepeticoes;
	}
	
	public function getAnalise() {
		return $this->analise;
	}
	
	public function setAnalise($analise) {
		$this->analise = $analise;
	}
	
	public function getStatus() {
		return $this->status;
	}
	
	public function setStatus($status) {
		$this->status = $status;
	}
	
	public function getRepeticoes() {
		return $this->repeticoes;
	}
	
	public function setRepeticoes($repeticoes) {
		$this->repeticoes = $repeticoes;
	}
	
	public function getRepeticao($numero) {
		return $this->repeticoes[$numero-1];		
	}
	
	public function getArrayCopy()
	{
		return get_object_vars($this);
	}

}