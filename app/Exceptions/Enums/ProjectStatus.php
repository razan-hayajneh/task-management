<?php

declare(strict_types=1);

namespace App\Enums;

use BenSampo\Enum\Enum;

/**
 * @method static static CREATED()
 * @method static static PENDING()
 * @method static static WAITING()
 * @method static static INPROGRESS()
 * @method static static DONE()
 */
final class ProjectStatus extends Enum
{
    const CREATED = 'created';
    const PENDING = 'pending';
    const WAITING = 'waiting';
    const PROGRESS = 'progress';
    const FINISHED = 'finished';
}
