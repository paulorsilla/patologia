<?php

namespace Patologia\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * Classe Repeticao
 * @author silla
 * @ORM\Entity
 * @ORM\Table(name="repeticao")
 *
 */

class Repeticao
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(name="id")
	 */
	private $id;

	/**
	* @ORM\Column(name="sequencia", type="integer")
	*/
	private $sequencia;

	/**
	 * @ORM\ManyToOne(targetEntity="Amostra")
	 * @ORM\JoinColumn(name="amostra_id", referencedColumnName="id")
	 */
	private $amostra;
	
	public function getId() {
		return $this->id;
	}

	public function setId($id) {
		$this->id = $id;
	}
	
	public function getSequencia() {
		return $this->sequencia;
	}
	
	public function setSequencia($sequencia) {
		$this->sequencia = $sequencia;
	}
	
	public function getAmostra() {
		return $this->amostra;
	}
	
	public function setAmostra($amostra) {
		$this->amostra = $amostra;
	}
	
	public function getArrayCopy()
	{
		return get_object_vars($this);
	}

}