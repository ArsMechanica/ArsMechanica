<?php
/**
 * Created by PhpStorm.
 * User: Ars
 * Date: 10/15/2017
 * Time: 6:29 PM
 */

namespace ArsMechanica\Eshop;

use \ArsMechanica\DataBase\MysqlLink;

class OrderPart
{
    private $orderPartId = NULL;
    private $orderId = NULL;
    private $productId = NULL;
    private $productName = '';
    private $quantity = 0;
    private $currentPrice = 0.0;
    private $discount = 0.0;
    private $finalPrice = 0.0;
    private $totalCost = 0.0;

    public function __construct()
    {
    }

    /**
     * @param mixed $orderPartId
     */
    public function setOrderPartId(int $orderPartId): void
    {
        $this->orderPartId = $orderPartId;
    }

    /**
     * @return mixed
     */
    public function getOrderPartId(): ?int
    {
        return $this->orderPartId;
    }

    /**
     * @param int $orderId
     */
    public function setOrderId(int $orderId): void
    {
        $this->orderId = $orderId;
    }

    /**
     * @return int
     */
    public function getOrderId(): int
    {
        return $this->orderId;
    }

    /**
     * @param int $productId
     */
    public function setProductId(int $productId): void
    {
        $this->productId = $productId;

        $BdLink = MysqlLink::getLink();
        $name = $BdLink->query('SELECT `name` FROM `products_list` WHERE `product_id`=' . $productId)->fetch_object()->name;
        $this->setProductName($name);
    }

    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->productId;
    }

    /**
     * @param mixed $productName
     */
    public function setProductName(string $productName): void
    {
        $this->productName = $productName;
    }

    /**
     * @return mixed
     */
    public function getProductName(): string
    {
        return $this->productName;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
        $this->generateTotalCost();
    }

    public function changeQuantity(int $changeQantity):void {
        $this->quantity = $this->quantity + $changeQantity;
        if($this->quantity <=0) {
            $this->quantity = 0;
        }
        $this->generateTotalCost();
    }

    /**
     * @return mixed
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @param float $currentPrice
     */
    public function setCurrentPrice(float $currentPrice): void
    {
        $this->currentPrice = round($currentPrice, 2);
        $this->finalPrice = $this->currentPrice;
        $this->generateTotalCost();
    }

    /**
     * @return float
     */
    public function getCurrentPrice(): float
    {
        return $this->currentPrice;
    }

    /**
     * @param int $discount
     */
    public function setDiscount(int $discount): void
    {
        if ($discount < 0 OR $discount > 100) {
            throw new \Exception('discount value must be between 0 and 100%');
        }
        $this->discount = $discount;
        $this->generateFinalPrice();
    }

    /**
     * @return int
     */
    public function getDiscount(): int
    {
        return $this->discount;
    }

    /**
     * @param float $finalPrice
     */
    public function setFinalPrice(float $finalPrice): void
    {
        $this->finalPrice = round($finalPrice);
    }

    /**
     * @param mixed $finalPrice
     */
    public function generateFinalPrice(): void
    {
        $this->setFinalPrice($this->currentPrice * (1 - 0.01 * $this->discount));
    }

    /**
     * @return mixed
     */
    public function getFinalPrice(): float
    {
        return $this->finalPrice;
    }

    /**
     * @param mixed $totalCost
     */
    public function setTotalCost(float $totalCost)
    {
        $this->totalCost = round($totalCost, 2);
    }

    public function generateTotalCost(): void
    {
        if($this->finalPrice <= 0) {
            $this->generateFinalPrice();
        }
        $this->setTotalCost($this->getQuantity() * $this->getFinalPrice());
    }

    /**
     * @return mixed
     */
    public function getTotalCost(): float
    {
        return $this->totalCost;
    }

}