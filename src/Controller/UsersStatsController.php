<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * UsersStats Controller
 *
 * @property \App\Model\Table\UsersStatsTable $UsersStats
 */
class UsersStatsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->UsersStats->find()
            ->contain(['Users']);
        $usersStats = $this->paginate($query);

        $this->set(compact('usersStats'));
    }

    /**
     * View method
     *
     * @param string|null $id Users Stat id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $usersStat = $this->UsersStats->get($id, contain: ['Users']);
        $this->set(compact('usersStat'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $usersStat = $this->UsersStats->newEmptyEntity();
        if ($this->request->is('post')) {
            $usersStat = $this->UsersStats->patchEntity($usersStat, $this->request->getData());
            if ($this->UsersStats->save($usersStat)) {
                $this->Flash->success(__('The users stat has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The users stat could not be saved. Please, try again.'));
        }
        $users = $this->UsersStats->Users->find('list', limit: 200)->all();
        $this->set(compact('usersStat', 'users'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Users Stat id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $usersStat = $this->UsersStats->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $usersStat = $this->UsersStats->patchEntity($usersStat, $this->request->getData());
            if ($this->UsersStats->save($usersStat)) {
                $this->Flash->success(__('The users stat has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The users stat could not be saved. Please, try again.'));
        }
        $users = $this->UsersStats->Users->find('list', limit: 200)->all();
        $this->set(compact('usersStat', 'users'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Users Stat id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $usersStat = $this->UsersStats->get($id);
        if ($this->UsersStats->delete($usersStat)) {
            $this->Flash->success(__('The users stat has been deleted.'));
        } else {
            $this->Flash->error(__('The users stat could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
