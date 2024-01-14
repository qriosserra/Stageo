<?php

namespace Stageo\Lib\enums;
/*
 * type de message flash
 */
enum FlashType : string
{
    case SUCCESS = "success";
    case INFO = "info";
    case WARNING = "warning";
    case ERROR = "error";
}