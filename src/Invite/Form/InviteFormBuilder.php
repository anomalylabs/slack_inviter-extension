<?php namespace Anomaly\SlackInviterExtension\Invite\Form;

use Anomaly\Streams\Platform\Ui\Form\FormBuilder;

/**
 * Class InviteFormBuilder
 *
 * @link          http://anomaly.is/streams-platform
 * @author        AnomalyLabs, Inc. <hello@anomaly.is>
 * @author        Ryan Thompson <ryan@anomaly.is>
 * @package       Anomaly\SlackInviterExtension\Invite\Form
 */
class InviteFormBuilder extends FormBuilder
{

    /**
     * The form handler.
     *
     * @var InviteFormHandler
     */
    protected $handler = InviteFormHandler::class;

    /**
     * The form fields.
     *
     * @var array
     */
    protected $fields = [
        'name'  => [
            'name'     => 'anomaly.extension.slack_inviter::field.name.name',
            'type'     => 'anomaly.field_type.name',
            'required' => true
        ],
        'email' => [
            'name'     => 'anomaly.extension.slack_inviter::field.email.name',
            'type'     => 'anomaly.field_type.email',
            'required' => true
        ]
    ];

    /**
     * The form actions.
     *
     * @var array
     */
    protected $actions = [
        'submit'
    ];

    /**
     * The form options.
     *
     * @var array
     */
    protected $options = [
        'success_message' => false
    ];

}
