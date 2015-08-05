<?php namespace Anomaly\SlackInviterExtension\Invite\Console;

use Anomaly\SlackInviterExtension\Invite\Command\ProcessInvites;
use Illuminate\Console\Command;
use Illuminate\Foundation\Bus\DispatchesJobs;

class Process extends Command
{
    use DispatchesJobs;

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'slack:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get slack invites from type form and auto-invite them.';

    /**
     * Execute the console command
     */
    public function fire()
    {
        $this->dispatch(new ProcessInvites());
    }
}