<?php

namespace LibreNMS\Authentication;

use LibreNMS\Config;
use LibreNMS\Exceptions\AuthenticationException;

class NssPamAuthorizer extends AuthorizerBase
{
    protected static bool $HAS_AUTH_USERMANAGEMENT = true;
    protected static bool $CAN_UPDATE_USER = false;
    protected static bool $CAN_UPDATE_PASSWORDS = false;
    protected static bool $AUTH_IS_EXTERNAL = false;

    public function authenticate($credentials)
    {
        $username = $credentials['username'] ?? null;
        $password = $credentials['password'] ?? null;
        $service = 'librenms'; // default to librenms if not set
        if (Config::has('nss_pam_auth_service')) {
            $service = Config::get('nss_pam_auth_service');
        }

        if (pam_auth($username, $password, $error, true, $service)) {
            return true;
        }

        throw new AuthenticationException($error . '... Likely user does not exist');
    }

    public function canUpdatePasswords($username = '')
    {
        return false;
    }

    public function userExists($username, $throw_exception = false)
    {
        if (posix_getpwnam($username)) {
            return true;
        }

        return false;
    }

    public function getUserlevel($username)
    {
        if (Config::has('nss_pam_admin_group')) {
            $group = Config::get('nss_pam_admin_group');
            $groupinfo = posix_getgrnam($group);
            if ($groupinfo) {
                foreach ($groupinfo['members'] as $member) {
                    if ($member == $username) {
                        return 10;
                    }
                }
            }
        }

        if (Config::has('nss_pam_normal_group')) {
            $group = Config::get('nss_pam_normal_group');
            $groupinfo = posix_getgrnam($group);
            if ($groupinfo) {
                foreach ($groupinfo['members'] as $member) {
                    if ($member == $username) {
                        return 1;
                    }
                }
            }
        }

        return 0;
    }

    public function getUserid($username)
    {
        if (is_null($username)) {
            return -1;
        }
        $userinfo = posix_getpwnam($username);
        if ($userinfo) {
            return $userinfo['uid'];
        }

        return -1;
    }

    public function getUserlist()
    {
        $userlist = [];

        if (Config::has('nss_pam_admin_group')) {
            $group = Config::get('nss_pam_admin_group');
            $groupinfo = posix_getgrnam($group);
            if ($groupinfo) {
                foreach ($groupinfo['members'] as $member) {
                    $userinfo = posix_getpwnam($member);
                    if ($userinfo) {
                        $userlist[$member] = [
                            'user_id' => $userinfo['uid'],
                            'username' => $userinfo['name'],
                            'auth_type' => 'nss_pam',
                            'realname' => $userinfo['gecos'],
                            'level' => 10,
                            'email' => '',
                            'can_modify_passwd' => 0,
                            'updated_at' => '',
                            'created_at' => '',
                            'enabled' => 1,
                        ];
                    }
                }
            }
        }

        if (Config::has('nss_pam_normal_group')) {
            $group = Config::get('nss_pam_normal_group');
            $groupinfo = posix_getgrnam($group);
            if ($groupinfo) {
                foreach ($groupinfo['members'] as $member) {
                    $userinfo = posix_getpwnam($member);
                    if ($userinfo && ! isset($userlist[$member])) {
                        $userlist[$member] = [
                            'user_id' => $userinfo['uid'],
                            'username' => $userinfo['name'],
                            'auth_type' => 'nss_pam',
                            'realname' => $userinfo['gecos'],
                            'level' => 1,
                            'email' => '',
                            'can_modify_passwd' => 0,
                            'updated_at' => '',
                            'created_at' => '',
                            'enabled' => 1,
                        ];
                    }
                }
            }
        }

        $user_array = [];
        foreach ($userlist as $user) {
            $user_array[] = $user;
        }

        return $user_array;
    }

    public function getUser($user_id)
    {
        if (is_null($user_id)) {
            return false;
        }
        $userinfo = posix_getpwuid($user_id);
        if ($userinfo) {
            $to_return = [
                'user_id' => $userinfo['uid'],
                'username' => $userinfo['name'],
                'auth_type' => 'nss_pam',
                'realname' => $userinfo['gecos'],
                'email' => '',
                'level' => $this->getUserlevel($userinfo['name']),
                'can_modify_passwd' => 0,
                'updated_at' => '',
                'created_at' => '',
                'enabled' => 1,
            ];

            return $to_return;
        }

        return false;
    }
}
