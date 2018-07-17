<?php
/**
 * Created by PhpStorm.
 * User: Ars
 * Date: 10/15/2017
 * Time: 6:09 PM
 */

namespace ArsMechanica\Eshop;


class Order
{
    private $orderId = 0;
    private $orderCode = '';
    private $orderStatusId = 1;
    private $lastActionTsh = 0;
    private $userId = 0;
    private $orderPartList;
    private $discount = 0.0;
    private $totalQuantity = 0;
    private $totalCost = 0.0;
    private $buyerComment = '';
    private $adminComment = '';

    public function __construct()
    {
        $this->orderPartList = new OrderPartList();
        $this->lastActionTsh = strtotime('now');
    }

    public function setOrderId(int $orderId)
    {
        $this->orderId = $orderId;
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function getOrderCode(): string
    {
        return $this->orderCode;
    }

    public function setOrderCode(string $orderCode): void
    {
        $this->orderCode = $orderCode;
    }

    public function generateOrderCode(): void
    {
        $this->orderCode = md5(uniqid(rand(), true));
        setcookie("order-code", $this->orderCode, time() + 3600 * 24 * 7);
    }

    /**
     * @param int $orderStatusId
     */
    public function setOrderStatusId(int $orderStatusId)
    {
        $this->orderStatusId = $orderStatusId;
    }

    /**
     * @return int
     */
    public function getOrderStatusId(): int
    {
        return $this->orderStatusId;
    }

    /**
     * @param false|int $lastActionTsh
     */
    public function setLastActionTsh(int $lastActionTsh)
    {
        $this->lastActionTsh = $lastActionTsh;
    }

    /**
     * @return false|int
     */
    public function getLastActionTsh(): int
    {
        return $this->lastActionTsh;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId)
    {
        $this->userId = $userId;
    }

    /**
     * @return float
     */
    public function setOrderPartList(OrderPartList $OrderPartList)
    {
        $this->orderPartList = $OrderPartList;
    }

    public function addOrderPart(OrderPart $OrderPart): void
    {
        $this->orderPartList->addItem($OrderPart);
        $this->totalQuantity = $this->totalQuantity + $OrderPart->getQuantity();
        $this->totalCost = $this->totalCost + $OrderPart->getTotalCost();
    }

    /**
     * @return array
     */
    public function getOrderPartList(): OrderPartList
    {
        return $this->orderPartList;
    }

    /**
     * @param float $totalCost
     */
    public function computeTotal(): void
    {
        $this->orderPartList->rewind();
        $this->totalQuantity = 0;
        $this->totalCost = 0;

        while ($this->orderPartList->hasNext()) {
            $item = $this->orderPartList->getNextItem();
            $this->totalQuantity += $item->getQuantity();
            $this->totalCost += $item->getTotalCost();
        }

        $this->orderPartList->rewind();
    }

    /**
     * @return float
     */
    public function getTotalCost(): float
    {
        return $this->totalCost;
    }

    /**
     * @return int
     */
    public function getTotalQuantity(): int
    {
        return $this->totalQuantity;
    }

    public function setAdminComment(string $buyerComment)
    {
        $this->buyerComment = $buyerComment;
    }

    public function getAdminComment(): string
    {
        return $this->adminComment;
    }

    public function setBuyerComment(string $buyerComment)
    {
        $this->buyerComment = $buyerComment;
    }

    public function getBuyerComment(): string
    {
        return $this->buyerComment;
    }

}