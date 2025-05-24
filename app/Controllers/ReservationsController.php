<?php

namespace App\Controllers;
use App\Models\GuestsModel;
use App\Models\RoomsModel;
use App\Models\reservationsModel;
use App\Views\Display;
use DateTime;

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
        $this->render('reservations/index', ['reservations' => $reservations,'rooms' => $this->rooms->model,'guests' => $this->guests->model]);
    }

    public function create(): void
    {
        $this->render('reservations/create', ['rooms' => $this->rooms->model, 'guests' => $this->guests->model]);
    }
    public function edit(int $id): void
    {
        $reservations = $this->model->find($id);
        /*if (!$reservations) {
            // Handle invalid ID gracefully
            $_SESSION['warning_message'] = "A szoba a megadott azonosítóval: $id nem található.";
            $this->redirect('/reservations');
        }*/
        $this->render('reservations/edit', ['reservations' => $reservations,'rooms' => $this->rooms->model, 'guests' => $this->guests->model]);
    }

    public function save(array $data): void
{
    $room_id = $data['room_id'];
    $guest_id = $data['guest_id'];
    $days = $data['days'];
    $start_date = $data['start_date'];

    // Check if the room is already booked during the given date range
    $status = $this->model->getRoomStatus($room_id, $days, $start_date);
    if ($status === 'occupied') {
        $_SESSION['warning_message'] = "A szoba foglalása beleütközik egy másik foglalásba!";
        $this->redirect('/reservations');
        return;
    }

    // Otherwise, proceed to save
    $this->model->room_id = $room_id;
    $this->model->guest_id = $guest_id;
    $this->model->days = $days;
    $this->model->start_date = $start_date;
    $this->model->create();

    $this->redirect('/reservations');
}



    public function update(int $id, array $data): void
    {
        $room_id = $data['room_id'];
    $guest_id = $data['guest_id'];
    $days = $data['days'];
    $start_date = $data['start_date'];

    // Check for overlaps excluding the current reservation
    $status = $this->model->getRoomStatus($room_id, $days, $start_date, $id);
    error_log($status);
    if ($status === 'occupied') {
        $_SESSION['warning_message'] = "A szoba foglalása beleütközik egy másik foglalásba!";
        $this->edit($id);
        return;
    }

    // Set updated values and save
    $this->model->id = $id; // make sure your model can track the ID
    $this->model->room_id = $room_id;
    $this->model->guest_id = $guest_id;
    $this->model->days = $days;
    $this->model->start_date = $start_date;
    $this->model->update(); // or however your model saves changes

    $this->redirect('/reservations');
    }

    function show(int $id): void
    {
        $reservations = $this->model->find($id);
        /*if (!$reservations) {
            $_SESSION['warning_message'] = "A szoba a megadott azonosítóval: $id nem található.";
            $this->redirect('/reservations'); // Handle invalid ID
        }*/
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