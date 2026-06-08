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
    
    public function random()
    {
        $this->request->allowMethod(['get']);

        $briefing = $this->Briefings
            ->find()
            ->order('RAND()')
            ->first();

        $this->response = $this->response
            ->withType('application/json')
            ->withStringBody(json_encode([
                'success' => true,
                'briefing' => $briefing
            ]));

        return $this->response;
    }


    public function index()
    {
        $query = $this->Briefings->find();
        $briefings = $this->paginate($query);

        $this->set(compact('briefings'));
    }

    public function view($id = null)
    {
        $briefing = $this->Briefings->get($id, contain: ['Decisions', 'Parties']);
        $this->set(compact('briefing'));
    }

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
