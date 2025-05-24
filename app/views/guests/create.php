<?php

echo <<<HTML
        <form method='post' action='/guests'>
            <fieldset>
                <label for="name">Szoba</label>
                <input type="text" name="name" id="name" placeholder='Név'>
                <input type="text" name="age" id="age" placeholder='Életkor'>
                <hr>
                <button type="submit" name="btn-save">
                     <i class="fa fa-save"></i>
                     &nbsp;Mentés
                </button>
                <a href="/guests">
                    <i class="fa fa-cancel"></i>
                    &nbsp;Mégse
                </a>
            </fieldset>
        </form>
    HTML;