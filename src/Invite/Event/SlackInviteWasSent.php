<?php namespace Anomaly\SlackInviterExtension\Invite\Event;

use Anomaly\SlackInviterExtension\Invite\Contract\InviteInterface;

/**
 * Class SlackInviteWasSent
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\SlackInviterExtension\Invite\Event
 */
class SlackInviteWasSent
{

    /**
     * The slack invite.
     *
     * @var InviteInterface
     */
    protected $invite;

    /**
     * Create a new SlackInviteWasSent instance.
     *
     * @param InviteInterface $invite
     */
    public function __construct(InviteInterface $invite)
    {
        $this->invite = $invite;
    }

    /**
     * Get the invite.
     *
     * @return InviteInterface
     */
    public function getInvite()
    {
        return $this->invite;
    }
}
