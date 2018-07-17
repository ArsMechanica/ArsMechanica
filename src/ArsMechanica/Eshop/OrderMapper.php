<?php
/**
 * Created by PhpStorm.
 * User: Ars
 * Date: 10/15/2017
 * Time: 6:15 PM
 */

namespace ArsMechanica\Eshop;

use \ArsMechanica\Interfaces\Singleton;
use \ArsMechanica\DataBase\MysqlLink;
use \ArsMechanica\Eshop\OrderPartMapper;


class OrderMapper
{
    use Singleton;

    public function orderGet(): Order
    {
        if (array_key_exists('cookie-enable', $_COOKIE)) {
            if (array_key_exists('order-code', $_COOKIE)) {
                $Order = $this->orderLoadByCode($_COOKIE['order-code']);
            } else {
                $Order = new Order();
                $Order->generateOrderCode();
                $this->orderSave($Order);
            }
            return $Order;
        }
    }

    public function orderLoadById(int $orderId): Order
    {
        $BdLink = MysqlLink::getLink();
        $OrderRes = $BdLink->query('SELECT * FROM `orders_list` WHERE `order_id`=' . $orderId);
        $OrderArr = $OrderRes->fetch_assoc();
        $Order = $this->orderEncodeFromRaw($OrderArr);

        $OrderPartListMapper = OrderPartListMapper::getInstance();

        $Order->setOrderPartList($OrderPartListMapper->getOrderPartListForOrder($Order->getOrderId()));

        $Order->computeTotal();

        return $Order;
    }

    public function orderLoadByCode(string $orderCode): Order
    {
        $BdLink = MysqlLink::getLink();
        $OrderRes = $BdLink->query('SELECT * FROM `orders_list` WHERE `order_code`="' . $orderCode . '"');
        $OrderArr = $OrderRes->fetch_assoc();
        $Order = $this->orderEncodeFromRaw($OrderArr);

        $OrderPartListMapper = OrderPartListMapper::getInstance();

        $Order->setOrderPartList($OrderPartListMapper->getOrderPartListForOrder($Order->getOrderId()));

        $Order->computeTotal();

        return $Order;
    }

    private function orderEncodeFromRaw(array $array): Order
    {
        $Order = new Order();

        if (array_key_exists('order_id', $array)) {
            $Order->setOrderId($array['order_id']);
        }

        if (array_key_exists('user_id', $array) AND (int)$array['order_id'] > 0) {
            $Order->setUserId($array['order_id']);
        }

        if (array_key_exists('order_code', $array)) {
            $Order->setOrderCode($array['order_code']);
        }

        if (array_key_exists('order_status_id', $array)) {
            $Order->setOrderStatusId($array['order_status_id']);
        }


        if (array_key_exists('last_action_tsh', $array)) {
            $Order->setLastActionTsh($array['last_action_tsh']);
        }

        if (array_key_exists('user_comment', $array)) {
            $Order->setBuyerComment(html_entity_decode($array['user_comment'], ENT_QUOTES, 'utf-8'));
        }

        if (array_key_exists('admin_comment', $array)) {
            $Order->setAdminComment(html_entity_decode($array['admin_comment'], ENT_QUOTES, 'utf-8'));
        }

        return $Order;
    }

    public function orderSave(Order $Order)
    {
        $BdLink = MysqlLink::getLink();

        if ($Order->getUserId() < 1) {
            $userInsert = 'NULL';
        } else {
            $userInsert = $Order->getUserId();
        }

        if ($Order->getOrderId() < 1) {
            $BdLink->query('INSERT INTO `orders_list` SET 
                `order_code`="' . $Order->getOrderCode() . '",
                `order_status_id`=1,
                `order_user_id`=' . $userInsert . ',
                `last_action_tsh`=' . strtotime('now') . ',
                `admin_comment` ="' . htmlentities($Order->getAdminComment(), ENT_QUOTES, 'utf-8') . '",
                `user_comment` ="' . htmlentities($Order->getBuyerComment(), ENT_QUOTES, 'utf-8') . '"');
            $Order->setOrderId($BdLink->insert_id);
        } else {
            $BdLink->query('UPDATE `orders_list` SET 
                `order_code`="' . $Order->getOrderCode() . '",
                `order_status_id`= ' . $Order->getOrderStatusId() . ',
                `order_user_id`=' . $userInsert . ',
                `last_action_tsh`=' . strtotime('now') . ',
                `admin_comment` ="' . htmlentities($Order->getAdminComment(), ENT_QUOTES, 'utf-8') . '",
                `user_comment` ="' . htmlentities($Order->getBuyerComment(), ENT_QUOTES, 'utf-8') . '"
                WHERE `order_id`=' . $Order->getOrderId());
        }

        $OrderPartMapper = \ArsMechanica\Eshop\OrderPartMapper::getInstance();

        foreach ($Order->getOrderPartList() AS $OrderPart) {
            $OrderPart->setOrderId($Order->getOrderId());

            $OrderPartMapper->orderPartSave($OrderPart);
        }

    }
}