<?php
function token(string $token): string
{
    return "<input name='token' type='hidden' value='$token'>";
}