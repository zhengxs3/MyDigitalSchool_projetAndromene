<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Parties Controller
 *
 * @property \App\Model\Table\PartiesTable $Parties
 */
class PartiesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Parties->find()
            ->contain(['Briefings', 'Rooms']);
        $parties = $this->paginate($query);

        $this->set(compact('parties'));
    }

    /**
     * View method
     *
     * @param string|null $id Party id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $party = $this->Parties->get($id, contain: ['Briefings', 'Rooms', 'PartyPlayers', 'PlayerDecisions']);
        $this->set(compact('party'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $party = $this->Parties->newEmptyEntity();
        if ($this->request->is('post')) {
            $party = $this->Parties->patchEntity($party, $this->request->getData());
            if ($this->Parties->save($party)) {
                $this->Flash->success(__('The party has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The party could not be saved. Please, try again.'));
        }
        $briefings = $this->Parties->Briefings->find('list', limit: 200)->all();
        $rooms = $this->Parties->Rooms->find('list', limit: 200)->all();
        $this->set(compact('party', 'briefings', 'rooms'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Party id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $party = $this->Parties->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $party = $this->Parties->patchEntity($party, $this->request->getData());
            if ($this->Parties->save($party)) {
                $this->Flash->success(__('The party has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The party could not be saved. Please, try again.'));
        }
        $briefings = $this->Parties->Briefings->find('list', limit: 200)->all();
        $rooms = $this->Parties->Rooms->find('list', limit: 200)->all();
        $this->set(compact('party', 'briefings', 'rooms'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Party id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $party = $this->Parties->get($id);
        if ($this->Parties->delete($party)) {
            $this->Flash->success(__('The party has been deleted.'));
        } else {
            $this->Flash->error(__('The party could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
