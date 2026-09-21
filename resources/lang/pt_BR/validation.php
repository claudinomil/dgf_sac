<?php

return [

    'required' => 'O campo :attribute é obrigatório.',
    'email' => 'O campo :attribute deve ser um endereço de e-mail válido.',
    'confirmed' => 'A confirmação de :attribute não confere.',
    'min' => [
        'string' => 'O campo :attribute deve ter pelo menos :min caracteres.',
    ],
    'max' => [
        'string' => 'O campo :attribute não pode ter mais que :max caracteres.',
    ],

    'attributes' => [
        'name' => 'nome',
        'email' => 'email',
        'password' => 'senha',
        'current_password' => 'senha atual',
        'password_confirmation' => 'confirmação de senha',
        'user' => 'usuário',
    ],

];
