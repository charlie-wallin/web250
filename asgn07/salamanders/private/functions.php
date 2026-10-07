<?php

// Escape plain text for HTML text or a quoted HTML attribute.
// This does not prepare SQL or change the value stored in the database.
function h(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
