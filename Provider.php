<?php

namespace TPCraft\BsSocialiteProviderTPCraftIDAC;

use SocialiteProviders\Manager\OAuth2\AbstractProvider;
use SocialiteProviders\Manager\OAuth2\User;

class Provider extends AbstractProvider
{
    /**
     * Unique Provider Identifier.
     */
    const IDENTIFIER = "TPCRAFTIDAC";

    /**
     * {@inheritdoc}
     */
    protected $scopes = [""];

    /**
     * {@inheritdoc}
     */
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase("https://auth.tpcraft.net/oauth2/authorize", $state);
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenUrl()
    {
        return "https://api.tpcraft.net/oauth2/accessToken";
    }

    /**
     * {@inheritdoc}
     */
    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get("https://api.tpcraft.net/oauth2/user", [
            "headers" => [
                "Authorization" => "Bearer " . $token,
            ],
        ]);

        $user = json_decode($response->getBody(), true);

        return $user;
    }

    /**
     * {@inheritdoc}
     */
    protected function mapUserToObject(array $user)
    {
        return (new User())->setRaw($user)->map([
            "id" => $user["data"]["id"],
            "nickname" => $user["data"]["username"],
            "name" => null,
            "email" => $user["data"]["email"],
            'avatar' => null,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenFields($code)
    {
        return array_merge(parent::getTokenFields($code), [
            "grant_type" => "authorization_code"
        ]);
    }
}
