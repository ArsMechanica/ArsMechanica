<?php
/**
 * Created by PhpStorm.
 * User: Ars
 * Date: 10/15/2017
 * Time: 6:58 PM
 */

namespace ArsMechanica\Eshop;

use \ArsMechanica\Interfaces\Singleton;
use \ArsMechanica\DataBase\MysqlLink;


class OrderPartMapper
{
    use Singleton;

    public function orderPartGet(int $orderId, int $productId):OrderPart {
        $BdLink = MysqlLink::getLink();

        $orderPartRes = $BdLink->query('SELECT * FROM `order_parts_list` 
            WHERE `order_id`=' . $orderId . ' 
            AND `product_id`=' . $productId);

        if($orderPartRes->num_rows == 0) {
            $orderPart = new OrderPart();

            $price = $BdLink->query('SELECT `consumer_price` FROM `products_list` WHERE `product_id`=' . $productId)->fetch_object()->consumer_price;

            $orderPart->setOrderId($orderId);
            $orderPart->setProductId($productId);
            $orderPart->setCurrentPrice($price);


        }
        else {
            $orderPart = $this->orderPartEncodeFromRaw($orderPartRes->fetch_assoc());
        }

        return $orderPart;
    }

    public function orderPartLoad(int $orderPartid): ?OrderPart {
        $BdLink = MysqlLink::getLink();

        $orderPartRes = $BdLink->query('SELECT * FROM `order_parts_list` WHERE `order_part_id`=' . $orderPartid);

        return $this->orderPartEncodeFromRaw($orderPartRes->fetch_assoc());
    }

    public function orderPartListLoad(int $orderId): ?OrderPart {
        $BdLink = MysqlLink::getLink();

        $orderPartRes = $BdLink->query();
    }


    public function orderPartSave(OrderPart $OrderPart): void {
        $BdLink = MysqlLink::getLink();

        $OrderPart->generateTotalCost();

        if($OrderPart->getOrderPartId() == NULL) {
            $query = 'INSERT INTO `order_parts_list` SET 
                `order_id`=' . $OrderPart->getOrderId() . ',
                `product_id`=' . $OrderPart->getProductId() . ',
                `product_name`="' . $OrderPart->getProductName() . '",
                `quantity`=' . $OrderPart->getQuantity() . ',
                `current_price`=' . $OrderPart->getCurrentPrice() . ',
                `discount`=' . $OrderPart->getDiscount() . ',
                `final_price`=' . $OrderPart->getFinalPrice() . ',
                `total_cost`=' . $OrderPart->getTotalCost() . ';';

            $BdLink->query($query);

            $OrderPart->getOrderPartId($BdLink->insert_id);
        } else {
            $query = 'UPDATE `order_parts_list` SET 
                `order_id`=' . $OrderPart->getOrderId() . ',
                `product_id`=' . $OrderPart->getProductId() . ',
                `product_name`="' . $OrderPart->getProductName() . '",
                `quantity`=' . $OrderPart->getQuantity() . ',
                `current_price`=' . $OrderPart->getCurrentPrice() . ',
                `discount`=' . $OrderPart->getDiscount() . ',
                `final_price`=' . $OrderPart->getFinalPrice() . ',
                `total_cost`=' . $OrderPart->getTotalCost() . '
                WHERE `order_part_id` = ' . $OrderPart->getOrderPartId() . ';';

            $BdLink->query($query);
        }
    }

    public function orderPartEncodeFromRaw(array $array): OrderPart {
        $orderPart = new OrderPart();

        if(array_key_exists('order_part_id', $array)) {
            $orderPart->setOrderPartId($array['order_part_id']);
        }

        if(array_key_exists('order_id', $array)) {
            $orderPart->setOrderId($array['order_id']);
        }

        if(array_key_exists('product_id', $array)) {
            $orderPart->setProductId($array['product_id']);
        }

        if(array_key_exists('product_name', $array)) {
            $orderPart->setProductName($array['product_name']);
        }

        if(array_key_exists('quantity', $array)) {
            $orderPart->setQuantity($array['quantity']);
        }

        if(array_key_exists('current_price', $array)) {
            $orderPart->setCurrentPrice($array['current_price']);
        }

        if(array_key_exists('discount', $array)) {
            $orderPart->setDiscount($array['discount']);
        }

        if(array_key_exists('final_price', $array)) {
            $orderPart->setFinalPrice($array['final_price']);
        }

        if(array_key_exists('total_cost', $array)) {
            $orderPart->setTotalCost($array['total_cost']);
        }

        return $orderPart;
    }

    public function orderPartsDelByOrderId(int $orderId) {
        $BdLink = MysqlLink::getLink();

        $BdLink->query('DELETE FROM `order_parts_list` WHERE `order_id`=' . $orderId);
    }

}