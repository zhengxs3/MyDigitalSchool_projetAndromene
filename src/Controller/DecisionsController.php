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

public function byParty($partyId = null)
{
    $this->request->allowMethod(['get']);

    $partiesTable = $this->fetchTable('Parties');
    $partyPlayersTable = $this->fetchTable('PartyPlayers');

    $party = $partiesTable
        ->find()
        ->where(['id' => $partyId])
        ->first();

    if (!$party) {
        return $this->response
            ->withType('application/json')
            ->withStatus(404)
            ->withStringBody(json_encode([
                'success' => false,
            ]));
    }

    $decisions = $this->Decisions
        ->find()
        ->where([
            'briefing_id' => $party->briefing_id
        ])
        ->all();

    $player = $partyPlayersTable
        ->find()
        ->where([
            'party_id' => $partyId
        ])
        ->first();

    return $this->response
        ->withType('application/json')
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withStatus(200)
        ->withStringBody(json_encode([
            'success' => true,
            'decisions' => $decisions,
            'resources' => $player?->resources,
        ]));
}

public function choose()
{
    $this->request->allowMethod(['post']);

    $data = $this->request->getData();

    $partyId = $data['party_id'] ?? null;
    $decisionId = $data['decision_id'] ?? null;

    if (!$partyId || !$decisionId) {
        return $this->response
            ->withType('application/json')
            ->withHeader('Access-Control-Allow-Origin', 'http://localhost:8081')
            ->withStatus(400)
            ->withStringBody(json_encode([
                'success' => false,
                'message' => 'party_id ou decision_id manquant',
                'data' => $data,
            ]));
    }

    $partyPlayersTable = $this->fetchTable('PartyPlayers');
    $playerDecisionsTable = $this->fetchTable('PlayerDecisions');

    $decision = $this->Decisions
        ->find()
        ->where(['id' => (int)$decisionId])
        ->first();

    if (!$decision) {
        return $this->response
            ->withType('application/json')
            ->withHeader('Access-Control-Allow-Origin', 'http://localhost:8081')
            ->withStatus(404)
            ->withStringBody(json_encode([
                'success' => false,
                'message' => 'Décision introuvable',
            ]));
    }

    $player = $partyPlayersTable
        ->find()
        ->where(['party_id' => (int)$partyId])
        ->first();

    if (!$player) {
        return $this->response
            ->withType('application/json')
            ->withHeader('Access-Control-Allow-Origin', 'http://localhost:8081')
            ->withStatus(404)
            ->withStringBody(json_encode([
                'success' => false,
                'message' => 'Joueur introuvable',
            ]));
    }

    if (is_array($player->resources)) {
        $resources = $player->resources;
    } else {
        $resources = json_decode((string)($player->resources ?? '{}'), true);
    }

    if (!is_array($resources)) {
        $resources = [];
    }

    $alreadySelected = $playerDecisionsTable
        ->find()
        ->innerJoin(
            ['Decisions' => 'decisions'],
            ['Decisions.id = PlayerDecisions.decision_id']
        )
        ->where([
            'PlayerDecisions.party_id' => (int)$partyId,
            'Decisions.type' => $decision->type,
        ])
        ->first();

    if ($alreadySelected) {
        return $this->response
            ->withType('application/json')
            ->withHeader('Access-Control-Allow-Origin', 'http://localhost:8081')
            ->withStatus(400)
            ->withStringBody(json_encode([
                'success' => false,
                'message' => 'Une décision de ce type est déjà choisie',
            ]));
    }

    // 不扣钱，只加分
    $player->score = (int)($player->score ?? 0) + (int)$decision->score;

    if (!$partyPlayersTable->save($player)) {
        return $this->response
            ->withType('application/json')
            ->withHeader('Access-Control-Allow-Origin', 'http://localhost:8081')
            ->withStatus(400)
            ->withStringBody(json_encode([
                'success' => false,
                'message' => 'Erreur update player',
                'errors' => $player->getErrors(),
            ]));
    }

    $playerDecision = $playerDecisionsTable->newEmptyEntity();

    $playerDecision->user_id = (int)$player->user_id;
    $playerDecision->decision_id = (int)$decisionId;
    $playerDecision->party_id = (int)$partyId;
    $playerDecision->elapsed_time = 0;
    $playerDecision->score = (int)$decision->score;

    if (!$playerDecisionsTable->save($playerDecision)) {
        return $this->response
            ->withType('application/json')
            ->withHeader('Access-Control-Allow-Origin', 'http://localhost:8081')
            ->withStatus(400)
            ->withStringBody(json_encode([
                'success' => false,
                'message' => 'Erreur insert player_decisions',
                'errors' => $playerDecision->getErrors(),
            ]));
    }

    return $this->response
        ->withType('application/json')
        ->withHeader('Access-Control-Allow-Origin', 'http://localhost:8081')
        ->withStatus(200)
        ->withStringBody(json_encode([
            'success' => true,
            'message' => 'Décision choisie',
            'resources' => $resources,
            'score' => $player->score,
            'saved' => $playerDecision,
        ]));
}



    public function index()
    {
        $query = $this->Decisions->find()
            ->contain(['Briefings']);
        $decisions = $this->paginate($query);

        $this->set(compact('decisions'));
    }

    public function view($id = null)
    {
        $decision = $this->Decisions->get($id, contain: ['Briefings', 'PlayerDecisions']);
        $this->set(compact('decision'));
    }

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
