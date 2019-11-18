<?php

namespace Patologia\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Classe Método
 * @author silla
 * @ORM\Entity(repositoryClass="Patologia\Repository\Metodo")
 * @ORM\Table(name="metodo")
 */
class Metodo extends AbstractEntity {

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
