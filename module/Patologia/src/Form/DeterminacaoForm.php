<?php

namespace Patologia\Form;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

/**
 * Formulário utilizado para o cadastro e Saprófitas
 */
class DeterminacaoForm extends Form {

    /**
     * Construtor
     */
    public function __construct() {
        //Determina o nome do formulário
        parent::__construct('determinacao-form');

        //Define o método POST para envio do formulário
        $this->setAttribute('method', 'post');

        $this->addElements();
        $this->addInputFilter();
    }

    protected function addElements() {
        //Adiciona o campo "Descrição"
        $this->add([
            'type' => 'text',
            'name' => 'descricao',
            'attributes' => [
                'id' => 'descricao'
            ],
            'options' => [
                'label' => 'Descrição'
            ],
        ]);

        //Adiciona o campo "Tipo"
        $this->add([
            'type' => 'select',
            'name' => 'tipo',
            'attributes' => [
                'id' => 'tipo'
            ],
            'options' => [
                'label' => 'Tipo',
                'value_options' => [
                    '' => "-- Selecione --",
                    '1' => "Patógeno (fungo)",
                    '2' => "Outras"
                ]
            ],
        ]);

        //Adiciona o botão submit
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
            'name' => 'descricao',
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
                        'max' => 300
                    ],
                ],
            ],
        ]);
    }

}
