<?php

/*
 * This file is part of fof/ban-ips.
 *
 * Copyright (c) 2019 FriendsOfFlarum.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace FoF\BanIPs\Listeners;

use Flarum\Http\SessionAuthenticator;
use Flarum\User\User;
use FoF\BanIPs\Events\IPWasBanned;
use FoF\BanIPs\Repositories\BannedIPRepository;
use Illuminate\Events\Dispatcher;

class RemoveAccessToBannedUsers
{
    /**
     * @var BannedIPRepository
     */
    private $bannedIPs;

    /**
     * @var SessionAuthenticator
     */
    private $authenticator;

    public function __construct(SessionAuthenticator $authenticator, BannedIPRepository $bannedIPs)
    {
        $this->authenticator = $authenticator;
        $this->bannedIPs = $bannedIPs;
    }

    /**
     * Subscribes to the Flarum events.
     *
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen(IPWasBanned::class, [$this, 'removeAccess']);
    }

    public function removeAccess(IPWasBanned $event)
    {
        $bannedIP = $event->bannedIP;
        $users = $this->bannedIPs->findUsers($bannedIP->address);

        foreach ($users as $user) {
            /*
             * @var User $user
             */
            $user->accessTokens()->delete();
        }
    }
}
