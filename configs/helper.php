<?php

function e($value): string
{
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES, 'UTF-8');
}

function redirect(string $action = '/'): never
{
    header('Location: ' . BASE_URL . ($action === '/' ? '' : '?action=' . $action));
    exit;
}
