<?php

declare(strict_types=1);

namespace App\Scheduler;

use App\Scheduler\Message\SendDailyQuote;
use DateTimeZone;
use Symfony\Component\Scheduler\Attribute\AsSchedule;
use Symfony\Component\Scheduler\RecurringMessage;
use Symfony\Component\Scheduler\Schedule;
use Symfony\Component\Scheduler\ScheduleProviderInterface;

#[AsSchedule('send_daily_quote')]
final class NotificationTaskProvider implements ScheduleProviderInterface
{
    public function getSchedule(): Schedule
    {
        return new Schedule()
            ->with(
                RecurringMessage::cron(
                    '15 07 * * *',
                    new SendDailyQuote(),
                    new DateTimezone('Europe/Amsterdam')
                )
            );
    }
}
