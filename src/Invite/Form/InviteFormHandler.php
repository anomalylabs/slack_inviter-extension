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
     * @param MessageBag $messages
     */
    public function handle(InviteFormBuilder $builder, MessageBag $messages)
    {
        // Validation failed!
        if ($builder->hasFormErrors()) {
            return;
        }

        $reply = $this->dispatch(new SendInvite($builder));

        if (array_get($reply, 'ok') === true) {
            $messages->success('anomaly.extension.slack_inviter::success.send_invite');
        } else {
            $messages->error('anomaly.extension.slack_inviter::error.send_invite');
            $messages->error('anomaly.extension.slack_inviter::error.' . $reply['error']);
        }

        // Clear the form!
        $builder->resetForm();
    }
}
