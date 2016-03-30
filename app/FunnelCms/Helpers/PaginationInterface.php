<?php
/**
 * Created by PhpStorm.
 * User: ruben
 * Date: 30/03/2016
 * Time: 14:55
 */

namespace FunnelCms\Helpers;


interface PaginationInterface
{
    function execute();
    function getTotalPages();
    function getResult();
}