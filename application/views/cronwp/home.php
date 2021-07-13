<div class="msg" style="display:none;">
  <?php echo @$this->session->flashdata('msg'); ?>
</div>

<div class="box">
  <div class="box-header">
    <div class="col-md-12">

      <div class="input-group form-group col-md-12">
        <span class="input-group-addon" id="sizing-addon2">
        <i class="glyphicon glyphicon-globe"></i>
        </span>
        <input type="text" class="form-control" placeholder="Url Shop"  id="urlshop" aria-describedby="sizing-addon2">
        
        <select id="select-urlshop" class="form-control changeshop select2 select2-hidden-accessible" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true">
        <option selected>Select Web Site</option>
        <?php            
            foreach ($dataMatchPricesShop as $data) {
              ?>
              <option><?php echo $data->website.((!empty($data->prefix_wp))?" - ".$data->prefix_wp.(($data->user_id_wp>=0)?" - ".$data->user_id_wp:""):""); ?></option>              
              <?php              
            }
        ?>          
        </select>       
      </div>  
      
      <form>        
        <div class="form-row">
          <div class="form-group col-md-1" style="font-size:10px;">
            <label for="inputCity"># Product</label>
            <select id="select-changenumproduct" class="form-control changenumproduct">
              <option>10</option>
              <option>15</option>
              <option>20</option>
              <option>30</option>
              <option selected>All</option>
            </select>  
          </div>
          <div class="form-group col-md-2" style="font-size:10px;">
            <label for="inputSKU">SKU</label>
            <textarea id="inputSKU" class="form-control" rows="3" placeholder="SKU 1; SKU 2; etc."></textarea>
          </div>
          <div class="form-group col-md-1" style="font-size:10px;">
            <label for="filter-marcas">Marcas</label>
            <input type="checkbox" id="filter-marcas" name="filter-marcas" data-bootstrap-switch>
          </div>          
          <div class="form-group col-md-1" style="font-size:10px;">
            <label for="filter-categorias">Categorias</label>
            <input type="checkbox" id="filter-categorias" name="filter-categorias" data-bootstrap-switch>
          </div>    
          <div class="form-group col-md-1" style="font-size:10px;">
            <label for="filter-productos">Productos</label>
            <input type="checkbox" id="filter-productos" name="filter-productos" data-bootstrap-switch>
          </div> 
          <div class="form-group col-md-1" style="font-size:10px;">
            <label for="filter-precios">Precios</label>
            <input type="checkbox" id="filter-precios" name="filter-precios" data-bootstrap-switch>
          </div> 
          <div class="form-group col-md-1" style="font-size:10px;">
            <label for="filter-imagenes">Imagenes</label>
            <input type="checkbox" id="filter-imagenes" name="filter-imagenes" data-bootstrap-switch>
          </div> 
          <div class="form-group col-md-1" style="font-size:10px;">
            <label for="filter-fichas">Fichas</label>
            <input type="checkbox" id="filter-fichas" name="filter-fichas" data-bootstrap-switch>
          </div>
          <div class="form-group col-md-1" style="font-size:10px;">
            <label for="ficha-refactor">Fichas Ref.</label>
            <input type="checkbox" id="ficha-refactor" name="ficha-refactor" data-bootstrap-switch>
          </div>
          <div class="form-group col-md-1" style="font-size:10px;">
            <label for="imagen-null">Imag. Null</label>
            <input type="checkbox" id="imagen-null" name="imagen-null" data-bootstrap-switch>
          </div>
          </div>
        </div>        
      </form> 
      <button class="form-control btn btn-primary get-shop"><i class="glyphicon glyphicon-plus-sign"></i> Cron</button>
    </div>
  </div>
  <!-- /.box-header -->
  <div class="box-body">
    
    <table id="list-data" class="table table-bordered table-striped">
      <thead>
        <tr>
          <th>#</th>
          <th>Url Image</th>
          <th>Image DM-Server</th>
          <th>Product Id</th>
          <th>SKU</th>
          <th>Name</th>  
          <th style="text-align: center;">Action</th>
        </tr>
      </thead>
      <tbody id="data-refactorimageshop">
      
      </tbody>
    </table>
  </div>

  <div class="box-body">    
    <div class="form-group col-md-1">
      <label for="inputZip">Data Local</label>
      <input type="checkbox" id="filter-DataServer" name="filter-DataServer" checked data-bootstrap-switch>
      <!-- <input type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success"> -->
    </div>
    <div class="form-group col-md-1">
      <label for="inputZip">Map Shop Online</label>
      <input type="checkbox" id="filter-DataShop" name="filter-DataShop" checked data-bootstrap-switch>
      <div id="advance-DataShop">0%</div>
      <!-- <input type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success"> -->
    </div>
    <div class="form-group col-md-1">
      <label for="inputZip">Map DM Online</label>
      <input type="checkbox" id="filter-DataDM" name="filter-DataDM" checked data-bootstrap-switch>
      <!-- <input type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success"> -->
      <div id="advance-DataDM">0%</div>
    </div>
    <div class="form-group col-md-1">
      <label for="inputZip">Map Ingram</label>
      <input type="checkbox" id="filter-DataIngram" name="filter-DataIngram" checked data-bootstrap-switch>
      <!-- <input type="checkbox" name="my-checkbox" checked data-bootstrap-switch data-off-color="danger" data-on-color="success"> -->
      <div id="advance-DataIngram">0%</div>
    </div>
    <div class="form-group col-md-1">
        <span class="input-group-addon" id="sizing-addon2">
        Diff ShopVsDM
        </span>
        <input type="text" value="5" class="form-control" placeholder="Diff ShopVsDM"  id="filter-margediff-shopvsdm" aria-describedby="sizing-addon2">
    </div>    
    <div class="form-group col-md-1">
        <span class="input-group-addon" id="sizing-addon2">
        Diff ShopVsIn
        </span>
        <input type="text" value="5" class="form-control" placeholder="Diff ShopVsIn"  id="filter-margediff-shopvsingram" aria-describedby="sizing-addon2">
    </div>  
  </div>

  
  
  <div class="box-body" style="overflow-x:auto;">
  <table id="example" class="table table-bordered table-striped" style="width:100%">
    <thead>    
        <tr>        
            <th>Match Prices ShopVsDM</th>
            <th>Match Prices ShopVsIngram</th>
            <th>Match Stock</th>
            <th>Match Category</th>
            <th>Match Manufacturer</th>
            <th>Match Active</th>
            <th>Active Shop</th>
            <th>Active DM</th>
            <th>Nombre Producto</th>
            <th>Model</th>
            <th>Sku</th>
            <th>P. Tienda</th>
            <th>P. Tienda > 0</th>
            <th>P. DM</th>
            <th>P. DM > 0</th>
            <th>P. Ingram</th>
            <th>Ingram Check</th>
            <th>Util. Prod.</th>
            <th>Util. Cat.</th>            
            <th>Utli. Mar.</th>
            <th>Util. Tienda</th>
            <th>P. Util. Tienda</th>
            <th>P. Util. Iva Tienda</th>
            <th>Stock Tienda</th>
            <th>Stock Tienda > 0</th>
            <th>Stock DM</th>
            <th>Stock DM > 0</th>
            <th>Stock Ingram</th>
            <th>Cat. Tienda</th>
            <th>Cat. DM</th>
            <th>Marca. Tienda</th>
            <th>Marca. DM</th>
            <th>Cat. Tienda ID</th>
            <th>Cat. DM ID</th>
            <th>Marca. Tienda ID</th>
            <th>Marca. DM ID</th>
            <th>Action</th>
        </tr>
    </thead>
    <tfoot>
        <tr>
            <th>Match Prices ShopVsDM</th>
            <th>Match Prices ShopVsIngram</th>
            <th>Match Stock</th>
            <th>Match Category</th>
            <th>Match Manufacturer</th>
            <th>Match Active</th>
            <th>Active Shop</th>
            <th>Active DM</th>
            <th>Nombre Producto</th>
            <th>Model</th>
            <th>Sku</th>
            <th>P. Tienda</th>
            <th>P. Tienda > 0</th>
            <th>P. DM</th>
            <th>P. DM > 0</th>
            <th>P. Ingram</th>
            <th>Ingram Check</th>
            <th>Util. Prod.</th>
            <th>Util. Cat.</th>            
            <th>Utli. Mar.</th>
            <th>Util. Tienda</th>
            <th>P. Util. Tienda</th>
            <th>P. Util. Iva Tienda</th>
            <th>Stock Tienda</th>
            <th>Stock Tienda > 0</th>
            <th>Stock DM</th>
            <th>Stock DM > 0</th>
            <th>Stock Ingram</th>
            <th>Cat. Tienda</th>
            <th>Cat. DM</th>
            <th>Marca. Tienda</th>
            <th>Marca. DM</th>
            <th>Cat. Tienda ID</th>
            <th>Cat. DM ID</th>
            <th>Marca. Tienda ID</th>
            <th>Marca. DM ID</th>
            <th>Action</th>
        </tr>
    </tfoot>
</table>    
<button class="form-control btn btn-primary set-shop-prices"><i class="glyphicon glyphicon-plus-sign"></i> Update Shop Not Match Prices</button>
  </div>


</div>

<?php echo $modal_image; ?>

<div id="temsegmentation-modal">
  
</div>

<!-- Editing form modal -->
<div id="edit_news_modal" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit News item</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
                <form method="post" id="update_form_ingram">
                    <div class="form-group col-md-12">
                        <label for="IngramPrecio">Nombre</label>
                        <input type="text" disabled name="name" id="name" class="form-control"/>                        
                    </div>  
                    <div class="form-group col-md-6">
                        <label for="IngramPrecio">SKU</label>
                        <input type="text" disabled name="sku" id="sku" class="form-control"/>                        
                    </div>                    
                    <div class="form-group col-md-6">
                        <label for="IngramStock">Modelo</label>
                        <input type="text" disabled name="modelo" id="modelo" class="form-control"/>                        
                    </div> 
                    <div class="form-group col-md-6">
                        <label for="IngramPrecio">Precio Ingram</label>
                        <input type="text" disabled name="IngramPrecio" id="IngramPrecio" class="form-control" placeholder="Enter Precio Tienda" />
                        <button type="button" onclick="setValue('IngramPrecio','ShopPrecio')"  class="btn btn-primary col-md-12">Set Tienda</button> 
                        <button type="button" onclick="setValue('IngramPrecio','DMPrecio')"  class="btn btn-primary col-md-12">Set DM</button>
                    </div>                    
                    <div class="form-group col-md-6">
                        <label for="IngramStock">Inventario Ingram</label>
                        <input type="text" disabled name="IngramStock" id="IngramStock" class="form-control" placeholder="Enter Inventario Tienda" />
                        <button type="button" onclick="setValue('IngramStock','ShopStock')"  class="btn btn-primary col-md-12">Set Tienda</button> 
                        <button type="button" onclick="setValue('IngramStock','DMStock')"  class="btn btn-primary col-md-12">Set DM</button>
                    </div> 
                    <div id="rootCategory" class="form-group col-md-12">
                    
                    </div> 
                    <div class="modal-footer">
                        <button type="button" onclick="getPriceStockIngram()" class="btn btn-success col-md-12">Get Precio Inventario</button>                     
                    </div> 

                    <div class="modal-footer">
                        <button type="button" onclick="rootCategory()" class="btn btn-success col-md-12">Get Root Ingram</button>                   
                        
                    </div> 
                </form>
                <form method="post" id="update_form_tienda">
                    <input type="hidden" name="sku" id="sku" />                    
                    
                    <div class="form-group col-md-6">   
                        <label for="ShopPrecio">Precio Tienda</label>                   
                        <input type="text" name="ShopPrecio"  class="form-control col-md-12" id="ShopPrecio" placeholder="Enter Precio Tienda" />                      
                        <button type="button" onclick="setValue('ShopPrecio','DMPrecio')"  class="btn btn-primary col-md-12">Set DM</button> 
                                      
                    </div>
                    <div class="form-group col-md-6">
                        <label for="ShopStock">Inventario Tienda</label>
                        <input type="text" name="ShopStock" id="ShopStock" class="form-control" placeholder="Enter Inventario Tienda" />
                        <button type="button" onclick="setValue('ShopStock','DMStock')" class="btn btn-primary col-md-12">Set DM</button>
                      </div>  
                    <div class="form-group col-md-6">                   
                      <select id="categoria-tienda" class="form-control changeshop select2 select2-hidden-accessible" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true">
                      <option value = "" selected>Select Categoria Tienda</option>
                      <?php            
                          foreach ($categorias as $data) {
                            ?>
                            <option value="<?=$data->id; ?>"><?=$data->nombre; ?></option>              
                            <?php              
                          }
                      ?>          
                      </select>
                      <button type="button" onclick="setValueSelect('categoria-tienda','categoria-dm')" class="btn btn-primary col-md-12">Set DM</button>
                    </div>
                    <div class="form-group col-md-6">                          
                      <select id="marca-tienda" class="form-control changeshop select2 select2-hidden-accessible" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true">
                      <option value = "" selected>Select Marca Tienda</option>
                      <?php            
                          foreach ($marcas as $data) {
                            ?>
                            <option value="<?=$data->id; ?>"><?=$data->nombre; ?></option>              
                            <?php              
                          }
                      ?>          
                      </select>
                      <button type="button" onclick="setValueSelect('marca-tienda','marca-dm')" class="btn btn-primary col-md-12">Set DM</button>
                    </div>
                    <div class="modal-footer">
                      <button type="button" onclick="saveTienda()" class="btn btn-success">Submit Tienda</button>                        
                    </div>            
                </form>

                <form method="post" id="update_form_dm">
                    <input type="hidden" name="sku" id="sku" />
                    <div class="form-group col-md-6">
                        <label for="DMPrecio">Precio DM</label>
                        <input type="text" name="DMPrecio" id="DMPrecio" class="form-control" placeholder="Enter Precio Tienda" />
                        <button type="button" onclick="setValue('DMPrecio','ShopPrecio')" class="btn btn-primary col-md-12">Set Tienda</button>
                      </div>
                    <div class="form-group col-md-6">
                        <label for="DMStock">Inventario DM</label>
                        <input type="text" name="DMStock" id="DMStock" class="form-control" placeholder="Enter Inventario Tienda" />
                        <button type="button" onclick="setValue('DMStock','ShopStock')" class="btn btn-primary col-md-12">Set Tienda</button>
                      </div>  
                    <div class="form-group col-md-6">                   
                      <select id="categoria-dm" class="form-control changeshop select2 select2-hidden-accessible" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true">
                      <option selected>Select Categoria DM</option>
                      <?php            
                          foreach ($categorias as $data) {
                            ?>
                            <option value="<?=$data->id; ?>"><?=$data->nombre; ?></option>              
                            <?php              
                          }
                      ?>          
                      </select>
                      <button type="button" onclick="setValueSelect('categoria-dm','categoria-tienda')" class="btn btn-primary col-md-12">Set Tienda</button>
                    </div>
                    <div class="form-group col-md-6">                          
                      <select id="marca-dm" class="form-control changeshop select2 select2-hidden-accessible" style="width: 100%;" data-select2-id="1" tabindex="-1" aria-hidden="true">
                      <option selected>Select Marca DM</option>
                      <?php            
                          foreach ($marcas as $data) {
                            ?>
                            <option value="<?=$data->id; ?>"><?=$data->nombre; ?></option>              
                            <?php              
                          }
                      ?>          
                      </select>
                      <button type="button" onclick="setValueSelect('marca-dm','marca-tienda')" class="btn btn-primary col-md-12">Set Tienda</button>
                    </div>
                    <div class="modal-footer">
                      <button type="button" onclick="saveDM()" class="btn btn-success">Submit DM</button>                        
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>                        
                    </div>
                </form>

            </div> <!-- .modal-body -->
        </div> <!-- .modal-content -->
    </div> <!-- .modal-dialog -->
</div> <!-- .modal -->


