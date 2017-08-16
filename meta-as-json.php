<?php
namespace Grav\Plugin;

use Grav\Common\Plugin;

class metaAsJsonPlugin extends Plugin
{
    /**
     * Subscribe to required events
     * 
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            'onTwigTemplatePaths' => ['onTwigTemplatePaths', 0],
            'onGetPageTemplates' => ['onGetPageTemplates', 0]
        ];
    }

    /**
     * Add current directory to twig lookup paths.
     */
    public function onTwigTemplatePaths()
    {
        // Don't proceed if we are in the admin
        if ($this->isAdmin()) {
            return;
        }

        array_unshift($this->grav['twig']->twig_paths, __DIR__ . '/templates');
    }

    public function onGetPageTemplates($event)
    {
        $types = $event->types;
        $locator = $this->grav['locator'];
        $types->scanBlueprints($locator->findResource('plugin://' . $this->name . '/blueprints'));
        $types->scanTemplates($locator->findResource('plugin://' . $this->name . '/templates'));
    }
}