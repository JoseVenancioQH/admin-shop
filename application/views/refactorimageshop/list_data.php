<?php
  $no = 1;
  foreach ($datagetListData as $data) {
    $urlDMServer = "/images/".$data->sku.".jpg";
    //$status=(file_get_contents($urlDMServer))?true:false;
    $status=(curl($urlDMServer))?true:false;
    $img = ($status)?$urlDMServer:"/images/sinimagen.jpg";
    $label = ($status)?"img-thumbnail":"";
    $inputtext = ($status)?$urlDMServer:"";
    $imgShop = curl($urlshop."image/data/".$data->sku.".jpg");
    //$imgShop = file_get_contents($urlshop."image/data/".$data->sku.".jpg");
    $inputtext = ($status)?$urlDMServer:(($imgShop)?$urlshop."image/data/".$data->sku.".jpg":"");
    ?>
    <tr>
      <td><?php echo $no; ?></td>
      <td>
        <input type="text" value="<?php echo $inputtext; ?>" class="form-control new-input-img" placeholder="Url Image Upload"  id="<?php echo $data->product_id."-".$data->sku; ?>" aria-describedby="sizing-addon2">
        <img id="new-<?php echo $data->product_id."-".$data->sku; ?>" class="new-img-thumbnail" style="cursor: pointer;" src="<?php echo $inputtext; ?>" width="50" height="50">
      </td>
      <td><img id="<?php echo $data->sku; ?>" class="<?php echo $label;?>" style="cursor: pointer;" src="<?php echo $img; ?>" width="50" height="50"></td>
      <td><?php echo $data->product_id; ?></td>
      <td><?php echo $data->sku; ?></td>      
      <td><?php echo $data->name; ?></td>
      <td class="text-center" style="min-width:230px;">
          <button class="btn btn-warning upload-dataRefactorImageShop" data-id="<?php echo $data->product_id."-".$data->sku; ?>"><i class="glyphicon glyphicon-repeat"></i> Upload Shop</button>
          <button class="btn btn-warning" onclick="recategorizar('<?php echo $data->sku?>','<?php echo $data->id_categoria?>','<?php echo $data->id_fabricante?>','<?php echo $data->precio?>','<?php echo $data->disponibilidad?>')"><i class="glyphicon glyphicon-repeat"></i> Recategorizar</button>
          <!--<button class="btn btn-warning recategorizar" data-id="<?php echo $data->product_id."-".$data->sku; ?>"><i class="glyphicon glyphicon-repeat"></i> Recategorizar</button>--> 
          <!--<button class="btn btn-danger konfirmasiHapus-kota" data-id="<?php echo $data->user_id; ?>" data-toggle="modal" data-target="#konfirmasiHapus"><i class="glyphicon glyphicon-remove-sign"></i> Delete</button>-->         
          <!--<button class="btn btn-info email-dataUserSegmentation" data-id="<?php echo $data->user_id; ?>"><i class="glyphicon glyphicon-info-sign"></i> Send Mail <span class="badge badge-light"><?php echo $data->sendemail; ?></span></button>-->
      </td>
    </tr>
    <?php
    $no++;
  }
?>