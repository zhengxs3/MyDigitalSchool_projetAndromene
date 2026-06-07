<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * PlayerDecisions Controller
 *
 * @property \App\Model\Table\PlayerDecisionsTable $PlayerDecisions
 */
class PlayerDecisionsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->PlayerDecisions->find()
            ->contain(['Users', 'Decisions', 'Parties']);
        $playerDecisions = $this->paginate($query);

        $this->set(compact('playerDecisions'));
    }

    /**
     * View method
     *
     * @param string|null $id Player Decision id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $playerDecision = $this->PlayerDecisions->get($id, contain: ['Users', 'Decisions', 'Parties']);
        $this->set(compact('playerDecision'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $playerDecision = $this->PlayerDecisions->newEmptyEntity();
        if ($this->request->is('post')) {
            $playerDecision = $this->PlayerDecisions->patchEntity($playerDecision, $this->request->getData());
            if ($this->PlayerDecisions->save($playerDecision)) {
                $this->Flash->success(__('The player decision has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The player decision could not be saved. Please, try again.'));
        }
        $users = $this->PlayerDecisions->Users->find('list', limit: 200)->all();
        $decisions = $this->PlayerDecisions->Decisions->find('list', limit: 200)->all();
        $parties = $this->PlayerDecisions->Parties->find('list', limit: 200)->all();
        $this->set(compact('playerDecision', 'users', 'decisions', 'parties'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Player Decision id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $playerDecision = $this->PlayerDecisions->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $playerDecision = $this->PlayerDecisions->patchEntity($playerDecision, $this->request->getData());
            if ($this->PlayerDecisions->save($playerDecision)) {
                $this->Flash->success(__('The player decision has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The player decision could not be saved. Please, try again.'));
        }
        $users = $this->PlayerDecisions->Users->find('list', limit: 200)->all();
        $decisions = $this->PlayerDecisions->Decisions->find('list', limit: 200)->all();
        $parties = $this->PlayerDecisions->Parties->find('list', limit: 200)->all();
        $this->set(compact('playerDecision', 'users', 'decisions', 'parties'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Player Decision id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $playerDecision = $this->PlayerDecisions->get($id);
        if ($this->PlayerDecisions->delete($playerDecision)) {
            $this->Flash->success(__('The player decision has been deleted.'));
        } else {
            $this->Flash->error(__('The player decision could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
