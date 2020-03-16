<?php

function alert($status)
{
    $message = Session::get($status);
    $alertSymbol = $status === 'success' ? '✓' : '×';
    $code = <<<DOC
            <div class="alert alert-info alert-dismissible fade show my-1" role="alert" align="center">
            ($alertSymbol) $message
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
            </div>
        DOC;
    echo $code;
}

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
