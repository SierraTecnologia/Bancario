<?php

namespace Bancario\Listeners;

use Bancario\Events\TraddingPositionOpened;
use Bancario\Facades\Support;

class OnOpenPosition
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Create a MenuItem for a given BREAD.
     *
     * @param TraddingPositionOpened $event
     *
     * @return void
     */
    public function handle(TraddingPositionOpened $bread)
    {
        // if (\Illuminate\Support\Facades\Config::get('sitec.facilitador.bread.add_menu_item') && file_exists(base_path('routes/web.php'))) {
        //     $menu = Support::model('Menu')->where('name', \Illuminate\Support\Facades\Config::get('sitec.facilitador.bread.default_menu'))->firstOrFail();

        //     $menuItem = Support::model('MenuItem')->firstOrNew(
        //         [
        //         'menu_id' => $menu->id,
        //         'title'   => $bread->dataType->getTranslatedAttribute('display_name_plural'),
        //         'url'     => '',
        //         'route'   => 'facilitador.'.$bread->dataType->slug.'.index',
        //         ]
        //     );

        //     $order = Support::model('MenuItem')->highestOrderMenuItem();

        //     if (!$menuItem->exists) {
        //         $menuItem->fill(
        //             [
        //             'target'     => '_self',
        //             'icon_class' => $bread->dataType->icon,
        //             'color'      => null,
        //             'parent_id'  => null,
        //             'order'      => $order,
        //             ]
        //         )->save();
        //     }
        // }
    }
}
