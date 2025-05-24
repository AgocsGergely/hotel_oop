<?php

$tableBody = "";
foreach ($rooms as $room) {
    $tableBody .= <<<HTML
            <tr>
                <td>{$room->id}</td>
                <td>{$room->floor}</td>
                <td>{$room->number}</td>
                <td>{$room->capacity}</td>
                <td>{$room->price}</td>
                <td>{$room->comment}</td>
                <td class='flex float-right'>
                    <form method='post' action='/rooms/edit'>
                        <input type='hidden' name='id' value='{$room->id}'>
                        <button type='submit' name='btn-edit' title='Módosít'><i class='fa fa-edit'></i></button>
                    </form>
                    <form method='post' action='/rooms'>
                        <input type='hidden' name='id' value='{$room->id}'>    
                        <input type='hidden' name='_method' value='DELETE'>
                        <button type='submit' name='btn-del' title='Töröl'><i class='fa fa-trash trash'></i></button>
                    </form>
                </td>
            </tr>
            HTML;
}

$html = <<<HTML
        <table id='admin-rooms-table' class='admin-rooms-table tabla'>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Emelet</th>
                    <th>Szám</th>
                    <th>Férőhely</th>
                    <th>Ár/nap</th>
                    <th>Megjegyzés</th>
                    <th>
                        <form method='post' action='/rooms/create'>
                            <button type="submit" name='btn-plus' title='Új'>
                                <i class='fa fa-plus plus'></i>&nbsp;Új</button>
                        </form>
                    </th>
                </tr>
            </thead>
             <tbody>%s</tbody>
            <tfoot>
            </tfoot>
        </table>
        HTML;

echo sprintf($html, $tableBody);
