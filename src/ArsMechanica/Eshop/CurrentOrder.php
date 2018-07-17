<?php
/**
 * Created by PhpStorm.
 * User: Ars
 * Date: 10/15/2017
 * Time: 6:10 PM
 */

namespace ArsMechanica\Eshop;


class CurrentOrder
{
    use \ArsMechanica\Interfaces\Singleton;

    private $Order;
    private $currentOrderCode;


    private function __construct()
    {
        if(is_set($_COOKIE['current-order-code'])) {
            $this->Order = OrderMapper::
        }

        $this->Order =
    }



}