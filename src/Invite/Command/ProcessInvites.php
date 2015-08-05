<?php namespace Anomaly\SlackInviterExtension\Invite\Command;

use Anomaly\SlackInviterExtension\Invite\InviteModel;
use Illuminate\Contracts\Bus\SelfHandling;

/**
 * Class ProcessInvites
 *
 * This needs a HUGE CREDIT as this is entirely adapted from the
 * information found at this website.
 * CREDIT: https://levels.io/slack-typeform-auto-invite-sign-ups/
 *
 * @link          http://www.pyrocms.com
 * @author        Brennon Loveless <brennon.loveless@gmail.com>
 * @package       Anomaly\SlackInviterExtension\Invite\Command
 */
class ProcessInvites implements SelfHandling
{
    public function handle(InviteModel $invites)
    {
        $usersToInvite = $this->getTypeFormResponses($invites);

        $this->inviteUsersToSlack($invites, $usersToInvite);
    }

    private function getTypeFormResponses(InviteModel $invites)
    {
        // Type form configurations
        $typeFormApiKey     = config('anomaly.extension.slack_inviter::type_form.api_key');
        $typeFormFormId     = config('anomaly.extension.slack_inviter::type_form.form_id');
        $typeFormNameField  = config('anomaly.extension.slack_inviter::type_form.name_field');
        $typeFormEmailField = config('anomaly.extension.slack_inviter::type_form.email_field');

        // $offset=count($previouslyInvitedEmails);
        $offset = $invites->count();

        $typeFormApiUrl = 'https://api.typeform.com/v0/form/' . $typeFormFormId . '?key=' . $typeFormApiKey . '&completed=true&offset=' . $offset;

        if (!$typeFormApiResponse = file_get_contents($typeFormApiUrl)) {
            echo "Sorry, can't access API";
            exit;
        }

        $typeFormData = json_decode($typeFormApiResponse, true);

        $usersToInvite = array();

        foreach ($typeFormData['responses'] as $response) {

            $user['type_form_id'] = $response['id'];
            $user['email']        = $response['answers'][$typeFormEmailField];
            $user['name']         = $response['answers'][$typeFormNameField];
            // This is here just as a reminder that it needs to be filled in later
            $user['status'] = '';

            if (!$invites->lists('type_form_id')->contains($response['id'])) {
                array_push($usersToInvite, $user);
            }
        }

        return $usersToInvite;
    }

    private function inviteUsersToSlack(InviteModel $invites, $usersToInvite)
    {
        // Slack configurations
        $slackAuthToken        = config('anomaly.extension.slack_inviter::slack.auth_token');
        $slackHostName         = config('anomaly.extension.slack_inviter::slack.host_name');
        $slackAutoJoinChannels = config('anomaly.extension.slack_inviter::slack.auto_join_channels');

        $slackInviteUrl = 'https://' . $slackHostName . '.slack.com/api/users.admin.invite?t=' . time();

        foreach ($usersToInvite as $user) {

            $fields = array(
                'email'      => urlencode($user['email']),
                'channels'   => urlencode($slackAutoJoinChannels),
                'first_name' => urlencode($user['name']),
                'token'      => $slackAuthToken,
                'set_active' => urlencode('true'),
                '_attempts'  => '1'
            );

            // url-ify the data for the POST
            $fields_string = '';
            foreach ($fields as $key => $value) {
                $fields_string .= $key . '=' . $value . '&';
            }
            rtrim($fields_string, '&');

            // open connection
            $ch = curl_init();

            // set the url, number of POST vars, POST data
            curl_setopt($ch, CURLOPT_URL, $slackInviteUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, count($fields));
            curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);

            // exec
            $replyRaw = curl_exec($ch);
            $reply    = json_decode($replyRaw, true);

            if ($reply['ok'] == false) {
                $user['status'] = 'Error: ' . $reply['error'];
            } else {
                $user['status'] = 'Invited successfully';
            }

            // close connection
            curl_close($ch);

            $invites->create($user);
        }
    }
}