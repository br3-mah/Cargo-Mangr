<?php

return [
    'name' => 'Acl',


    'permissions' => [

        // roles group

        // 'roles' => [ // Group name
        //     'manage-roles', // permission name
        //     'view-roles',
        //     'create-roles',
        //     'edit-roles',
        //     'delete-roles',
        // ],

        // others group ...
        'posts' => [ 
            'view-posts', // permission name
            'read-posts', // permission name
        ]
    ],
];