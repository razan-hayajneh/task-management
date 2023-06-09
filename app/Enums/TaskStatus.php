<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static CREATED()
 * @method static static PROGRESS()
 * @method static static FINISHED()
 */
final class TaskStatus extends Enum
{
    const CREATED = 'created';
    const PROGRESS = 'progress';
    const FINISHED = 'finished';
}
