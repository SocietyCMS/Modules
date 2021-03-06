<?php

namespace Modules\Modules\MenuExtenders;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Core\Contracts\Authentication;

class SidebarExtender implements \Maatwebsite\Sidebar\SidebarExtender
{
    /**
     * @var Authentication
     */
    protected $auth;

    /**
     * @param Authentication $auth
     *
     * @internal param Guard $guard
     */
    public function __construct(Authentication $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @param Menu $menu
     *
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {
        $menu->group(trans('core::sidebar.workshop'), function (Group $group) {
            $group->weight(20);

            $group->item(trans('modules::module.title'), function (Item $item) {
                $item->weight(10);
                $item->icon('fa fa-gears');
                $item->route('backend::modules.modules.index');
                $item->authorize(
                    $this->auth->can('modules::manage-modules')
                );
            });

        });

        return $menu;
    }
}
