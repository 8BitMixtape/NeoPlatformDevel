<?php

namespace Wuethrich44\SSO\Listener;

use Flarum\Event\UserWasRegistered;
use Illuminate\Contracts\Events\Dispatcher;
use Flarum\Event\ConfigureForumRoutes;

class AddLogoutWithoutToken
{
    public function subscribe(Dispatcher $events)
    {
        $events->listen(ConfigureForumRoutes::class, [$this, 'configureForumRoutes']);
    }

    /**
     * @param ConfigureForumRoutes $event
     */
    public function configureForumRoutes(ConfigureForumRoutes $event)
    { 
        $event->get('/forcelogout', 'auth.forcelogout', 'Wuethrich44\SSO\Controller\ForcseLogoutController');
    }


}
