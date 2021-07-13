<select id="filter-category" name="filter-category" class="form-control changeshop select2 select2-hidden-accessible" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true">
  <option value="0" selected>Select Category</option>
  <?php          
      foreach ($datagetListData as $data) {
       
        ?>
        <option value="<?php echo $data->category_id; ?>"><?php echo $data->name; ?></option>              
        <?php              
      }
  ?>    
</select>    