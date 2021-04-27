<?php

class WPSwiftMailer
{
    public function onInit()
    {
        die('onInit has been called!');
    }

    public function onPluginActivation()
    {
        die('onPluginActivation has been called!');
    }

    public function onPluginDeactivation()
    {
        die('onPluginDeactivation has been called!');
    }
}
