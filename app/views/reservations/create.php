<?php

echo <<<HTML
        <form method='post' action='/rooms'>
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
    $szobak = $rooms->all();
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
echo <<<HTML
                    <input type="text" name="days" id="days" placeholder='Napok száma'>
                    <input type="text" name="start_date" id="start_date" placeholder='Kezdeti dátum'>
                    <hr>
                    <button type="submit" name="btn-save">
                        <i class="fa fa-save"></i>
                        &nbsp;Mentés
                    </button>
                    <a href="/rooms">
                        <i class="fa fa-cancel"></i>
                        &nbsp;Mégse
                    </a>
                </fieldset>
            </form>
    HTML;