<?php

namespace KGolinski\TurboEnum\Enums;

use KGolinski\TurboEnum\Traits\TurboEnum;

enum TestBackedEnum: int
{
    use TurboEnum;
    case one = 1;
    case two = 2;
}
