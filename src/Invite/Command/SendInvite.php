<?php namespace Anomaly\SlackInviterExtension\Invite\Command;

use Anomaly\SlackInviterExtension\Invite\Event\SlackInviteWasSent;
use Anomaly\SlackInviterExtension\Invite\Form\InviteFormBuilder;
use Anomaly\SlackInviterExtension\Invite\InviteModel;
use Illuminate\Contracts\Bus\SelfHandling;
use Illuminate\Events\Dispatcher;
use Illuminate\Http\Request;

/**
 * Class SendInvite
 *
 * This needs a HUGE CREDIT as this is entirely adapted from the
 * information found at this website.
 * CREDIT: https://levels.io/slack-typeform-auto-invite-sign-ups/
 *
 * @link          http://www.pyrocms.com
 * @author        Brennon Loveless <brennon.loveless@gmail.com>
 * @package       Anomaly\SlackInviterExtension\Invite\Command
 */
class SendInvite implements SelfHandling
{

    /**
     * The form builder.
     *
     * @var InviteFormBuilder
     */
    protected $builder;

    /**
     * Create a new SendInvite instance.
     *
     * @param InviteFormBuilder $builder
     */
    public function __construct(InviteFormBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Handle the command.
     *
     * @param InviteModel $invites
     * @param Request     $request
     * @param Dispatcher  $events
     * @return array
     */
    public function handle(InviteModel $invites, Request $request, Dispatcher $events)
    {
        $user['ip_address'] = $request->ip();

        // Slack configurations
        $slackTeam     = config('anomaly.extension.slack_inviter::slack.team');
        $slackToken    = config('anomaly.extension.slack_inviter::slack.token');
        $slackChannels = config('anomaly.extension.slack_inviter::slack.channels');

        if (!$slackToken) {
            throw new \Exception(
                "Slack API has not been configured. Missing 'anomaly.extension.slack_inviter::slack.auth_token'"
            );
        }

        $slackInviteUrl = 'https://' . $slackTeam . '.slack.com/api/users.admin.invite?t=' . time();

        $fields = array(
            'email'      => $user['email'] = $this->builder->getFormValue('email'),
            'first_name' => urlencode($user['name'] = $this->builder->getFormValue('name')),
            'channels'   => $slackChannels,
            'token'      => $slackToken,
            'set_active' => true,
            '_attempts'  => '1'
        );

        // Open the connection.
        $ch = curl_init();

        // set the url, number of POST vars, POST data
        curl_setopt($ch, CURLOPT_URL, $slackInviteUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, count($fields));
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($fields));

        // Execute the request.
        $reply = json_decode(curl_exec($ch), true);

        if ($reply['ok'] == false) {
            $user['error'] = $reply['error'];
        } else {
            $user['successful'] = true;
        }

        // Close the connection.
        curl_close($ch);

        $events->fire(new SlackInviteWasSent($invites->create($user)));

        return $reply;
    }
}