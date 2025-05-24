<?php

echo <<<HTML
        <form method='post' action='/reservations'>
            <fieldset>
                <label for="name">Szoba</label>
                <select name="room_id" id="room_id" required>
                    <option value="">Válassz szobát</option>
                
    HTML;
    #echo "<script>alert($rooms)</script>";
    $instanceOfRooms = $rooms->all();
foreach ($instanceOfRooms as $room) {
            echo "<option value='{$room->id}'>{$room->room_number}</option>";
        }
echo <<<HTML
        </select>
        <label for="guest_id">Vendég</label>
        <select name="guest_id" id="guest_id" required>
            <option value="">Válassz vendéget</option>
HTML;

$guestsData = $guests->all();
foreach ($guestsData as $guest) {
    echo "<option value='$guest->id'> $guest->name </option>";
}
$tomorrow = date('Y-m-d', strtotime('+1 day'));
echo <<<HTML
                    <input type="number" min="0" name="days" id="days" placeholder='Napok száma'>
                    <label for="date">Kezdeti dátum</label>
                    <input type="date" name="start_date" id="start_date" min="{$tomorrow}" required>
                    <hr>
                    <button type="submit" name="btn-save">
                        <i class="fa fa-save"></i>
                        &nbsp;Mentés
                    </button>
                    <a href="/reservations">
                        <i class="fa fa-cancel"></i>
                        &nbsp;Mégse
                    </a>
                </fieldset>
            </form>
    HTML;