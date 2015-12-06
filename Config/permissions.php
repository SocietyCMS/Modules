<?php
return [
    'modules' => [
        'index' => [
            'modules.modules.index',
            'modules.modules.show',
        ],
        'create' => [
            'modules.modules.create',
            'modules.modules.store',
        ],
        'edit' => [
            'modules.modules.edit',
            'modules.modules.update',
        ],
        'destroy' => [
            'modules.modules.destroy',
        ],
    ],
];
