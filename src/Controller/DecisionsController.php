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

    $userId = $data['user_id'];
    $partyId = $data['party_id'];
    $decisionId = $data['decision_id'];

    $playerDecisionsTable = $this->fetchTable('PlayerDecisions');
    $partyPlayersTable = $this->fetchTable('PartyPlayers');

    // decision
    $decision = $this->Decisions->get($decisionId);

    // player
    $player = $partyPlayersTable
        ->find()
        ->where([
            'user_id' => $userId,
            'party_id' => $partyId,
        ])
        ->first();

    if (!$player) {
        return $this->response
            ->withType('application/json')
            ->withStatus(404)
            ->withStringBody(json_encode([
                'success' => false,
                'message' => 'Player introuvable',
            ]));
    }

    $resources = json_decode($player->resources, true);

    // argent insuffisant
    if (
        $resources['argent'] < $decision->resources_used
    ) {
        return $this->response
            ->withType('application/json')
            ->withStatus(400)
            ->withStringBody(json_encode([
                'success' => false,
                'message' => 'Ressources insuffisantes',
            ]));
    }

    // 检查同 type 是否已经选过
    $alreadySelected = $playerDecisionsTable
        ->find()
        ->contain(['Decisions'])
        ->where([
            'PlayerDecisions.user_id' => $userId,
            'PlayerDecisions.party_id' => $partyId,
            'Decisions.type' => $decision->type,
        ])
        ->first();

    if ($alreadySelected) {
        return $this->response
            ->withType('application/json')
            ->withStatus(400)
            ->withStringBody(json_encode([
                'success' => false,
                'message' => 'Type déjà sélectionné',
            ]));
    }

    // 扣钱
    $resources['argent'] -= $decision->resources_used;

    $player->resources = json_encode($resources);

    // 加分
    $player->score += $decision->score;

    $partyPlayersTable->save($player);

    // 保存选择记录
    $playerDecision = $playerDecisionsTable->newEmptyEntity();

    $playerDecision->user_id = $userId;
    $playerDecision->party_id = $partyId;
    $playerDecision->decision_id = $decisionId;
    $playerDecision->score = $decision->score;

    $playerDecisionsTable->save($playerDecision);

    return $this->response
        ->withType('application/json')
        ->withStatus(200)
        ->withStringBody(json_encode([
            'success' => true,
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
