<?php
/**
 * Created by PhpStorm.
 * User: Ars
 * Date: 10/17/2017
 * Time: 10:29 PM
 */

namespace ArsMechanica\Eshop;


class OrderPartList
{
    use \ArsMechanica\Interfaces\Iterator;

    private $list = [];
    private $index = -1;

    public function addItem(OrderPart $OrderPart): void
    {
        array_push($this->list, $OrderPart);
    }

    public function getSize()
    {
        return count($this->list);
    }

    public function rewind()
    {
        $this->index = -1;
    }

    public function getNextItem(): OrderPart
    {
        if($this->hasNext()){
            $this->index++;
            return $this->list[$this->index];
        }
    }

    public function hasNext(): bool
    {
        return array_key_exists($this->index+1, $this->list);
    }

    public function getCurrentItem()
    {
        return $this->list[$this->index];
    }

    public function getCurrentIndex(): int
    {
        return $this->index;
    }
}