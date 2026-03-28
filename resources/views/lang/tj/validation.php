<?php

return [

    'required' => 'Майдони :attribute ҳатмист.',
    'string' => 'Майдони :attribute бояд матн бошад.',
    'integer' => 'Майдони :attribute бояд адад бошад.',
    'numeric' => 'Майдони :attribute бояд рақамӣ бошад.',
    'email' => 'Майдони :attribute бояд почтаи электронӣ (email)-и дуруст бошад.',
    'min' => [
        'string' => 'Майдони :attribute бояд камаш :min ҳарф бошад.',
        'numeric' => 'Майдони :attribute бояд камаш :min бошад.',
    ],
    'max' => [
        'string' => 'Майдони :attribute набояд зиёда аз :max ҳарф бошад.',
        'numeric' => 'Майдони :attribute набояд зиёда аз :max бошад.',
    ],
    'confirmed' => 'Тасдиқи :attribute нодуруст аст.',
    'unique' => ':attribute аллакай вуҷуд дорад.',
    'exists' => ':attribute интихобшуда нодуруст аст.',
    'image' => ':attribute бояд акс бошад.',
    'mimes' => ':attribute бояд файли намуди зерин бошад: :values.',
    'required_with' => 'Майдони :attribute ҳатмист, вақте ки :values мавҷуд аст.',

    'attributes' => [
        'name' => 'ном',
        'email' => 'почтаи электронӣ',
        'password' => 'рамз',
        'password_confirmation' => 'тасдиқи рамз',
        'title' => 'сарлавҳа',
        'description' => 'тавсиф',
        'price' => 'нарх',
        'image' => 'акс',
    ],

];