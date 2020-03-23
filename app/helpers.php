<?php

function getTableStyle($status, $route)
{
    switch ($route) {
        case 'index':
            $class = "d-flex table-";
            break;
        case 'show':
            $class = "d-flex align-items-center table-borderless table-";
            break;
    }
    switch ($status) {
        case 'failed':
            $status = "danger";
            break;
        case 'successed':
            $status = "success";
            break;
    }
    echo "{$class}{$status}";
}
