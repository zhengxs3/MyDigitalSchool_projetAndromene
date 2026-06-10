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

public function ranking($partyId = null)
{
    $this->request->allowMethod(['get']);

    $partyPlayersTable = $this->fetchTable('PartyPlayers');

    $players = $partyPlayersTable
        ->find()
        ->contain(['Users'])
        ->where([
            'PartyPlayers.party_id' => (int)$partyId
        ])
        ->all()
        ->toArray();

    $result = [];

    foreach ($players as $player) {
        $totalScoreRow = $this->PlayerDecisions
            ->find()
            ->select([
                'total_score' => $this->PlayerDecisions->find()->func()->sum('score')
            ])
            ->where([
                'party_id' => (int)$partyId,
                'user_id' => (int)$player->user_id,
            ])
            ->first();

        $totalScore = $totalScoreRow->total_score ?? 0;

        $result[] = [
            'id' => $player->id,
            'user_id' => $player->user_id,
            'pseudo' => $player->user->pseudo ?? 'Joueur',
            'role' => $player->role,
            'score' => (int)$totalScore,
        ];
    }

    usort($result, function ($a, $b) {
        return $b['score'] <=> $a['score'];
    });

    foreach ($result as $index => &$player) {
        $player['rank'] = $index + 1;
    }

    return $this->response
        ->withType('application/json')
        ->withHeader('Access-Control-Allow-Origin', 'http://localhost:8081')
        ->withStatus(200)
        ->withStringBody(json_encode([
            'success' => true,
            'players' => $result,
        ]));
}


    public function index()
    {
        $query = $this->PlayerDecisions->find()
            ->contain(['Users', 'Decisions', 'Parties']);
        $playerDecisions = $this->paginate($query);

        $this->set(compact('playerDecisions'));
    }

    public function view($id = null)
    {
        $playerDecision = $this->PlayerDecisions->get($id, contain: ['Users', 'Decisions', 'Parties']);
        $this->set(compact('playerDecision'));
    }

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
