<?php namespace Anomaly\SlackInviterExtension;

use Anomaly\SlackInviterExtension\Invite\Command\ProcessInvites;
use Anomaly\SlackInviterExtension\Invite\Console\Process;
use Anomaly\Streams\Platform\Addon\AddonServiceProvider;

/**
 * Class SlackInviterExtensionServiceProvider
 *
 * @link          http://www.pyrocms.com
 * @author        Brennon Loveless <brennon.loveless@gmail.com>
 * @package       Anomaly\SlackInviterExtension
 */
class SlackInviterExtensionServiceProvider extends AddonServiceProvider
{
    /**
     * Add the process invites class to the scheduler
     *
     * @var array
     */
    protected $schedules = [
        ProcessInvites::class => '10/* * * * *'
    ];

    /**
     * Add the process class to artisan
     *
     * @var array
     */
    protected $commands = [
        'slack:process' => Process::class
    ];
}