<?php

namespace Patologia\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe Determinação
 * @author silla
 * @ORM\Entity(repositoryClass="Patologia\Repository\Determinacao")
 * @ORM\Table(name="determinacao")
 *
 */
class Determinacao extends AbstractEntity {

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(name="id")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", name="descricao") 
     */
    protected $descricao;

    /**
     * @ORM\Column(type="integer", name="tipo")
     */
    protected $tipo;

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getDescricao() {
        return $this->descricao;
    }

    public function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }
}
