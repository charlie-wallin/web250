<?php

// Escape plain text for an HTML text node or a quoted HTML attribute.
// This is output escaping, not SQL protection.
function h(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
