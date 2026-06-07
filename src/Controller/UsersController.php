<?php
declare(strict_types=1);

namespace App\Controller;
use Authentication\PasswordHasher\DefaultPasswordHasher;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 */
class UsersController extends AppController
{
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

    public function register()
    {
        $this->request->allowMethod(['post']);

        $user = $this->Users->newEmptyEntity();

        $data = $this->request->getData();
        $data['password'] = (new DefaultPasswordHasher())->hash($data['password']);

        $user = $this->Users->patchEntity($user, $data);

        if ($this->Users->save($user)) {

            return $this->response
                ->withType('application/json')
                ->withStatus(200)
                ->withStringBody(json_encode([
                    'success' => true
                ]));
        }

        return $this->response
            ->withType('application/json')
            ->withStatus(400)
            ->withStringBody(json_encode([
                'success' => false,
                'errors' => $user->getErrors()
            ]));
    }

    public function login()
{
    $this->request->allowMethod(['post']);

    $data = $this->request->getData();

    $user = $this->Users->find()
        ->where([
            'pseudo' => $data['pseudo'] ?? '',
        ])
        ->first();

    if (
        $user &&
        (new DefaultPasswordHasher())->check(
            $data['password'] ?? '',
            $user->password
        )
    ) {
        return $this->response
            ->withType('application/json')
            ->withStringBody(json_encode([
                'success' => true,
                'message' => 'Connexion réussie',
                'user' => $user,
            ]));
    }

    return $this->response
        ->withStatus(401)
        ->withType('application/json')
        ->withStringBody(json_encode([
            'success' => false,
            'message' => 'Pseudo ou mot de passe incorrect',
        ]));
}


    public function logout()
    {
        $this->Authentication->logout();
        return $this->redirect(['controller' => 'Users', 'action' => 'login']);
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
        $user = $this->Users->get($id, contain: []);
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
}
