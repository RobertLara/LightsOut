<tr>
    <td><?php echo $user->username;?></td>
    <td class="text-center">
        <form id="delete-<?php echo $user->id_user;?>" method="post" action="<?php echo base_url('Main/deleteUser')?>">
            <input type="hidden" name="id_user" value="<?php echo $user->id_user;?>"/>
            <a href="#" onclick="document.getElementById('delete-<?php echo $user->id_user;?>').submit()" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span> Eliminar</a></td>
        </form>

</tr>