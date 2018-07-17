<?php
/**
 * Created by PhpStorm.
 * User: Ars
 * Date: 13.03.2017
 * Time: 12:05
 */

namespace ArsMechanica\Command;

use ArsMechanica\Controller\Request;

class DefaultCommand extends Command{
    protected function doExecute(Request $Request) {
        try {
            throw new \Exception('ляляляля');
        }
        catch (\Exception $e) {
            $Request->addError('Случилась предсказуемая херня.');
        }
        echo '<pre>';
        print_r($Request);
        echo '</pre>';
    }
}