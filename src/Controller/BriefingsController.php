<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Briefings Controller
 *
 * @property \App\Model\Table\BriefingsTable $Briefings
 */
class BriefingsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Briefings->find();
        $briefings = $this->paginate($query);

        $this->set(compact('briefings'));
    }

    /**
     * View method
     *
     * @param string|null $id Briefing id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $briefing = $this->Briefings->get($id, contain: ['Decisions', 'Parties']);
        $this->set(compact('briefing'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $briefing = $this->Briefings->newEmptyEntity();
        if ($this->request->is('post')) {
            $briefing = $this->Briefings->patchEntity($briefing, $this->request->getData());
            if ($this->Briefings->save($briefing)) {
                $this->Flash->success(__('The briefing has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The briefing could not be saved. Please, try again.'));
        }
        $this->set(compact('briefing'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Briefing id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $briefing = $this->Briefings->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $briefing = $this->Briefings->patchEntity($briefing, $this->request->getData());
            if ($this->Briefings->save($briefing)) {
                $this->Flash->success(__('The briefing has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The briefing could not be saved. Please, try again.'));
        }
        $this->set(compact('briefing'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Briefing id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $briefing = $this->Briefings->get($id);
        if ($this->Briefings->delete($briefing)) {
            $this->Flash->success(__('The briefing has been deleted.'));
        } else {
            $this->Flash->error(__('The briefing could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
