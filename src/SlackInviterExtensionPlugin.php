<?php namespace Anomaly\SlackInviterExtension;

use Anomaly\Streams\Platform\Addon\Plugin\Plugin;

/**
 * Class SlackInviterExtensionPlugin
 *
 * @link          http://www.pyrocms.com
 * @author        Brennon Loveless <brennon.loveless@gmail.com>
 * @package       Anomaly\SlackInviterExtension
 */
class SlackInviterExtensionPlugin extends Plugin
{

    /**
     * The plugin functions.
     *
     * @var SlackInviterExtensionPluginFunctions
     */
    protected $functions;

    /**
     * Create a new SlackInviterExtensionPlugin instance.
     *
     * @param SlackInviterExtensionPluginFunctions $functions
     */
    public function __construct(SlackInviterExtensionPluginFunctions $functions)
    {
        $this->functions = $functions;
    }

    /**
     * Get the plugin functions.
     *
     * @return array
     */
    public function getFunctions()
    {
        return [
            new \Twig_SimpleFunction('slack_invite_form', [$this->functions, 'form'])
        ];
    }
}
