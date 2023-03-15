<?php

namespace App\Validation;

use Phalcon\Filter\Validation;
use Phalcon\Filter\Validation\Validator\Email;
use Phalcon\Filter\Validation\Validator\PresenceOf;
use Phalcon\Filter\Validation\Validator\StringLength;

class LoginValidation extends Validation
{
    public function initialize()
    {
        $this->rules(
            'email',
            [
                new PresenceOf([
                    'message' => 'Email or username is required.'
                ])
            ]
        );

        $this->rules(
            'password',
            [
                new PresenceOf([
                    'message' => 'Password is required.',
                    'cancelOnFail' => true
                ]),
                new StringLength([
                    'min' => 6,
                    'messageMinimum' => 'Password must be at least 6 characters.'
                ])
            ]
        );

        $this->rules(
            'remember',
            [
                new Validation\Validator\InclusionIn([
                    "message" => "Remember me is not valid.",
                    "domain" => [0, 1]
                ])
            ]
        );
    }

}