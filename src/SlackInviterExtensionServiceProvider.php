<?php namespace Anomaly\SlackInviterExtension;

use Anomaly\SlackInviterExtension\Invite\Command\ProcessInvites;
use Anomaly\SlackInviterExtension\Invite\Console\Process;
use Anomaly\Streams\Platform\Addon\AddonServiceProvider;

class SlackInviterExtensionServiceProvider extends AddonServiceProvider
{
    protected $schedules = [
        ProcessInvites::class => '* * * * *'
    ];

    protected $commands = [
        'slack:process' => Process::class
    ];
}