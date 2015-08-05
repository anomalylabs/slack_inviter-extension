<?php namespace Anomaly\SlackInviterExtension;

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
     * The provided plugins.
     *
     * @var array
     */
    protected $plugins = [
        SlackInviterExtensionPlugin::class
    ];

}