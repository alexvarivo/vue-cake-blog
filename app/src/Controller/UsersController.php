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
    /**
     * Initialize controller
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('Authentication.Authentication');

        // make sure unauthenticated users can access login
        if ($this->request->getParam('action') === 'login' || $this->request->getParam('action') === 'createTestUser') {
            $this->Authentication->allowUnauthenticated(['login', 'createTestUser']);
        }
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Users->find();
        $users = $this->paginate($query);

        $this->set(compact('users'));
    }

    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, contain: ['Articles']);
        $this->set(compact('user'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    /**
     * Login method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful login, renders view otherwise.
     */
    public function login()
    {
        $this->request->allowMethod(['post']);

        // DEBUG
        file_put_contents('/tmp/debug_login_input.txt', json_encode($this->request->getData()));

        $authService = $this->Authentication->getAuthenticationService();
        $result = $authService->authenticate($this->request);
        
        if ($result->isValid()) {
	    $user = $result->getData();
	    
            $payload = [
	        'sub' => $user->id,
		'exp' => time() + 604800, 
	    ];

            $jwt = JWT::encode($payload, Security::getSalt(), 'HS256');

	    return $this->response->withType('application/json')
	        ->withStringBody(json_encode(['token' => $jwt]));
        }

	return $this->response->withStatus(401)
	    ->withType('application/json')
	    ->withStringBody(json_encode(['error' => 'Invalid username or password']));
    }
    
    public function logout()
    {
        $result = $this->Authentication->getResult();
        if ($result->isValid()) {
            $this->Authentication->logout();
            $this->Flash->success(__('You are now logged out.'));
        }

        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
    }
    
    public function createTestUser()
    {
        $this->Users->deleteAll(['username' => 'admin']); // temp

        $existing = $this->Users->find()->where(['username' => 'admin'])->first();
        if ($existing) {
            return $this->response->withStringBody('Test user already exists.');
        }

        $user = $this->Users->newEmptyEntity();
        $user->username = 'admin';
        $user->password = 'admin123'; // will be auto-hashed
        $user->created = $user->modified = date('Y-m-d H:i:s');

        if ($this->Users->save($user)) {
            return $this->response->withStringBody('Test user created successfully.');
        }

        return $this->response->withStringBody('Failed to create test user.');
    }
}
