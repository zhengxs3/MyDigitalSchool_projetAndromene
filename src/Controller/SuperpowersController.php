<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Superpowers Controller
 *
 * @property \App\Model\Table\SuperpowersTable $Superpowers
 */
class SuperpowersController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Superpowers->find();
        $superpowers = $this->paginate($query);

        $this->set(compact('superpowers'));
    }

    /**
     * View method
     *
     * @param string|null $id Superpower id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $superpower = $this->Superpowers->get($id, contain: ['UserSuperpowers']);
        $this->set(compact('superpower'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $superpower = $this->Superpowers->newEmptyEntity();
        if ($this->request->is('post')) {
            $superpower = $this->Superpowers->patchEntity($superpower, $this->request->getData());
            if ($this->Superpowers->save($superpower)) {
                $this->Flash->success(__('The superpower has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The superpower could not be saved. Please, try again.'));
        }
        $this->set(compact('superpower'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Superpower id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $superpower = $this->Superpowers->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $superpower = $this->Superpowers->patchEntity($superpower, $this->request->getData());
            if ($this->Superpowers->save($superpower)) {
                $this->Flash->success(__('The superpower has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The superpower could not be saved. Please, try again.'));
        }
        $this->set(compact('superpower'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Superpower id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $superpower = $this->Superpowers->get($id);
        if ($this->Superpowers->delete($superpower)) {
            $this->Flash->success(__('The superpower has been deleted.'));
        } else {
            $this->Flash->error(__('The superpower could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
