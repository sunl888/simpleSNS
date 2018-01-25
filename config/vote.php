<?php
return [

    // vote 表名称
    'votes_table' => 'votes',

    // Application User Model, Update the User if it is in a different namespace.
    'user' => App\Models\User::class,

    'users_table' => 'users',

    'user_foreign_key' => 'user_id',

    'morph_prefix' => 'votable'
];