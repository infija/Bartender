<script type="text/javascript">
    var $ = $ || jQuery;
    $(document).ready(function() {
        $('a.remove-reservation').click(function(event){
            var data = {action: 'bt_remove_reservation',
                        reservationId: $(this).attr('data-id'),
                        courseId: $(this).attr('data-course-id')
                        };
            $.post(window.location.href, $.param(data),
                function(data){ // success
                    console.log(data);
                }, 'json');
            event.preventDefault();
        });
    });
</script>
<table style="width:100%;">
    <thead>
        <td>Name</td>
        <td>CI</td>
        <td>Telefono</td>
        <td>Opciones</td>
    </thead>
<?php
    foreach ($reservations as $reservation) {
        ?>
        <tr>
            <td><?php echo $reservation->{ApplicationManager::FIRST_NAME} . ' ' . $reservation->{ApplicationManager::LAST_NAME} ?> </td>
            <td><?php echo $reservation->{ApplicationManager::CARNET} ?></td>
            <td><?php echo $reservation->{ApplicationManager::TELEFONO} ?></td>
            <td><a class='remove-reservation' href="" data-course-id="<?php echo $reservation->{ApplicationManager::POST_ID} ?>" data-id="<?php echo $reservation->{ApplicationManager::_ID} ?>">Eliminar</a></td>
        </tr>
        <?php
    }
?>
</table>