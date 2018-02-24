<?php

namespace Wuethrich44\SSO\Listener;

use Flarum\Event\UserWasRegistered;
use Illuminate\Contracts\Events\Dispatcher;
use Flarum\Event\ConfigureForumRoutes;
use Flarum\Event\ConfigureMiddleware;
use Wuethrich44\SSO\Middleware;
use Flarum\Foundation\Application;
use Flarum\Http\Middleware\StartSession;
use ReflectionProperty;


class AlterMiddlewareSession
{

    protected $app;

    public function __construct(Application $app)
    {
        $this->app = $app;
    }
    
    
    public function subscribe(Dispatcher $events)
    {
        $events->listen(ConfigureMiddleware::class, [$this, 'ConfigureMiddleware']);
    }

    /**
     * @param ConfigureMiddleware $event
     */
    public function ConfigureMiddleware(ConfigureMiddleware $event)
    { 

        $app = $this->app;

        $r = new ReflectionProperty($event->pipe, 'pipeline');
        $r->setAccessible(true);

        $queue = $r->getValue($event->pipe);

        $event->pipe->pipe($event->path, $app->make('Wuethrich44\SSO\Middleware\StartSession'));
        $pipe_count =  $queue->count();
        $new_zend_route = ($queue->offsetGet($pipe_count-1));

        for ($i = 0 ; $i < $pipe_count ; $i ++) {
            if($queue->offsetGet($i)->handler instanceof StartSession)
            {
                 $queue->offsetSet($i, $new_zend_route);
                 $queue->pop();
                 break;
            }
        }

    }

}
