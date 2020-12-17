class EventServiceProvider extends ServiceProvider
{
    // In real life scenarios,
    //  we'd automatically resolve and cache all subscribers
    //  instead of using a manual array.
    private array $subscribers = [
        ProductSubscriber::class,
    ];

    public function register(): void
    {
        // The event dispatcher is resolved from the container
        $eventDispatcher = $this->app->make(EventDispatcher::class);

        foreach ($this->subscribers as $subscriber) {
            // We'll resolve all listeners registered
            //  in the subscriber class,
            //  and add them to the dispatcher.
            foreach (
                $this->resolveListeners($subscriber)
                as [$event, $listener]
            ) {
                $eventDispatcher->listen($event, $listener);
            }
        }
    }
}