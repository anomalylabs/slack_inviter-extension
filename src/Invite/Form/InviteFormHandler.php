<?php namespace Anomaly\SlackInviterExtension\Invite\Form;

use Anomaly\SlackInviterExtension\Invite\Command\SendInvite;
use Anomaly\Streams\Platform\Message\MessageBag;
use Illuminate\Foundation\Bus\DispatchesJobs;

/**
 * Class InviteFormHandler
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\SlackInviterExtension\Invite\Form
 */
class InviteFormHandler
{

    use DispatchesJobs;

    /**
     * Handle the command.
     *
     * @param InviteFormBuilder $builder
     * @param MessageBag        $messages
     */
    public function handle(InviteFormBuilder $builder, MessageBag $messages)
    {
        // Validation failed!
        if ($builder->hasFormErrors()) {
            return;
        }

        $this->dispatch(new SendInvite($builder));

        $messages->success('Your invitation has been sent!');

        // Clear the form!
        $builder->resetForm();
    }
}
