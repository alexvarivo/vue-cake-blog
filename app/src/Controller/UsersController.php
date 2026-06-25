<?php
declare(strict_types=1);

namespace App\Controller;

use Firebase\JWT\JWT;
use Cake\Utility\Security;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->loadComponent('Authentication.Authentication');
        $this->Authentication->allowUnauthenticated(['login']);
    }

    public function login()
    {
        $this->request->allowMethod(['post']);

        $authService = $this->Authentication->getAuthenticationService();
        $result = $authService->authenticate($this->request);

        if ($result->isValid()) {
            $user = $result->getData();
            $payload = [
                'sub' => $user->id,
                'exp' => time() + 604800,
            ];
            $jwt = JWT::encode($payload, Security::getSalt(), 'HS256');

            return $this->response
                ->withType('application/json')
                ->withStringBody(json_encode(['token' => $jwt]));
        }

        return $this->response
            ->withStatus(401)
            ->withType('application/json')
            ->withStringBody(json_encode(['error' => 'Invalid username or password']));
    }
}
