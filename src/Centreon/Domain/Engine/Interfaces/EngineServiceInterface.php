<?php

/*
 * Copyright 2005 - 2020 Centreon (https://www.centreon.com/)
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 *
 * For more information : contact@centreon.com
 *
 */
declare(strict_types=1);

namespace Centreon\Domain\Engine\Interfaces;

use Centreon\Domain\Acknowledgement\Acknowledgement;
use Centreon\Domain\Contact\Interfaces\ContactFilterInterface;
use Centreon\Domain\Downtime\Downtime;
use Centreon\Domain\Check\Check;
use Centreon\Domain\Engine\EngineException;
use Centreon\Domain\Monitoring\Host;
use Centreon\Domain\Monitoring\Service;
use JMS\Serializer\Exception\ValidationFailedException;

interface EngineServiceInterface extends ContactFilterInterface
{
    /**
     * Acknowledge a host.
     *
     * @param Acknowledgement $acknowledgement Acknowledgement to add
     * @param Host $host Host linked to the acknowledgement
     * @throws EngineException
     * @throws \Exception
     * @throws ValidationFailedException
     */
    public function addHostAcknowledgement(Acknowledgement $acknowledgement, Host $host);

    /**
     * Acknowledge a service.
     *
     * @param Acknowledgement $acknowledgement Acknowledgement to add
     * @param Service $service Service linked to the acknowledgement
     * @throws EngineException
     * @throws \Exception
     * @throws ValidationFailedException
     */
    public function addServiceAcknowledgement(Acknowledgement $acknowledgement, Service $service);

    /**
     * Schedules a forced host check.
     *
     * @param Host $host Host for which we want to schedule a forced check
     * @throws EngineException
     * @throws \Exception
     */
    public function scheduleForcedHostCheck(Host $host): void;

    /**
     * Disacknowledge a host.
     *
     * @param Host $host Host to disacknowledge
     * @throws EngineException
     * @throws \Exception
     */
    public function disacknowledgeHost(Host $host): void;

    /**
     * Disacknowledge a service.
     *
     * @param Service $service Service to disacknowledge
     * @throws EngineException
     * @throws \Exception
     */
    public function disacknowledgeService(Service $service): void;

    /**
     * Add a downtime on multiple hosts.
     *
     * @param Downtime $downtime Downtime to add on the host
     * @param Host $hosts Host for which we want to add the downtime
     * @throws \Exception
     */
    public function addHostDowntime(Downtime $downtime, Host $host): void;

    /**
     * Add a downtime on multiple services.
     *
     * @param Downtime $downtime Downtime to add
     * @param Service[] $services Service for which we want to add a downtime
     * @throws \Exception
     */
    public function addServiceDowntime(Downtime $downtime, Service $service): void;

    /**
     * Cancel a downtime.
     *
     * @param Downtime $downtime Downtime to cancel
     * @param Host $host Downtime-related host
     * @throws \Exception
     */
    public function cancelDowntime(Downtime $downtime, Host $host): void;

    /**
     * Schedule a host check.
     *
     * @param Check $check Check to schedule
     * @param Host $host Host on which check is scheduled
     * @throws \Exception
     */
    public function scheduleHostCheck(Check $check, Host $host): void;

    /**
     * Schedule a service check.
     *
     * @param Check $check Check to schedule
     * @param Service $service Service on which check is scheduled
     * @throws \Exception
     */
    public function scheduleServiceCheck(Check $check, Service $service): void;
}
