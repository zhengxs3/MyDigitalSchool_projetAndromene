<?php
declare(strict_types=1);

namespace App\Controller;
use Cake\Cache\Cache;

/**
 * Rooms Controller
 *
 * @property \App\Model\Table\RoomsTable $Rooms
 */
class RoomsController extends AppController
{

    public function index()
    {
        $query = $this->Rooms->find();
        $rooms = $this->paginate($query);

        $this->set(compact('rooms'));
    }

    public function view($id = null)
    {
        $room = $this->Rooms->get($id, contain: ['Parties']);
        $this->set(compact('room'));
    }


    public function add()
    {
        $this->request->allowMethod(['post']);

        $data = $this->request->getData();

        $room = $this->Rooms->newEmptyEntity();

        $room->name = $data['name'] ?? null;
        $room->created_by = $data['created_by'] ?? null;
        $room->code = str_pad((string)rand(0, 999999), 6, '0', STR_PAD_LEFT);
        $room->status = 'waiting';

        if ($this->Rooms->save($room)) {
            return $this->response
                ->withType('application/json')
                ->withHeader('Access-Control-Allow-Origin', '*')
                ->withStatus(200)
                ->withStringBody(json_encode([
                    'success' => true,
                    'room' => [
                        'id' => $room->id,
                        'name' => $room->name,
                        'code' => $room->code,
                        'status' => $room->status,
                        'created_by' => $room->created_by,
                    ],
                ]));
        }

        return $this->response
            ->withType('application/json')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withStatus(400)
            ->withStringBody(json_encode([
                'success' => false,
                'message' => 'Erreur lors de la création de la salle.',
                'errors' => $room->getErrors(),
            ]));
    }

    public function updatePlayers($id = null)
    {
        $this->request->allowMethod(['post']);

        $data = $this->request->getData();

        $room = $this->Rooms->get($id);
        $room->max_players = $data['max_players'];

        if (!$this->Rooms->save($room)) {
            return $this->response
                ->withType('application/json')
                ->withHeader('Access-Control-Allow-Origin', '*')
                ->withStatus(400)
                ->withStringBody(json_encode([
                    'success' => false,
                    'message' => 'Erreur lors de la mise à jour du nombre de joueurs.',
                    'errors' => $room->getErrors(),
                ]));
        }

        $partiesTable = $this->fetchTable('Parties');

        $party = $partiesTable
            ->find()
            ->where(['room_id' => $room->id])
            ->first();

        if (!$party) {
            $party = $partiesTable->newEmptyEntity();

            $party->room_id = $room->id;
            $party->status = 'waiting';
            $party->briefing_id = null;
            $party->current_round = null;

            if (!$partiesTable->save($party)) {
                return $this->response
                    ->withType('application/json')
                    ->withHeader('Access-Control-Allow-Origin', '*')
                    ->withStatus(400)
                    ->withStringBody(json_encode([
                        'success' => false,
                        'message' => 'Erreur lors de la création de la partie.',
                        'errors' => $party->getErrors(),
                    ]));
            }
        }

        $partyPlayersTable = $this->fetchTable('PartyPlayers');

        $hostPlayer = $partyPlayersTable
            ->find()
            ->where([
                'party_id' => $party->id,
                'user_id' => $room->created_by,
            ])
            ->first();

        if (!$hostPlayer) {
            $hostPlayer = $partyPlayersTable->newEmptyEntity();

            $hostPlayer->user_id = $room->created_by;
            $hostPlayer->party_id = $party->id;
            $hostPlayer->role = null;
            $hostPlayer->objective = null;
            $hostPlayer->resources = json_encode([]);
            $hostPlayer->score = 0;
            $hostPlayer->status = 'ready';

            if (!$partyPlayersTable->save($hostPlayer)) {
                return $this->response
                    ->withType('application/json')
                    ->withHeader('Access-Control-Allow-Origin', '*')
                    ->withStatus(400)
                    ->withStringBody(json_encode([
                        'success' => false,
                        'message' => 'Erreur lors de l’ajout du joueur hôte.',
                        'errors' => $hostPlayer->getErrors(),
                    ]));
            }
        }

        return $this->response
            ->withType('application/json')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withStatus(200)
            ->withStringBody(json_encode([
                'success' => true,
                'room' => [
                    'id' => $room->id,
                    'code' => $room->code,
                    'max_players' => $room->max_players,
                    'created_by' => $room->created_by,
                ],
                'party' => [
                    'id' => $party->id,
                    'room_id' => $party->room_id,
                    'status' => $party->status,
                ],
                'host_player' => [
                    'id' => $hostPlayer->id,
                    'user_id' => $hostPlayer->user_id,
                    'party_id' => $hostPlayer->party_id,
                    'status' => $hostPlayer->status,
                ],
            ]));
    }

    public function waitingRoom($id = null)
    {
        $this->request->allowMethod(['get']);

        $userId = $this->request->getQuery('user_id');

        $room = $this->Rooms
            ->find()
            ->where(['Rooms.id' => $id])
            ->first();

        if (!$room) {
            return $this->response
                ->withType('application/json')
                ->withHeader('Access-Control-Allow-Origin', '*')
                ->withStatus(404)
                ->withStringBody(json_encode([
                    'success' => false,
                    'message' => 'Salle introuvable.',
                ]));
        }

        $partiesTable = $this->fetchTable('Parties');

        $party = $partiesTable
            ->find()
            ->where(['room_id' => $room->id])
            ->first();

        if (!$party) {
            return $this->response
                ->withType('application/json')
                ->withHeader('Access-Control-Allow-Origin', '*')
                ->withStatus(404)
                ->withStringBody(json_encode([
                    'success' => false,
                    'message' => 'Partie introuvable.',
                ]));
        }

        $partyPlayersTable = $this->fetchTable('PartyPlayers');

        $players = $partyPlayersTable
            ->find()
            ->contain(['Users'])
            ->where(['party_id' => $party->id])
            ->all();

        $playersData = [];

        foreach ($players as $player) {
            $playersData[] = [
                'id' => $player->id,
                'user_id' => $player->user_id,
                'name' => $player->user->pseudo ?? 'Joueur',
                'role' => $player->role,
                'resources' => $player->resources,
                'status' => $player->status,
                'isMe' => (int)$player->user_id === (int)$userId,
                'isHost' => (int)$player->user_id === (int)$room->created_by,
            ];
        }

        $messages = Cache::read('party_messages_' . $party->id, 'default') ?? [];

        $started = Cache::read(
            'party_started_' . $party->id,
            'default'
        ) ?? false;

        return $this->response
            ->withType('application/json')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withStatus(200)
            ->withStringBody(json_encode([
                'success' => true,
                'room' => [
                    'id' => $room->id,
                    'code' => $room->code,
                    'max_players' => $room->max_players,
                    'created_by' => $room->created_by,
                ],
                'party' => [
                    'id' => $party->id,
                    'room_id' => $party->room_id,
                    'status' => $party->status,
                ],
                'players' => $playersData,
                'messages' => $messages,
                'started' => $started,
            ]));
    }

    public function sendMessage()
    {
        $this->request->allowMethod(['post']);

        $data = $this->request->getData();

        $partyId = $data['party_id'] ?? null;
        $userId = $data['user_id'] ?? null;
        $name = $data['name'] ?? 'Joueur';
        $content = trim($data['content'] ?? '');

        if (!$partyId || !$userId || $content === '') {
            return $this->response
                ->withType('application/json')
                ->withHeader('Access-Control-Allow-Origin', '*')
                ->withStatus(400)
                ->withStringBody(json_encode([
                    'success' => false,
                    'message' => 'Données invalides.',
                ]));
        }

        $partiesTable = $this->fetchTable('Parties');

        $party = $partiesTable
            ->find()
            ->where(['id' => $partyId])
            ->first();

        if (!$party) {
            return $this->response
                ->withType('application/json')
                ->withHeader('Access-Control-Allow-Origin', '*')
                ->withStatus(404)
                ->withStringBody(json_encode([
                    'success' => false,
                    'message' => 'Partie introuvable.',
                ]));
        }

        $cacheKey = 'party_messages_' . $partyId;

        $messages = Cache::read($cacheKey, 'default') ?? [];

        $messages[] = [
            'id' => time() . rand(100, 999),
            'user_id' => $userId,
            'name' => $name,
            'content' => $content,
            'created' => date('Y-m-d H:i:s'),
        ];

        Cache::write($cacheKey, $messages, 'default');

        return $this->response
            ->withType('application/json')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withStatus(200)
            ->withStringBody(json_encode([
                'success' => true,
                'messages' => $messages,
            ]));
    }

    public function joinByCode()
    {
        $this->request->allowMethod(['post']);

        $data = $this->request->getData();

        $code = $data['code'] ?? null;
        $userId = $data['user_id'] ?? null;

        if (!$code) {
            return $this->response
                ->withType('application/json')
                ->withHeader('Access-Control-Allow-Origin', '*')
                ->withStatus(400)
                ->withStringBody(json_encode([
                    'success' => false,
                    'message' => 'Code de salle obligatoire.',
                ]));
        }

        $room = $this->Rooms
            ->find()
            ->where([
                'code' => $code,
                'status' => 'waiting',
            ])
            ->orderBy(['id' => 'DESC'])
            ->first();

        if (!$room) {
            return $this->response
                ->withType('application/json')
                ->withHeader('Access-Control-Allow-Origin', '*')
                ->withStatus(404)
                ->withStringBody(json_encode([
                    'success' => false,
                    'message' => 'Salle introuvable.',
                ]));
        }

        $partiesTable = $this->fetchTable('Parties');

        $party = $partiesTable
            ->find()
            ->where([
                'room_id' => $room->id,
                'status' => 'waiting',
            ])
            ->orderBy(['id' => 'DESC'])
            ->first();

        if (!$party) {
            return $this->response
                ->withType('application/json')
                ->withHeader('Access-Control-Allow-Origin', '*')
                ->withStatus(404)
                ->withStringBody(json_encode([
                    'success' => false,
                    'message' => 'Partie introuvable.',
                ]));
        }

        $partyPlayersTable = $this->fetchTable('PartyPlayers');

        $currentPlayers = $partyPlayersTable
            ->find()
            ->where(['party_id' => $party->id])
            ->count();

        if ($currentPlayers >= $room->max_players) {
            return $this->response
                ->withType('application/json')
                ->withHeader('Access-Control-Allow-Origin', '*')
                ->withStatus(400)
                ->withStringBody(json_encode([
                    'success' => false,
                    'message' => 'La salle est pleine. Vous ne pouvez pas rejoindre.',
                ]));
        }

        $alreadyJoined = $partyPlayersTable
            ->find()
            ->where([
                'party_id' => $party->id,
                'user_id' => $userId,
            ])
            ->first();

        if (!$alreadyJoined) {
            $player = $partyPlayersTable->newEmptyEntity();

            $player->user_id = $userId;
            $player->party_id = $party->id;
            $player->role = null;
            $player->objective = null;
            $player->resources = json_encode([]);
            $player->score = 0;
            $player->status = 'waiting';

            if (!$partyPlayersTable->save($player)) {
                return $this->response
                    ->withType('application/json')
                    ->withHeader('Access-Control-Allow-Origin', '*')
                    ->withStatus(400)
                    ->withStringBody(json_encode([
                        'success' => false,
                        'message' => 'Erreur lors de l’ajout du joueur.',
                        'errors' => $player->getErrors(),
                    ]));
            }
        } else {
            $player = $alreadyJoined;
        }

        return $this->response
            ->withType('application/json')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withStatus(200)
            ->withStringBody(json_encode([
                'success' => true,
                'message' => 'Salle rejointe avec succès.',
                'room' => [
                    'id' => $room->id,
                    'code' => $room->code,
                    'max_players' => $room->max_players,
                ],
                'party' => [
                    'id' => $party->id,
                    'room_id' => $party->room_id,
                ],
                'player' => [
                    'id' => $player->id,
                    'user_id' => $player->user_id,
                    'party_id' => $player->party_id,
                ],
            ]));
    }

    public function readyPlayer()
    {
        $this->request->allowMethod(['post']);

        $data = $this->request->getData();

        $partyId = $data['party_id'] ?? null;
        $userId = $data['user_id'] ?? null;

        $partyPlayersTable = $this->fetchTable('PartyPlayers');

        $player = $partyPlayersTable
            ->find()
            ->where([
                'party_id' => $partyId,
                'user_id' => $userId,
            ])
            ->first();

        if (!$player) {
            return $this->response
                ->withType('application/json')
                ->withHeader('Access-Control-Allow-Origin', '*')
                ->withStatus(404)
                ->withStringBody(json_encode([
                    'success' => false,
                    'message' => 'Joueur introuvable.',
                ]));
        }

        $player->status = 'ready';

        if (!$partyPlayersTable->save($player)) {
            return $this->response
                ->withType('application/json')
                ->withHeader('Access-Control-Allow-Origin', '*')
                ->withStatus(400)
                ->withStringBody(json_encode([
                    'success' => false,
                    'message' => 'Erreur lors de la préparation.',
                ]));
        }

        return $this->response
            ->withType('application/json')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withStatus(200)
            ->withStringBody(json_encode([
                'success' => true,
                'message' => 'Joueur prêt.',
            ]));
    }

    public function unreadyPlayer()
    {
        $this->request->allowMethod(['post']);

        $data = $this->request->getData();

        $partyId = $data['party_id'] ?? null;
        $userId = $data['user_id'] ?? null;

        $partyPlayersTable = $this->fetchTable('PartyPlayers');

        $player = $partyPlayersTable
            ->find()
            ->where([
                'party_id' => $partyId,
                'user_id' => $userId,
            ])
            ->first();

        if (!$player) {
            return $this->response
                ->withType('application/json')
                ->withHeader('Access-Control-Allow-Origin', '*')
                ->withStatus(404)
                ->withStringBody(json_encode([
                    'success' => false,
                    'message' => 'Joueur introuvable.',
                ]));
        }

        $player->status = 'waiting';

        if (!$partyPlayersTable->save($player)) {
            return $this->response
                ->withType('application/json')
                ->withHeader('Access-Control-Allow-Origin', '*')
                ->withStatus(400)
                ->withStringBody(json_encode([
                    'success' => false,
                    'message' => 'Erreur lors de l’annulation du statut prêt.',
                ]));
        }

        return $this->response
            ->withType('application/json')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withStatus(200)
            ->withStringBody(json_encode([
                'success' => true,
                'message' => 'Joueur de nouveau en attente.',
            ]));
    }

    public function startGame()
{
    $this->request->allowMethod(['post']);

    $data = $this->request->getData();
    $partyId = $data['party_id'] ?? null;

    if (!$partyId) {
        return $this->response
            ->withType('application/json')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withStatus(400)
            ->withStringBody(json_encode([
                'success' => false,
                'message' => 'party_id obligatoire.',
            ]));
    }

    $partiesTable = $this->fetchTable('Parties');

    $party = $partiesTable
        ->find()
        ->where(['id' => $partyId])
        ->first();

    if (!$party) {
        return $this->response
            ->withType('application/json')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withStatus(404)
            ->withStringBody(json_encode([
                'success' => false,
                'message' => 'Partie introuvable.',
            ]));
    }

    $room = $this->Rooms->get($party->room_id);

    $party->status = 'playing';
    $room->status = 'playing';

    $partiesTable->save($party);
    $this->Rooms->save($room);

    Cache::write(
        'party_started_' . $partyId,
        true,
        'default'
    );

    return $this->response
        ->withType('application/json')
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withStatus(200)
        ->withStringBody(json_encode([
            'success' => true,
        ]));
}




    public function edit($id = null)
    {
        $room = $this->Rooms->get($id, contain: []);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $room = $this->Rooms->patchEntity($room, $this->request->getData());
            if ($this->Rooms->save($room)) {
                $this->Flash->success(__('The room has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The room could not be saved. Please, try again.'));
        }
        $this->set(compact('room'));
    }

    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $room = $this->Rooms->get($id);
        if ($this->Rooms->delete($room)) {
            $this->Flash->success(__('The room has been deleted.'));
        } else {
            $this->Flash->error(__('The room could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
