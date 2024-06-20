<?php

namespace DataArkadia\LaravelSettings\Events;

use Illuminate\Support\Str;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class SluggableSaving
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(mixed $sluggable)
    {
        $slug = Str::slug($sluggable->name, '-');

        $sluggable->slug = $slug;
    }
}
