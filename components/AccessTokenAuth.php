<?php

namespace app\components;

use yii\filters\auth\AuthMethod;

/**
 * ```php
 * public function behaviors()
 * {
 *     return [
 *         'authenticator' => [
 *             'class' => \app\components\AccessTokenAuth::class,
 *         ],
 *     ];
 * }
 * ```
 */
class AccessTokenAuth extends AuthMethod
{
    /**  @var string Authorization header key */
    public $header = 'Authorization';

    /**  @var string Authorization header schema */
    public $schema = 'Bearer';

    /**
     * @inheritdoc
     */
    public function authenticate($user, $request, $response)
    {
        $authHeader = $request->getHeaders()->get($this->header);
        if ($authHeader !== null && preg_match('/^' . $this->schema . '\s+(.*?)$/', $authHeader, $matches))
        {
            $token = $matches[1];
            if ($token === null)
                return null;

            return $user->loginByAccessToken($token, get_class($this));
        }
        return null;
    }
}
