<?php

namespace App\Controllers;
use App\Models\RoomsModel;
use App\Views\Display;

class RoomsController extends Controller {

    public function __construct()
    {
        $rooms = new RoomsModel();
        parent::__construct($rooms);
    }

    public function index(): void
    {
        $rooms = $this->model->all(['order_by' => ['floor, room_number'], 'direction' => ['DESC']]);
        $this->render('rooms/index', ['rooms' => $rooms]);
    }

    public function create(): void
    {
        $this->render('rooms/create');
    }
    public function edit(int $id): void
    {
        $rooms = $this->model->find($id);
        if (!$rooms) {
            // Handle invalid ID gracefully
            $_SESSION['warning_message'] = "A szoba a megadott azonosítóval: $id nem található.";
            $this->redirect('/rooms');
        }
        $this->render('rooms/edit', ['rooms' => $rooms]);
    }

    public function save(array $data): void
    {
        if (empty($data['room_number'])) {
            $_SESSION['warning_message'] = "A szoba száma kötelező mező.";
            $this->redirect('/rooms/create'); // Redirect if input is invalid
        }
        // Use the existing model instance
        $this->model->floor = $data['floor'];
        $this->model->room_number = $data['room_number'];
        $this->model->capacity = $data['capacity'];
        $this->model->price = $data['price'];
        $this->model->notes = $data['notes'];
        $this->model->create();
        $this->redirect('/rooms');
    }

    public function update(int $id, array $data): void
    {
        $rooms = $this->model->find($id);
        if (!$rooms || empty($data['room_number'])) {
            // Handle invalid ID or data
            $this->redirect('/rooms');
        }
        $rooms->floor = $data['floor'];
        $rooms->room_number = $data['room_number'];
        $rooms->capacity = $data['capacity'];
        $rooms->price = $data['price'];
        $rooms->notes = $data['notes'];
        $rooms->update();
        $this->redirect('/rooms');
    }

    function show(int $id): void
    {
        $rooms = $this->model->find($id);
        if (!$rooms) {
            $_SESSION['warning_message'] = "A szoba a megadott azonosítóval: $id nem található.";
            $this->redirect('/rooms'); // Handle invalid ID
        }
        $this->render('rooms/show', ['rooms' => $rooms]);
    }

    function delete(int $id): void
    {
        $rooms = $this->model->find($id);
        if ($rooms) {
            $result = $rooms->delete();
            if ($result) {
                $_SESSION['success_message'] = 'Sikeresen törölve';
            }
        }

        $this->redirect('/rooms'); // Redirect regardless of success
    }
}