<?php

echo <<<HTML
        <form method='post' action='/rooms'>
            <fieldset>
                <label for="name">Szoba</label>
                <input type="text" name="id" id="id" placeholder='ID'>
                <input type="text" name="floor" id="floor" placeholder='Emelet'>
                <input type="text" name="room_number" id="room_number" placeholder='Szobaszám'>
                <input type="text" name="capacity" id="capacity" placeholder='Férőhelyek száma'>
                <input type="text" name="price" id="price" placeholder='Ár/nap'>
                <input type="text" name="notes" id="notes" placeholder='Megjegyzés'>
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