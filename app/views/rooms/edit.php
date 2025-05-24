<?php

$html = <<<HTML
        <form method='post' action='/rooms'>
            <input type='hidden' name='_method' value='PATCH'>
            <input type='hidden' name="id" value="{$rooms->id}">
            <fieldset>
                <label for="rooms">Szobák</label>
                <input type="text" name="id" id="id" value="{$rooms->id}" placeholder='ID'>
                <input type="text" name="floor" id="floor" value="{$rooms->floor}" placeholder='Emelet'>
                <input type="text" name="room_number" id="room_number" value="{$rooms->room_number}" placeholder='Szobaszám'>
                <input type="text" name="capacity" id="capacity" value="{$rooms->capacity}" placeholder='Férőhelyek száma'>
                <input type="text" name="price" id="price" value="{$rooms->price}" placeholder='Ár/nap'>
                <input type="text" name="notes" id="notes" value="{$rooms->notes}" placeholder='Megjegyzés'>
                <hr>
                <button type="submit" name="btn-update">
                    <i class="fa fa-save"></i>
                    &nbsp;Mentés
                </button>
                <a href="/rooms"><i class="fa fa-cancel"></i>
                &nbsp;Mégse
                </a>
            </fieldset>
        </form>
        HTML;

echo $html;