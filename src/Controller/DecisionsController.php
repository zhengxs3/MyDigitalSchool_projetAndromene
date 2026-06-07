<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Decisions Controller
 *
 * @property \App\Model\Table\DecisionsTable $Decisions
 */
class DecisionsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Decisions->find()
            ->contain(['Briefings']);
        $decisions = $this->paginate($query);

        $this->set(compact('decisions'));
    }

    /**
     * View method
     *
     * @param string|null $id Decision id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $decision = $this->Decisions->get($id, contain: ['Briefings', 'PlayerDecisions']);
        $this->set(compact('decision'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $decision = $this->Decisions->newEmptyEntity();
        if ($this->request->is('post')) {
            $decision = $this->Decisions->patchEntity($decision, $this->request->getData());
            if ($this->Decisions->save($decision)) {
                $this->Flash->success(__('The decision has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The decision could not be saved. Please, try again.'));
        }
        $briefings = $this->Decisions->Briefings->find('list', limit: 200)->all();
        $this->set(compact('decision', 'briefings'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Decision id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $decision = $this->Decisions->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $decision = $this->Decisions->patchEntity($decision, $this->request->getData());
            if ($this->Decisions->save($decision)) {
                $this->Flash->success(__('The decision has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The decision could not be saved. Please, try again.'));
        }
        $briefings = $this->Decisions->Briefings->find('list', limit: 200)->all();
        $this->set(compact('decision', 'briefings'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Decision id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $decision = $this->Decisions->get($id);
        if ($this->Decisions->delete($decision)) {
            $this->Flash->success(__('The decision has been deleted.'));
        } else {
            $this->Flash->error(__('The decision could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
