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

    'cars-color' => [
        'title' => 'Cars Colors',

        'actions' => [
            'index' => 'Cars Colors',
            'create' => 'New Cars Color',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'slug' => 'Slug',
            'name' => 'Name',
            'color_code' => 'Color code',
            
        ],
    ],

    'car' => [
        'title' => 'Cars',

        'actions' => [
            'index' => 'Cars',
            'create' => 'New Car',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'car_model_id' => 'Car model',
            'availability_label' => 'Availability label',
            'price_1' => 'Price 1',
            'price_7' => 'Price 7',
            'price_30' => 'Price 30',
            'price_31_more' => 'Price 31 more',
            'deposit' => 'Deposit',
            'km_included_per_day' => 'Km included per day',
            'overlimit_charge_per_km' => 'Overlimit charge per km',
            'min_day_reservation' => 'Min day reservation',
            'free_delivery' => 'Free delivery',
            'registration_number' => 'Registration number',
            'color_id' => 'Color',
            'fuel_id' => 'Fuel',
            'attribute_year' => 'Attribute year',
            'attribute_seats' => 'Attribute seats',
            'attribute_1_to_100' => 'Attribute 1 to 100',
            'attribute_max_speed' => 'Attribute max speed',
            'attribute_horsepower' => 'Attribute horsepower',
            'attribute_transmission' => 'Attribute transmission',
            'attribute_doors' => 'Attribute doors',
            'attribute_engine' => 'Attribute engine',
            'attribute_baggage' => 'Attribute baggage',
            'status' => 'Status',
            
        ],
    ],

    'currency' => [
        'title' => 'Currencies',

        'actions' => [
            'index' => 'Currencies',
            'create' => 'New Currency',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'slug' => 'Slug',
            'sign' => 'Sign',
            'exchange_rate' => 'Exchange rate',
            
        ],
    ],

    'page' => [
        'title' => 'Pages',

        'actions' => [
            'index' => 'Pages',
            'create' => 'New Page',
            'edit' => 'Edit :name',
        ],

        'columns' => [
            'id' => 'ID',
            'title' => 'Title',
            'link' => 'Link',
            'type' => 'Type',
            'h1' => 'H1',
            'description' => 'Description',
            'content' => 'Content',
            'enabled' => 'Enabled',
            'faq' => 'Faq',
            
        ],
    ],

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

    // Do not delete me :) I'm used for auto-generation
];