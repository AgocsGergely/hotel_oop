<?php
if (!empty($_SESSION['warning_message'])) {
    echo '<div class="alert alert-danger" style="color:red;">' . htmlspecialchars($_SESSION['warning_message']) . '</div>';
    unset($_SESSION['warning_message']); 
}


$tableBody = "";
foreach ($reservations as $reservation) {
    $tableBody .= <<<HTML
            <tr>
                <td>{$reservation->id}</td>
                <td>{$rooms->find($reservation->room_id)->room_number}</td>
                <td>{$guests->find($reservation->guest_id)->name}</td>
                <td>{$reservation->days}</td>
                <td>{$reservation->start_date}</td>
                <td class='flex float-right'>
                    <form method='post' action='/reservations/edit'>
                        <input type='hidden' name='id' value='{$reservation->id}'>
                        <button type='submit' name='btn-edit' title='Módosít'><i class='fa fa-edit'></i></button>
                    </form>
                    <form method='post' action='/reservations'>
                        <input type='hidden' name='id' value='{$reservation->id}'>    
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
                    <th>Szobaszám</th>
                    <th>Vendég</th>
                    <th>Nap</th>
                    <th>Kezdeti nap</th>
                    <th>
                        <form method='post' action='/reservations/create'>
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
