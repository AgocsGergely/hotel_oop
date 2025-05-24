<?php

if (!empty($_SESSION['warning_message'])) {
    echo '<div class="alert alert-danger" style="color:red;">' . htmlspecialchars($_SESSION['warning_message']) . '</div>';
    unset($_SESSION['warning_message']); 
}



$tomorrow = date('Y-m-d', strtotime('+1 day'));



echo <<<HTML
        <form method='post' action='/reservations/edit/submit'>
            <fieldset>
                <input type="hidden" name="id" id="id" value="{$reservations->id}">
                <input type="text" name="days" id="days" value="{$reservations->days}" placeholder='Napok száma'>
                <label for="name">Szoba</label>
                <select name="room_id" id="room_id" required>
    HTML;

        $instanceOfRooms = $rooms->all();
        foreach ($instanceOfRooms as $room) {
            echo "<option value='{$room->id}'>{$room->room_number}</option>";
        }


echo <<<HTML
        </select>
        <label for="guest_id">Vendég</label>
        <select name="guest_id" id="guest_id" required>
        HTML;


        $guestsData = $guests->all();
        foreach ($guestsData as $guest) {
            echo "<option value='$guest->id'> $guest->name </option>";
        }

        
echo <<<HTML
                    </select>
                    <label for="days">Napok száma</label>
                <input type="text" name="days" id="days" value="{$reservations->days}" placeholder='Napok száma'>
                <label for="start_date">Kezdeti dátum</label>
                <input type="date" name="start_date" id="start_date" min="{$tomorrow}" value="{$reservations->start_date}" placeholder='Kezdeti nap'>
                <hr>
                <button type="submit" name="btn-update">
                    <i class="fa fa-save"></i>
                    &nbsp;Mentés
                </button>
                <a href="/reservations"><i class="fa fa-cancel"></i>
                &nbsp;Mégse
                </a>
            </fieldset>
        </form>
        HTML;

