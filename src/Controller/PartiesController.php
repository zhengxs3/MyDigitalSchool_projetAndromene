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

    public function briefing($partyId = null)
    {
        $this->request->allowMethod(['get']);

        try {
            $party = $this->Parties
                ->find()
                ->where(['Parties.id' => $partyId])
                ->first();

            if (!$party) {
                return $this->response
                    ->withType('application/json')
                    ->withStatus(404)
                    ->withStringBody(json_encode([
                        'success' => false,
                        'message' => 'Party introuvable'
                    ]));
            }

            $briefingsTable = $this->fetchTable('Briefings');

            if (!empty($party->briefing_id)) {
                $briefing = $briefingsTable
                    ->find()
                    ->where(['Briefings.id' => $party->briefing_id])
                    ->first();
            } else {
                $briefings = $briefingsTable
                    ->find()
                    ->all()
                    ->toList();

                if (empty($briefings)) {
                    return $this->response
                        ->withType('application/json')
                        ->withStatus(404)
                        ->withStringBody(json_encode([
                            'success' => false,
                            'message' => 'Aucun briefing disponible'
                        ]));
                }

                $briefing = $briefings[array_rand($briefings)];

                $party->briefing_id = $briefing->id;
                $this->Parties->save($party);
            }

            return $this->response
                ->withType('application/json')
                ->withStringBody(json_encode([
                    'success' => true,
                    'briefing' => $briefing
                ]));

        } catch (\Throwable $e) {
            return $this->response
                ->withType('application/json')
                ->withStatus(500)
                ->withStringBody(json_encode([
                    'success' => false,
                    'message' => $e->getMessage()
                ]));
        }
    }

    
    public function index()
    {
        $query = $this->Parties->find()
            ->contain(['Briefings', 'Rooms']);
        $parties = $this->paginate($query);

        $this->set(compact('parties'));
    }

    public function view($id = null)
    {
        $party = $this->Parties->get($id, contain: ['Briefings', 'Rooms', 'PartyPlayers', 'PlayerDecisions']);
        $this->set(compact('party'));
    }

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
