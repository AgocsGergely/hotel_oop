<?php

namespace App\Controllers;
use App\Models\guestsModel;
use App\Views\Display;

class GuestsController extends Controller {

    public function __construct()
    {
        $guests = new GuestsModel();
        parent::__construct($guests);
    }

    public function index(): void
    {
        $guests = $this->model->all(['order_by' => ['name'], 'direction' => ['DESC']]);
        $this->render('guests/index', ['guests' => $guests]);
    }

    public function create(): void
    {
        $this->render('guests/create');
    }
    public function edit(int $id): void
    {
        $guests = $this->model->find($id);
        if (!$guests) {
            // Handle invalid ID gracefully
            $_SESSION['warning_message'] = "A szoba a megadott azonosítóval: $id nem található.";
            $this->redirect('/guests');
        }
        $this->render('guests/edit', ['guests' => $guests]);
    }

    public function save(array $data): void
    {
        if (empty($data['name'])) {
            $_SESSION['warning_message'] = "A név mező kitöltése kötelező!";
            $this->redirect('/guests/create'); // Redirect if input is invalid
        }
        // Use the existing model instance
        $this->model->name = $data['name'];
        $this->model->age = $data['age'];
        $this->model->create();
        $this->redirect('/guests');
    }

    public function update(int $id, array $data): void
    {
        $guests = $this->model->find($id);
        if (!$guests || empty($data['name'])) {
            // Handle invalid ID or data
            $this->redirect('/guests');
        }
        $this->model->name = $data['name'];
        $this->model->age = $data['age'];
        $guests->update();
        $this->redirect('/guests');
    }

    function show(int $id): void
    {
        $guests = $this->model->find($id);
        if (!$guests) {
            $_SESSION['warning_message'] = "A szoba a megadott azonosítóval: $id nem található.";
            $this->redirect('/guests'); // Handle invalid ID
        }
        $this->render('guests/show', ['guests' => $guests]);
    }

    function delete(int $id): void
    {
        $guests = $this->model->find($id);
        if ($guests) {
            $result = $guests->delete();
            if ($result) {
                $_SESSION['success_message'] = 'Sikeresen törölve';
            }
        }

        $this->redirect('/guests'); // Redirect regardless of success
    }
}