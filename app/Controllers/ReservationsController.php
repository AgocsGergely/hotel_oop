<?php

namespace App\Controllers;
use App\Models\GuestsModel;
use App\Models\RoomsModel;
use App\Models\reservationsModel;
use App\Views\Display;

class ReservationsController extends Controller
{
    public $rooms;
    public $guests;

    public function __construct()
    {
        
        $this->guests = new GuestsController();
        $this->rooms = new RoomsController();
        $reservations = new ReservationsModel();
        parent::__construct($reservations);
    }

    public function index(): void
    {
        $reservations = $this->model->all(['order_by' => ['start_date'], 'direction' => ['DESC']]);
        $this->render('reservations/index', ['reservations' => $reservations,'rooms' => $this->rooms->model, 'guests' => $this->guests->model]);
    }

    public function create(): void
    {
        $this->render('reservations/create', ['rooms' => $this->rooms->model, 'guests' => $this->guests->model]);
    }
    public function edit(int $id): void
    {
        $reservations = $this->model->find($id);
        if (!$reservations) {
            // Handle invalid ID gracefully
            $_SESSION['warning_message'] = "A szoba a megadott azonosítóval: $id nem található.";
            $this->redirect('/reservations');
        }
        $this->render('reservations/edit', ['reservations' => $reservations,'rooms' => $this->rooms->model, 'guests' => $this->guests->model]);
    }

    public function save(array $data): void
    {
        if (empty($data['room_id'])) {
            $_SESSION['warning_message'] = "A szoba száma kötelező mező.";
            $this->redirect('/reservations/create'); // Redirect if input is invalid
        }
        // Use the existing model instance
        $this->model->room_id = $data['room_id'];
        $this->model->guest_id = $data['guest_id'];
        $this->model->days = $data['days'];
        $this->model->start_date = $data['start_date'];
        $this->model->create();
        $this->redirect('/reservations');
    }

    public function update(int $id, array $data): void
    {
        $reservations = $this->model->find($id);
        if (!$reservations || empty($data['room_id'])) {
            // Handle invalid ID or data
            $this->redirect('/reservations');
        }
        $this->model->room_id = $data['room_id'];
        $this->model->guest_id = $data['guest_id'];
        $this->model->days = $data['days'];
        $this->model->start_date = $data['start_date'];
        $reservations->update();
        $this->redirect('/reservations');
    }

    function show(int $id): void
    {
        $reservations = $this->model->find($id);
        if (!$reservations) {
            $_SESSION['warning_message'] = "A szoba a megadott azonosítóval: $id nem található.";
            $this->redirect('/reservations'); // Handle invalid ID
        }
        $this->render('reservations/show', ['reservations' => $reservations,'rooms' => $this->rooms->model, 'guests' => $this->guests->model]);
    }

    function delete(int $id): void
    {
        $reservations = $this->model->find($id);
        if ($reservations) {
            $result = $reservations->delete();
            if ($result) {
                $_SESSION['success_message'] = 'Sikeresen törölve';
            }
        }

        $this->redirect('/reservations'); // Redirect regardless of success
    }
}