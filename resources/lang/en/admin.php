<?php

return [
    'admin-user' => [
        'title' => 'Users',

        'actions' => [
            'index' => 'Users',
            'create' => 'New User',
            'edit' => 'Edit :name',
            'edit_profile' => 'Edit Profile',
            'edit_password' => 'Edit Password',
        ],

        'columns' => [
            'id' => 'ID',
            'last_login_at' => 'Last login',
            'first_name' => 'First name',
            'last_name' => 'Last name',
            'email' => 'Email',
            'password' => 'Password',
            'password_repeat' => 'Password Confirmation',
            'activated' => 'Activated',
            'forbidden' => 'Forbidden',
            'language' => 'Language',
                
            //Belongs to many relations
            'roles' => 'Roles',
                
        ],
    ],

    'brand' => [
        'title' => 'Brands',

        'actions' => [
            'index' => 'Brands',
            'create' => 'New Brand',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'slug' => 'Slug',
            'name' => 'Name',
            'icon' => 'Icon',
            
        ],
    ],

    'body-type' => [
        'title' => 'Body Types',

        'actions' => [
            'index' => 'Body Types',
            'create' => 'New Body Type',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'slug' => 'Slug',
            'name' => 'Name',
            'icon' => 'Icon',
            
        ],
    ],

    'type' => [
        'title' => 'Types',

        'actions' => [
            'index' => 'Types',
            'create' => 'New Type',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'slug' => 'Slug',
            'name' => 'Name',
            
        ],
    ],

    'fuel' => [
        'title' => 'Fuels',

        'actions' => [
            'index' => 'Fuels',
            'create' => 'New Fuel',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'slug' => 'Slug',
            'name' => 'Name',
            
        ],
    ],

    'car-model' => [
        'title' => 'Car Models',

        'actions' => [
            'index' => 'Car Models',
            'create' => 'New Car Model',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'slug' => 'Slug',
            'name' => 'Name',
            'brand_id' => 'Brand',
            
        ],
    ],

    // Do not delete me :) I'm used for auto-generation
];