<?php

namespace common;

class Entity
{
    public $props;
    protected ?int $id;

    public function __construct($props, ?int $id = null)
    {
        $this->id = $id;
        $this->props = $props;
    }

    public function getId(): int
    {
        return $this->id;
    }
}
