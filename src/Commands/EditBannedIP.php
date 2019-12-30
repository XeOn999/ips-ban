<?php

/*
 * This file is part of fof/ban-ips.
 *
 * Copyright (c) 2019 FriendsOfFlarum.
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

namespace FoF\BanIPs\Commands;

use Flarum\User\User;

class EditBannedIP
{
    /**
     * @var int
     */
    public $bannedId;

    /**
     * @var User
     */
    public $actor;

    /**
     * @var array
     */
    public $data;

    /**
     * @param int   $bannedId
     * @param User  $actor
     * @param array $data
     */
    public function __construct(User $actor, int $bannedId, array $data)
    {
        $this->actor = $actor;
        $this->bannedId = $bannedId;
        $this->data = $data;
    }
}
