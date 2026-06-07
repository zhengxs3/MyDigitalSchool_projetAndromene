<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * UserSuperpowers Controller
 *
 * @property \App\Model\Table\UserSuperpowersTable $UserSuperpowers
 */
class UserSuperpowersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->UserSuperpowers->find()
            ->contain(['Users', 'Superpowers']);
        $userSuperpowers = $this->paginate($query);

        $this->set(compact('userSuperpowers'));
    }

    /**
     * View method
     *
     * @param string|null $id User Superpower id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $userSuperpower = $this->UserSuperpowers->get($id, contain: ['Users', 'Superpowers']);
        $this->set(compact('userSuperpower'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $userSuperpower = $this->UserSuperpowers->newEmptyEntity();
        if ($this->request->is('post')) {
            $userSuperpower = $this->UserSuperpowers->patchEntity($userSuperpower, $this->request->getData());
            if ($this->UserSuperpowers->save($userSuperpower)) {
                $this->Flash->success(__('The user superpower has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user superpower could not be saved. Please, try again.'));
        }
        $users = $this->UserSuperpowers->Users->find('list', limit: 200)->all();
        $superpowers = $this->UserSuperpowers->Superpowers->find('list', limit: 200)->all();
        $this->set(compact('userSuperpower', 'users', 'superpowers'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User Superpower id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $userSuperpower = $this->UserSuperpowers->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $userSuperpower = $this->UserSuperpowers->patchEntity($userSuperpower, $this->request->getData());
            if ($this->UserSuperpowers->save($userSuperpower)) {
                $this->Flash->success(__('The user superpower has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user superpower could not be saved. Please, try again.'));
        }
        $users = $this->UserSuperpowers->Users->find('list', limit: 200)->all();
        $superpowers = $this->UserSuperpowers->Superpowers->find('list', limit: 200)->all();
        $this->set(compact('userSuperpower', 'users', 'superpowers'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User Superpower id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $userSuperpower = $this->UserSuperpowers->get($id);
        if ($this->UserSuperpowers->delete($userSuperpower)) {
            $this->Flash->success(__('The user superpower has been deleted.'));
        } else {
            $this->Flash->error(__('The user superpower could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
