<?php

namespace KGolinski\TurboEnum\Enums;

use KGolinski\TurboEnum\Traits\TurboEnum;

enum TestEnum
{
    use TurboEnum;
    case one;
    case two;
}
