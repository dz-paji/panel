<?php
/**
 * Pterodactyl - Panel
 * Copyright (c) 2015 - 2017 Dane Everitt <dane@daneeveritt.com>.
 *
 * This software is licensed under the terms of the MIT license.
 * https://opensource.org/licenses/MIT
 */

namespace Pterodactyl\Services\Services\Options;

use Pterodactyl\Models\Egg;
use Pterodactyl\Contracts\Repository\EggRepositoryInterface;

class OptionConfigurationFileService
{
    protected $repository;

    /**
     * OptionConfigurationFileService constructor.
     *
     * @param \Pterodactyl\Contracts\Repository\EggRepositoryInterface $repository
     */
    public function __construct(EggRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Return a service configuration file to be used by the daemon.
     *
     * @param int|\Pterodactyl\Models\Egg $option
     * @return array
     *
     * @throws \Pterodactyl\Exceptions\Repository\RecordNotFoundException
     */
    public function handle($option): array
    {
        if (! $option instanceof Egg) {
            $option = $this->repository->getWithCopyAttributes($option);
        }

        return [
            'startup' => json_decode($option->inherit_config_startup),
            'stop' => $option->inherit_config_stop,
            'configs' => json_decode($option->inherit_config_files),
            'log' => json_decode($option->inherit_config_logs),
            'query' => 'none',
        ];
    }
}
