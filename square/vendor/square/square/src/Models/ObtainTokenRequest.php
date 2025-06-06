<?php

declare(strict_types=1);

namespace Square\Models;

use stdClass;

class ObtainTokenRequest implements \JsonSerializable
{
    /**
     * @var string
     */
    private $clientId;

    /**
     * @var string
     */
    private $clientSecret;

    /**
     * @var string|null
     */
    private $code;

    /**
     * @var string|null
     */
    private $redirectUri;

    /**
     * @var string
     */
    private $grantType;

    /**
     * @var string|null
     */
    private $refreshToken;

    /**
     * @var string|null
     */
    private $migrationToken;

    /**
     * @var string[]|null
     */
    private $scopes;

    /**
     * @var bool|null
     */
    private $shortLived;

    /**
     * @var string|null
     */
    private $codeVerifier;

    /**
     * @param string $clientId
     * @param string $clientSecret
     * @param string $grantType
     */
    public function __construct(string $clientId, string $clientSecret, string $grantType)
    {
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->grantType = $grantType;
    }

    /**
     * Returns Client Id.
     * The Square-issued ID of your application, which is available in the OAuth page in the
     * [Developer Dashboard](https://developer.squareup.com/apps).
     */
    public function getClientId(): string
    {
        return $this->clientId;
    }

    /**
     * Sets Client Id.
     * The Square-issued ID of your application, which is available in the OAuth page in the
     * [Developer Dashboard](https://developer.squareup.com/apps).
     *
     * @required
     * @maps client_id
     */
    public function setClientId(string $clientId): void
    {
        $this->clientId = $clientId;
    }

    /**
     * Returns Client Secret.
     * The Square-issued application secret for your application, which is available in the OAuth page
     * in the [Developer Dashboard](https://developer.squareup.com/apps).
     */
    public function getClientSecret(): string
    {
        return $this->clientSecret;
    }

    /**
     * Sets Client Secret.
     * The Square-issued application secret for your application, which is available in the OAuth page
     * in the [Developer Dashboard](https://developer.squareup.com/apps).
     *
     * @required
     * @maps client_secret
     */
    public function setClientSecret(string $clientSecret): void
    {
        $this->clientSecret = $clientSecret;
    }

    /**
     * Returns Code.
     * The authorization code to exchange.
     * This code is required if `grant_type` is set to `authorization_code` to indicate that
     * the application wants to exchange an authorization code for an OAuth access token.
     */
    public function getCode(): ?string
    {
        return $this->code;
    }

    /**
     * Sets Code.
     * The authorization code to exchange.
     * This code is required if `grant_type` is set to `authorization_code` to indicate that
     * the application wants to exchange an authorization code for an OAuth access token.
     *
     * @maps code
     */
    public function setCode(?string $code): void
    {
        $this->code = $code;
    }

    /**
     * Returns Redirect Uri.
     * The redirect URL assigned in the OAuth page for your application in the [Developer Dashboard](https:
     * //developer.squareup.com/apps).
     */
    public function getRedirectUri(): ?string
    {
        return $this->redirectUri;
    }

    /**
     * Sets Redirect Uri.
     * The redirect URL assigned in the OAuth page for your application in the [Developer Dashboard](https:
     * //developer.squareup.com/apps).
     *
     * @maps redirect_uri
     */
    public function setRedirectUri(?string $redirectUri): void
    {
        $this->redirectUri = $redirectUri;
    }

    /**
     * Returns Grant Type.
     * Specifies the method to request an OAuth access token.
     * Valid values are `authorization_code`, `refresh_token`, and `migration_token`.
     */
    public function getGrantType(): string
    {
        return $this->grantType;
    }

    /**
     * Sets Grant Type.
     * Specifies the method to request an OAuth access token.
     * Valid values are `authorization_code`, `refresh_token`, and `migration_token`.
     *
     * @required
     * @maps grant_type
     */
    public function setGrantType(string $grantType): void
    {
        $this->grantType = $grantType;
    }

    /**
     * Returns Refresh Token.
     * A valid refresh token for generating a new OAuth access token.
     *
     * A valid refresh token is required if `grant_type` is set to `refresh_token`
     * to indicate that the application wants a replacement for an expired OAuth access token.
     */
    public function getRefreshToken(): ?string
    {
        return $this->refreshToken;
    }

    /**
     * Sets Refresh Token.
     * A valid refresh token for generating a new OAuth access token.
     *
     * A valid refresh token is required if `grant_type` is set to `refresh_token`
     * to indicate that the application wants a replacement for an expired OAuth access token.
     *
     * @maps refresh_token
     */
    public function setRefreshToken(?string $refreshToken): void
    {
        $this->refreshToken = $refreshToken;
    }

    /**
     * Returns Migration Token.
     * A legacy OAuth access token obtained using a Connect API version prior
     * to 2019-03-13. This parameter is required if `grant_type` is set to
     * `migration_token` to indicate that the application wants to get a replacement
     * OAuth access token. The response also returns a refresh token.
     * For more information, see [Migrate to Using Refresh Tokens](https://developer.squareup.
     * com/docs/oauth-api/migrate-to-refresh-tokens).
     */
    public function getMigrationToken(): ?string
    {
        return $this->migrationToken;
    }

    /**
     * Sets Migration Token.
     * A legacy OAuth access token obtained using a Connect API version prior
     * to 2019-03-13. This parameter is required if `grant_type` is set to
     * `migration_token` to indicate that the application wants to get a replacement
     * OAuth access token. The response also returns a refresh token.
     * For more information, see [Migrate to Using Refresh Tokens](https://developer.squareup.
     * com/docs/oauth-api/migrate-to-refresh-tokens).
     *
     * @maps migration_token
     */
    public function setMigrationToken(?string $migrationToken): void
    {
        $this->migrationToken = $migrationToken;
    }

    /**
     * Returns Scopes.
     * A JSON list of strings representing the permissions that the application is requesting.
     * For example, "`["MERCHANT_PROFILE_READ","PAYMENTS_READ","BANK_ACCOUNTS_READ"]`".
     *
     * The access token returned in the response is granted the permissions
     * that comprise the intersection between the requested list of permissions and those
     * that belong to the provided refresh token.
     *
     * @return string[]|null
     */
    public function getScopes(): ?array
    {
        return $this->scopes;
    }

    /**
     * Sets Scopes.
     * A JSON list of strings representing the permissions that the application is requesting.
     * For example, "`["MERCHANT_PROFILE_READ","PAYMENTS_READ","BANK_ACCOUNTS_READ"]`".
     *
     * The access token returned in the response is granted the permissions
     * that comprise the intersection between the requested list of permissions and those
     * that belong to the provided refresh token.
     *
     * @maps scopes
     *
     * @param string[]|null $scopes
     */
    public function setScopes(?array $scopes): void
    {
        $this->scopes = $scopes;
    }

    /**
     * Returns Short Lived.
     * A Boolean indicating a request for a short-lived access token.
     *
     * The short-lived access token returned in the response expires in 24 hours.
     */
    public function getShortLived(): ?bool
    {
        return $this->shortLived;
    }

    /**
     * Sets Short Lived.
     * A Boolean indicating a request for a short-lived access token.
     *
     * The short-lived access token returned in the response expires in 24 hours.
     *
     * @maps short_lived
     */
    public function setShortLived(?bool $shortLived): void
    {
        $this->shortLived = $shortLived;
    }

    /**
     * Returns Code Verifier.
     * Must be provided when using PKCE OAuth flow. The `code_verifier` will be used to verify against the
     * `code_challenge` associated with the `authorization_code`.
     */
    public function getCodeVerifier(): ?string
    {
        return $this->codeVerifier;
    }

    /**
     * Sets Code Verifier.
     * Must be provided when using PKCE OAuth flow. The `code_verifier` will be used to verify against the
     * `code_challenge` associated with the `authorization_code`.
     *
     * @maps code_verifier
     */
    public function setCodeVerifier(?string $codeVerifier): void
    {
        $this->codeVerifier = $codeVerifier;
    }

    /**
     * Encode this object to JSON
     *
     * @param bool $asArrayWhenEmpty Whether to serialize this model as an array whenever no fields
     *        are set. (default: false)
     *
     * @return array|stdClass
     */
    #[\ReturnTypeWillChange] // @phan-suppress-current-line PhanUndeclaredClassAttribute for (php < 8.1)
    public function jsonSerialize(bool $asArrayWhenEmpty = false)
    {
        $json = [];
        $json['client_id']           = $this->clientId;
        $json['client_secret']       = $this->clientSecret;
        if (isset($this->code)) {
            $json['code']            = $this->code;
        }
        if (isset($this->redirectUri)) {
            $json['redirect_uri']    = $this->redirectUri;
        }
        $json['grant_type']          = $this->grantType;
        if (isset($this->refreshToken)) {
            $json['refresh_token']   = $this->refreshToken;
        }
        if (isset($this->migrationToken)) {
            $json['migration_token'] = $this->migrationToken;
        }
        if (isset($this->scopes)) {
            $json['scopes']          = $this->scopes;
        }
        if (isset($this->shortLived)) {
            $json['short_lived']     = $this->shortLived;
        }
        if (isset($this->codeVerifier)) {
            $json['code_verifier']   = $this->codeVerifier;
        }
        $json = array_filter($json, function ($val) {
            return $val !== null;
        });

        return (!$asArrayWhenEmpty && empty($json)) ? new stdClass() : $json;
    }
}
