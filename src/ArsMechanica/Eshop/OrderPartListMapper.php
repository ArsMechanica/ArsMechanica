<?php
/**
 * Created by PhpStorm.
 * User: Ars
 * Date: 10/17/2017
 * Time: 11:02 PM
 */

namespace ArsMechanica\Eshop;

use \ArsMechanica\Interfaces\Singleton;
use \ArsMechanica\DataBase\MysqlLink;

class OrderPartListMapper
{
    use Singleton;

    public function getOrderPartListForOrder(int $orderId)
    {
        $OrderPartList = new OrderPartList();
        $BdLink = MysqlLink::getLink();
        $OrderPartMapper = OrderPartMapper::getInstance();

        $listRaw = $BdLink->query('SELECT * FROM `order_parts_list` WHERE `order_id`=' . $orderId);

        while($item = $listRaw->fetch_assoc()){
            $OrderPartList->addItem($OrderPartMapper->orderPartEncodeFromRaw($item));
        }

        return $OrderPartList;

    }
}