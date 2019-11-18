<?php

namespace Patologia\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe Saprofita
 * @author silla
 * @ORM\Entity(repositoryClass="Patologia\Repository\Saprofita")
 * @ORM\Table(name="saprofita")
 */
class Saprofita extends AbstractEntity {

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

}
