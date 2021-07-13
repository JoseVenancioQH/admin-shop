<?php
  $no = 1;
  foreach ($datagetListData as $data) {
    ?>
    <tr>
      <td><?php echo $no; ?></td>
      <td><?php echo $data->user_id; ?></td>
      <td><?php echo $data->namecompany; ?></td>
      <td><?php echo $data->username; ?></td>
      <td><?php echo $data->email.", CC:".$data->emailcc.", BCC:".$data->emailbcc; ?></td>
      <td><?php echo $data->website; ?></td>
      <td><?php echo $data->active; ?></td>
      <td class="text-center" style="min-width:230px;">
          <button class="btn btn-warning update-dataUserSegmentation"  data-id="<?php echo $data->user_id; ?>"><i class="glyphicon glyphicon-repeat"></i> Update</button>
          <!--<button class="btn btn-danger konfirmasiHapus-kota" data-id="<?php echo $data->user_id; ?>" data-toggle="modal" data-target="#konfirmasiHapus"><i class="glyphicon glyphicon-remove-sign"></i> Delete</button>-->         
          <button class="btn btn-info email-dataUserSegmentation" data-id="<?php echo $data->user_id; ?>"><i class="glyphicon glyphicon-info-sign"></i> Send Mail <span class="badge badge-light"><?php echo $data->sendemail; ?></span></button>
      </td>
    </tr>
    <?php
    $no++;
  }
?>