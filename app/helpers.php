<?php

function getCurrentPath()
{
    return parse_url(app('url')->full(), PHP_URL_PATH);
}
