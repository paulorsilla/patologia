<?php

namespace Patologia\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use DoctrineModule\Persistence\ObjectManagerAwareInterface;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Formulário utilizado para o cadastro de Amostras
 */
class AmostraForm extends Form implements ObjectManagerAwareInterface {

    protected $objectManager;

    /**
     * Construtor
     */
    public function __construct($objectManager) {

        $this->objectManager = $objectManager;
        //Determina o nome do formulário
        parent::__construct('amostra-form');

        //Define o método POST para envio do formulário
        $this->setAttribute('method', 'post');

        $this->addElements();
        $this->addInputFilter();
    }

    public function setObjectManager(ObjectManager $objectManager) {
        $this->objectManager = $objectManager;
    }

    public function getObjectManager() {
        return $this->objectManager;
    }

    protected function addElements() {
        //Adiciona o campo "localColheita"
        $this->add([
            'type' => 'text',
            'name' => 'localColheita',
            'attributes' => [
                'id' => 'localColheita'
            ],
            'options' => [
                'label' => 'Local da colheita'
            ],
        ]);

        //Adiciona o campo "dataColheita"
        $this->add([
            'type' => 'Zend\Form\Element\Date',
            'name' => 'dataColheita',
            'attributes' => [
                'id' => 'dataColheita',
                'class' => 'form-control',
            ],
            'options' => [
                'label' => 'Data da colheita',
                'format' => 'Y-m-d'
            ],
        ]);

        //Adiciona o campo "dataRecebimento"
        $this->add([
            'type' => 'Zend\Form\Element\Date',
            'name' => 'dataRecebimento',
            'attributes' => [
                'id' => 'dataRecebimento'
            ],
            'options' => [
                'label' => 'Data do recebimento',
                'format' => 'Y-m-d'
            ],
        ]);

        //Adiciona o campo "remetente"
        $this->add([
            'type' => 'text',
            'name' => 'remetente',
            'attributes' => [
                'id' => 'remetente'
            ],
            'options' => [
                'label' => 'Remetente'
            ],
        ]);

        //Adiciona o campo "numeroRepeticoes"
        $this->add([
            'type' => 'text',
            'name' => 'numeroRepeticoes',
            'attributes' => [
                'id' => 'numeroRepeticoes'
            ],
            'options' => [
                'label' => 'Número de repetições'
            ],
        ]);

        //Adiciona o campo "numeroAmostras"
        $this->add([
            'type' => 'text',
            'name' => 'numeroAmostras',
            'attributes' => [
                'id' => 'numeroAmostras'
            ],
            'options' => [
                'label' => 'Número de amostras'
            ],
        ]);

        //Adiciona o campo "prefixoNumero" utilizado para compor 
        //o número do laboratório de cada amostra
        $this->add([
            'type' => 'text',
            'name' => 'prefixoNumero',
            'attributes' => [
                'id' => 'prefixoNumero'
            ],
            'options' => [
                'label' => 'Prefixo'
            ],
        ]);

        //Adiciona o campo "sequenciaNumero" utilizado para compor
        //o número do laboratório de cada amostra
        $this->add([
            'type' => 'text',
            'name' => 'sequenciaNumero',
            'attributes' => [
                'id' => 'sequenciaNumero'
            ],
            'options' => [
                'label' => 'Sequência'
            ],
        ]);

        //Adiciona o campo "sufixoNumero" utilizado para compor
        //o número do laboratório de cada amostra
        $this->add([
            'type' => 'text',
            'name' => 'sufixoNumero',
            'attributes' => [
                'id' => 'sufixoNumero'
            ],
            'options' => [
                'label' => 'Sufixo'
            ],
        ]);

        //Adiciona o campo "espécie"
        $this->add([
            'type' => 'DoctrineModule\Form\Element\ObjectSelect',
            'name' => 'especie',
            'attributes' => [
                'id' => 'especie'
            ],
            'options' => [
                'label' => 'Espécie',
                'object_manager' => $this->getObjectManager(),
                'target_class' => 'Patologia\Entity\Especie',
                'property' => 'descricao',
                'display_empty_item' => true,
                'empty_item_label' => '-- Selecione --'
            ]
        ]);

        $this->add([
            'type' => 'submit',
            'name' => 'submit',
            'attributes' => [
                'value' => 'Salvar',
                'id' => 'submitbutton',
            ]
        ]);
    }

    private function addInputFilter() {
        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);


        $inputFilter->add([
            'name' => 'dataRecebimento',
            'required' => false,
        ]);

        $inputFilter->add([
            'name' => 'dataColheita',
            'required' => false,
        ]);

        $inputFilter->add([
            'name' => 'localColheita',
            'required' => false,
            'filters' => [
                ['name' => 'StringTrim'],
                ['name' => 'StripTags'],
                ['name' => 'StripNewlines'],
            ],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 300
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'remetente',
            'required' => false,
            'filters' => [
                ['name' => 'StringTrim'],
                ['name' => 'StripTags'],
                ['name' => 'StripNewlines'],
            ],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 0,
                        'max' => 300
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'numeroAmostras',
            'required' => true,
            'filters' => [
                ['name' => 'StringTrim'],
                ['name' => 'StripTags'],
                ['name' => 'StripNewlines'],
            ],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 3
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'numeroRepeticoes',
            'required' => true,
            'filters' => [
                ['name' => 'StringTrim'],
                ['name' => 'StripTags'],
                ['name' => 'StripNewlines'],
            ],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 2
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'sequenciaNumero',
            'required' => true,
            'filters' => [
                ['name' => 'StringTrim'],
                ['name' => 'StripTags'],
                ['name' => 'StripNewlines'],
            ],
            'validators' => [
                [
                    'name' => 'StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 50
                    ],
                ],
            ],
        ]);
    }

}
