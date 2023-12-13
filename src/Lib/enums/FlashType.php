<?php

namespace Stageo\Lib\enums;

enum FlashType : string
{
    case SUCCESS = "success";
    case INFO = "info";
    case WARNING = "warning";
    case ERROR = "error";
}