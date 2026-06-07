<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * PartyPlayers Controller
 *
 * @property \App\Model\Table\PartyPlayersTable $PartyPlayers
 */
class PartyPlayersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->PartyPlayers->find()
            ->contain(['Users', 'Parties']);
        $partyPlayers = $this->paginate($query);

        $this->set(compact('partyPlayers'));
    }

    /**
     * View method
     *
     * @param string|null $id Party Player id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $partyPlayer = $this->PartyPlayers->get($id, contain: ['Users', 'Parties']);
        $this->set(compact('partyPlayer'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $partyPlayer = $this->PartyPlayers->newEmptyEntity();
        if ($this->request->is('post')) {
            $partyPlayer = $this->PartyPlayers->patchEntity($partyPlayer, $this->request->getData());
            if ($this->PartyPlayers->save($partyPlayer)) {
                $this->Flash->success(__('The party player has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The party player could not be saved. Please, try again.'));
        }
        $users = $this->PartyPlayers->Users->find('list', limit: 200)->all();
        $parties = $this->PartyPlayers->Parties->find('list', limit: 200)->all();
        $this->set(compact('partyPlayer', 'users', 'parties'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Party Player id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $partyPlayer = $this->PartyPlayers->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $partyPlayer = $this->PartyPlayers->patchEntity($partyPlayer, $this->request->getData());
            if ($this->PartyPlayers->save($partyPlayer)) {
                $this->Flash->success(__('The party player has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The party player could not be saved. Please, try again.'));
        }
        $users = $this->PartyPlayers->Users->find('list', limit: 200)->all();
        $parties = $this->PartyPlayers->Parties->find('list', limit: 200)->all();
        $this->set(compact('partyPlayer', 'users', 'parties'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Party Player id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $partyPlayer = $this->PartyPlayers->get($id);
        if ($this->PartyPlayers->delete($partyPlayer)) {
            $this->Flash->success(__('The party player has been deleted.'));
        } else {
            $this->Flash->error(__('The party player could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
