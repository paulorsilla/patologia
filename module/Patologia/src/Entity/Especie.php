<?php

namespace Patologia\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe Espécie
 * @author silla
 * @ORM\Entity(repositoryClass="Patologia\Repository\Especie")
 * @ORM\Table(name="especie")
 *
 */
class Especie extends AbstractEntity {

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
