<?php

declare(strict_types=1);

namespace App;

trait AccessPropertyTrait
{
    /**
     * Getter magic.
     *
     * @param string $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        return $this->{$name};
    }

    /**
     * Setter magic.
     *
     * @param string $name
     * @param mixed  $value
     *
     * @return self
     */
    public function __set($name, $value)
    {
        $this->{$name} = $value;

        return $this;
    }

    /**
     * Isset magic.
     *
     * @param string $name
     *
     * @return bool
     */
    public function __isset($name)
    {
        return property_exists($this, $name);
    }

    public function getId(): int
    {
        return $this->id;
    }
}
