<?php

declare(strict_types=1);

namespace App\Response;

use JsonSerializable;

class Success implements JsonSerializable
{
    public function jsonSerialize(): array
    {
        return ['status' => 'ok'];
    }
}
