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
    
    public function index()
    {
        $query = $this->PartyPlayers->find()
            ->contain(['Users', 'Parties']);
        $partyPlayers = $this->paginate($query);

        $this->set(compact('partyPlayers'));
    }

    public function view($id = null)
    {
        $partyPlayer = $this->PartyPlayers->get($id, contain: ['Users', 'Parties']);
        $this->set(compact('partyPlayer'));
    }

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

public function updateRole()
{
    $this->request->allowMethod(['patch', 'post', 'put']);
    $this->viewBuilder()->setClassName('Json');

    $data = $this->request->getData();

    $partyId = $data['party_id'] ?? null;
    $userId = $data['user_id'] ?? null;
    $role = $data['role'] ?? null;

    if (!$partyId || !$userId || !$role) {
        $this->set([
            'success' => false,
            'message' => 'Données manquantes',
        ]);
        $this->viewBuilder()->setOption('serialize', ['success', 'message']);
        return;
    }

    $partyPlayer = $this->PartyPlayers->find()
        ->where([
            'party_id' => $partyId,
            'user_id' => $userId,
        ])
        ->first();

    if (!$partyPlayer) {
        $this->set([
            'success' => false,
            'message' => 'Joueur introuvable',
        ]);
        $this->viewBuilder()->setOption('serialize', ['success', 'message']);
        return;
    }

    $partyPlayer->role = $role;

    if ($this->PartyPlayers->save($partyPlayer)) {
        $this->set([
            'success' => true,
            'message' => 'Rôle enregistré',
            'role' => $role,
        ]);
    } else {
        $this->set([
            'success' => false,
            'message' => 'Erreur sauvegarde',
        ]);
    }

    $this->viewBuilder()->setOption('serialize', ['success', 'message', 'role']);
}
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
