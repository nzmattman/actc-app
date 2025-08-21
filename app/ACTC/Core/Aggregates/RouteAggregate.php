<?php

declare(strict_types=1);

namespace ACTC\Core\Aggregates;

class RouteAggregate
{
    protected array $routeFiles = [];

    public function addRouteFile($type, $file): self
    {
        if (! isset($this->routeFiles[$type])) {
            $this->routeFiles[$type] = [];
        }

        $this->routeFiles[$type][] = $file;

        return $this;
    }

    public function getRouteFiles(string $type): array
    {
        if (isset($this->routeFiles[$type])) {
            return $this->routeFiles[$type];
        }

        return [];
    }
}
