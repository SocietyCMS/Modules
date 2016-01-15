<?php

namespace Modules\Modules\Installer;

class RegisterDefaultPermissions
{

    public $defaultPermissions = [

        'manage-modules' => [
            'display_name' => 'modules::module-permissions.manage-modules.display_name',
            'description'  => 'modules::module-permissions.manage-modules.description',
        ],

    ];
}