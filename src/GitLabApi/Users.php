<?php

declare(strict_types=1);

namespace AdamReece\GitLabCeLdapSync\GitLabApi;

use Gitlab\Api\Users as BaseUsers;

/**
 * Extension of the GitLab users API, to support query parameters of which the client library doesn't know about.
 *
 * @author  Adam "Adambean" Reece
 * @link    https://github.com/Adambean/gitlab-ce-ldap-sync
 * @license Apache License 2.0
 */
class Users extends BaseUsers
{
    /**
     * Get all users, excluding bot and internal users.
     *
     * Internal users, such as the placeholder and import users created by the migration feature, are not bots, so the
     * "bot" property of a user cannot be relied upon to identify them. GitLab refuses to block internal users, hence
     * they must be left out of the synchronisation entirely.
     *
     * The "humans" parameter requires GitLab 17.7 or later. Older instances silently ignore it, so callers must still
     * be able to cope with bot and internal users being returned.
     *
     * @link https://docs.gitlab.com/api/users/#as-an-administrator
     *
     * @param array<string, scalar> $parameters
     */
    public function allHumans(array $parameters = []): mixed
    {
        return $this->get("users", array_merge($parameters, ["humans" => "true"]));
    }
}
