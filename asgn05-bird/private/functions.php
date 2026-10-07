<?php

function h($string)
{
    return htmlspecialchars((string) $string, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function u($string)
{
    return rawurlencode((string) $string);
}
