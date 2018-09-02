<?php

namespace Store\Toys;

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Message;
use Phalcon\Validation;
use Phalcon\Validation\Validator\InclusionIn;
use Phalcon\Validation\Validator\Uniqueness;

class Robots extends Model
{
    public function validation()
    {
        $validator = new Validation();
        // Type must be: droid, mechanical or virtual
        // $this->validate(
        //     new InclusionIn(
        //         [
        //             'field'  => 'type',
        //             'domain' => [
        //                 'droid',
        //                 'mechanical',
        //                 'virtual',
        //             ],
        //         ]
        //     )
        // );

        $validator->add(
            'type', //your field name
            new InclusionIn([
                'model' => $this,
                'domain' => [
                        'droid',
                        'mechanical',
                        'virtual',
                    ],
            ])
        );

        // Robot name must be unique
        // $this->validate(
        //     new Uniqueness(
        //         [
        //             'field'   => 'name',
        //             'message' => 'The robot name must be unique',
        //         ]
        //     )
        // );

        $validator->add(
            'name', //your field name
            new Uniqueness([
                'model' => $this,
                'message' => 'The robot name must be unique',
            ])
        );

        // Year cannot be less than zero
        if ($this->year < 0) {
            $this->appendMessage(
                new Message('The year cannot be less than zero')
            );
        }

        // Check if any messages have been produced
        if ($this->validationHasFailed() === true) {
            return false;
        }
    }
}