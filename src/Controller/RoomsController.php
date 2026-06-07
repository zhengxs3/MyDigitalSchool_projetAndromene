<?php
declare(strict_types=1);

namespace App\Controller;

/**
 * Rooms Controller
 *
 * @property \App\Model\Table\RoomsTable $Rooms
 */
class RoomsController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        $query = $this->Rooms->find();
        $rooms = $this->paginate($query);

        $this->set(compact('rooms'));
    }

    /**
     * View method
     *
     * @param string|null $id Room id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
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

    if ($this->Rooms->save($room)) {

        $partiesTable = $this->fetchTable('Parties');

        $party = $partiesTable
            ->find()
            ->where(['room_id' => $room->id])
            ->first();

        if (!$party) {
            $party = $partiesTable->newEmptyEntity();

            $party = $partiesTable->patchEntity($party, [
                'room_id' => $room->id,
                'status' => 'waiting',
                'briefing_id' => null,
                'current_round' => null,
            ]);

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

        return $this->response
            ->withType('application/json')
            ->withHeader('Access-Control-Allow-Origin', '*')
            ->withStatus(200)
            ->withStringBody(json_encode([
                'success' => true,
                'room' => [
                    'id' => $room->id,
                    'max_players' => $room->max_players,
                ],
                'party' => [
                    'id' => $party->id,
                    'room_id' => $party->room_id,
                    'status' => $party->status,
                ],
            ]));
    }

    return $this->response
        ->withType('application/json')
        ->withHeader('Access-Control-Allow-Origin', '*')
        ->withStatus(400)
        ->withStringBody(json_encode([
            'success' => false,
            'message' => 'Erreur lors de la mise à jour du nombre de joueurs.',
        ]));
}

    /**
     * Edit method
     *
     * @param string|null $id Room id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
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

    /**
     * Delete method
     *
     * @param string|null $id Room id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
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
