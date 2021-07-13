<script type="text/javascript">
	$("input[data-bootstrap-switch]").each(function() {
		$(this).bootstrapSwitch('state', $(this).prop('checked'));
	});
	var MyTable = $('#list-data').dataTable({
		"paging": true,
		"lengthChange": true,
		"searching": true,
		"ordering": true,
		"info": true,
		"autoWidth": false
	});

	var objFilter;
	var MyTableExample;


	$(document).ready(function() {
		/* var objFilter = {
						urlshop:$('#urlshop').val(),
						data:{
								numproduct:($('#select-changenumproduct').val()=='All')?'':$('#select-changenumproduct').val(), 
								SKU:$('#inputSKU').val(),
								NameProduct:$('#inputNameProduct').val(),
								Model:$('#inputModel').val(),			
								filtercategory:$('#filter-category').val(),	
								filtermanufacturer:$('#filter-manufacturer').val(),					
								filterImageEmpty:$('#filter-ImageEmpty').bootstrapSwitch('state'),
								filteractive:$('#filter-active').bootstrapSwitch('state'),
								filterprice:$('#filter-price').bootstrapSwitch('state'),							
								type:"active"
							 }
					  }; */
		/* $('#example tfoot th').each( function () {
			var title = $(this).text();
			$(this).html( '<input type="text" placeholder="Search '+title+'" />' );
		}); */



		MyTableExample = $('#example').DataTable({
			//"paging": true,
			//"lengthChange": true,
			/* "scrollY":        "200px",
        				"scrollCollapse": true, */
			//"scrollX": true,
			//"searching": true,
			//"ordering": true,
			//"info": true,
			//"autoWidth": false,
			//"processing": true,
			//"serverSide": true,
			dom: 'Bfrtip',
			buttons: [
				'copy', 'csv', 'excel', 'pdf', 'print'
			],
			"ajax": {
				'url': "MatchPricesShop/getListData",
				"data": function(d) {
					d.urlshop = $('#urlshop').val();
					d.numproduct = ($('#select-changenumproduct').val() == 'All') ? '' : $('#select-changenumproduct').val();
					d.SKU = $('#inputSKU').val();
					d.NameProduct = $('#inputNameProduct').val();
					d.Model = $('#inputModel').val();
					d.filtercategory = $('#filter-category').val();
					d.filtermanufacturer = $('#filter-manufacturer').val();
					d.filterImageEmpty = $('#filter-ImageEmpty').bootstrapSwitch('state');
					d.filteractive = $('#filter-active').bootstrapSwitch('state');
					d.filterprice = $('#filter-price').bootstrapSwitch('state');
					d.type = "getShop";
					d.server = $("#filter-DataServer").bootstrapSwitch('state');
					d.datashop = $("#filter-DataShop").bootstrapSwitch('state');
					d.datadm = $("#filter-DataDM").bootstrapSwitch('state');
					d.dataingram = $("#filter-DataIngram").bootstrapSwitch('state');

					d.datadiffshopvsdm = $("#filter-margediff-shopvsdm").val();
					d.datadiffshopvsingram = $("#filter-margediff-shopvsingram").val();
				},
				'type': 'post',
				"dataSrc": ""
			},
			initComplete: function() {
				/* $("#example thead th").each( function ( i ) {
								var select = $('<select><option value=""></option></select>')
									.appendTo( $(this).empty() )
									.on( 'change', function () {
										MyTableExample.column( i )
											.search( $(this).val() )
											.draw();
									} );
						
									MyTableExample.column( i ).data().unique().sort().each( function ( d, j ) {
									select.append( '<option value="'+d+'">'+d+'</option>' )
								} );
							} ); */
				this.api().columns().every(function() {
					var column = this;
					var select = $('<select class="select2"><option value=""></option><option value=" ">-</option></select>')
						.appendTo($(column.footer()).empty())
						.on('change', function() {
							var val = $.fn.dataTable.util.escapeRegex(
								$(this).val()
							);

							column
								.search(val ? '^' + val + '$' : '', true, false)
								.draw();
						});

					column.data().unique().sort().each(function(d, j) {
						select.append('<option value="' + d + '">' + d + '</option>')
					});
				});
				$('.select2').select2();
			},
			"columns": [{
					"data": "match_prices_shopvsdm"
				},
				{
					"data": "match_prices_shopvsingram"
				},
				{
					"data": "match_stock"
				},
				{
					"data": "match_category"
				},
				{
					"data": "match_manufacturer"
				},
				{
					"data": "match_active"
				},
				{
					"data": "shop_active"
				},
				{
					"data": "dm_active"
				},
				{
					"data": "name"
				},
				{
					"data": "modelo"
				},
				{
					"data": "sku"
				},
				{
					"data": "ShopPrecio"
				},
				{
					"data": "ShopPrecioMayor0"
				},
				{
					"data": "DMPrecio"
				},
				{
					"data": "DMPrecioMayor0"
				},
				{
					"data": "IngramPrecio"
				},
				{
					"data": "IngramCheck"
				},
				{
					"data": "UtilidadProducto"
				},
				{
					"data": "UtilidadCategoria"
				},
				{
					"data": "UtilidadMarca"
				},
				{
					"data": "UtilidadTienda"
				},
				{
					"data": "ShopUtilidadPrecio"
				},
				{
					"data": "ShopUtilidadPrecioIva"
				},
				{
					"data": "ShopStock"
				},
				{
					"data": "ShopStockMayor0"
				},
				{
					"data": "DMStock"
				},
				{
					"data": "DMStockMayor0"
				},
				{
					"data": "IngramStock"
				},
				{
					"data": "CategoryShop"
				},
				{
					"data": "CategoryDM"
				},
				{
					"data": "ManufacturerShop"
				},
				{
					"data": "ManufacturerDM"
				},
				{
					"data": "CategoryShopID"
				},
				{
					"data": "CategoryDMID"
				},
				{
					"data": "ManufacturerShopID"
				},
				{
					"data": "ManufacturerDMID"
				},
				{
					"data": "Action"
				},
			],
			columnDefs: [
				/* {
					// # action controller (edit,delete)
					targets: [16],
					// # column rendering
					// https://datatables.net/reference/option/columns.render
					render: function(data, type, row, meta) {
						return "<button class=\"btn btn-sm btn-info\" onclick=\"getIngram('"+meta.row+"','5','14')\">get Ingram</button>";
					}
				},
				{
					// # action controller (edit,delete)
					targets: [25],
					// # column rendering
					// https://datatables.net/reference/option/columns.render
					render: function(data, type, row, meta) {
						return "<button class=\"btn btn-sm btn-info\" onclick=\"getIngram('"+meta.row+"','5','14')\">get Ingram</button>";
					}
				}, */
				{
					// # action controller (edit,delete)
					targets: [36],
					// # column rendering
					// https://datatables.net/reference/option/columns.render
					render: function(data, type, row, meta) {
						return "<button class=\"btn btn-sm btn-info\" onclick=\"editRow('" + meta.row + "')\">Edit</button>";
					}
				}
			]
			/* searchPanes:{
				viewTotal: true,
			},
			dom: 'Pfrtip', */
		});





		/* var table = $('#example').DataTable( {
			searchPanes:{
				viewTotal: true,
			},
			dom: 'Pfrtip',
		}); */

		/* MyTableExample.columns().every( function () {
			var that = this;	
			$( 'input', this.footer() ).on( 'keyup change', function () {
				if ( that.search() !== this.value ) {
					that
						.search( this.value )
						.draw();
				}
			} );
		}); */


		//MyTableExample.ajax.reload();

		$('.select2').select2();

	});
	window.onload = function() {

		getListDataUserSegmentation();
		<?php
		if ($this->session->flashdata('msg') != '') {
			echo "effect_msg();";
		}
		?>

		$('.select2').select2();
		
	}
	function recategorizar(sku,id_categoria,id_fabricante,precio,disponibilidad){
		$('#edit_news_modal').modal('show');

		$('#categoria-tienda').val(id_categoria).trigger('change');
		$('#marca-tienda').val(id_fabricante).trigger('change');
		//$('#categoria-dm').val(obj.CategoryDMID).trigger('change');
		//$('#marca-dm').val(obj.ManufacturerDMID).trigger('change');

		//$('#name').val(obj.name);
		$('#sku').val(sku);
		//$('#modelo').val(obj.modelo);
		$('#ShopPrecio').val(precio);
		//$('#DMPrecio').val(obj.DMPrecio);
		$('#ShopStock').val(disponibilidad);
		//$('#DMStock').val(obj.DMStock);
	}
	
	function setValue(valueStart, valueEnd) {
		$('#' + valueEnd).val($('#' + valueStart).val());
	}

	function setValueSelect(valueStart, valueEnd) {
		$('#' + valueEnd).val($('#' + valueStart).val()).trigger('change');
	}

	function saveTienda() {
		var objData = {
			urlshop: $('#urlshop').val(),
			data: {
				sku: $('#sku').val(),
				ShopPrecio: $('#ShopPrecio').val(),
				ShopStock: $('#ShopStock').val(),
				categoriatienda: $('#categoria-tienda').val(),
				marcatienda: $('#marca-tienda').val(),
				type: "saveTienda"
			}
		};
		$.ajax({
				method: "POST",
				url: "<?php echo base_url('MatchPricesShop/saveTienda'); ?>",
				data: objData
			})
			.done(function(data) {

			});
	}

	function saveTienda_Prices_Not() {
		var objData = {
						urlshop:$('#urlshop').val()
					  };
		$.ajax({
			method: "POST",
			url: "<?php echo base_url('MatchPricesShop/saveTiendaNotPrices'); ?>",
			data: objData
		})
		.done(function(data) {
		});
	}

	function saveDM() {
		var objData = {
			urlshop: $('#urlshop').val(),
			data: {
				sku: $('#sku').val(),
				DMPrecio: $('#DMPrecio').val(),
				DMStock: $('#DMStock').val(),
				categoriadm: $('#categoria-dm').val(),
				marcadm: $('#marca-dm').val()
			}
		};
		$.ajax({
				method: "POST",
				url: "<?php echo base_url('MatchPricesShop/saveDM'); ?>",
				data: objData
			})
			.done(function(data) {

			});
	}

	function rootCategory() {
		$.ajax({
				method: "GET",
				url: "<?php echo base_url('MatchPricesShop/rootCategory/'); ?>" + $('#sku').val(),
			})
			.done(function(data) {
				/* console.log(data);
				$('#IngramPrecio').val(data.precio);
				$('#IngramStock').val(data.disponibilidad); */
				/* MyTable.fnDestroy();
				$('#data-refactorimageshop').html(data);
				refresh(); */
				$('#rootCategory').html(data);
				$('.select2').select2();
			})
	}

	function getPriceStockIngram() {
		$.ajax({
				method: "GET",
				url: "<?php echo base_url('MatchPricesShop/getPriceStockIngram/'); ?>" + $('#sku').val(),
			})
			.done(function(data) {
				var obj = JSON.parse(data);
				$('#IngramPrecio').val(obj.precio);
				$('#IngramStock').val(obj.disponibilidad);
				/* MyTable.fnDestroy();
				$('#data-refactorimageshop').html(data);
				refresh(); */
			})
	}

	function editRow(data) {
		$('#edit_news_modal').modal('show');
		var obj = MyTableExample.rows(data).data()[0];
		$('#categoria-tienda').val(obj.CategoryShopID).trigger('change');
		$('#marca-tienda').val(obj.ManufacturerShopID).trigger('change');
		$('#categoria-dm').val(obj.CategoryDMID).trigger('change');
		$('#marca-dm').val(obj.ManufacturerDMID).trigger('change');

		$('#name').val(obj.name);
		$('#sku').val(obj.sku);
		$('#modelo').val(obj.modelo);
		$('#ShopPrecio').val(obj.ShopPrecio);
		$('#DMPrecio').val(obj.DMPrecio);
		$('#ShopStock').val(obj.ShopStock);
		$('#DMStock').val(obj.DMStock);
		$('#rootCategory').html("<iframe id=\"ingramIframe\" src=\"https://mx.ingrammicro.com/Site/ProductDetail?id=" + obj.sku + "\" width=\"200\" height=\"200\"></iframe>");

		//console.log(MyTableExample.rows(data).data()[0]);
	}

	function refresh() {
		MyTable = $('#list-data').dataTable();
	}

	function effect_msg_form() {
		// $('.form-msg').hide();
		$('.form-msg').show(1000);
		setTimeout(function() {
			$('.form-msg').fadeOut(1000);
		}, 3000);
	}

	function map_progress(){
		var timeout = setTimeout(function() {	
				$.ajax({
					method: "POST",
					url: "<?php echo base_url('MatchPricesShop/map_advance'); ?>",
				})
				.done(function(result) {
					var data = JSON.parse(result);
					$('#advance-DataShop').val(data.shop+'%');
					$('#advance-DataDM').val(data.dm+'%');
					$('#advance-DataIngram').val(data.ingram+'%');
					if(data.shop==0&&data.dm==0&&data.ingram==0){clearTimeout(timeout);}
				});
		}, 30000);
	}

	function effect_msg() {
		// $('.msg').hide();
		$('.msg').show(1000);
		setTimeout(function() {
			$('.msg').fadeOut(1000);
		}, 3000);
	}

	//****************************************************************/
	function getListDataUserSegmentation() {
		$.get('<?php echo base_url('UserSegmentation/getListData'); ?>', function(data) {
			MyTable.fnDestroy();
			$('#data-usersegmentation').html(data);
			refresh();
		});
	}

	function getListDataRefactorImageShop(data) {
		$.post('<?php echo base_url('RefactorImageShop/getListData'); ?>', data, function(data) {
			MyTable.fnDestroy();
			$('#data-refactorimageshop').html(data);
			refresh();
		});
	}

	function returnValueBool(val) {
		return (val == 'true') ? true : false;
	}

	

	var id_usersegmentation;
	$(document).on("click", ".konfirmasiHapus-usersegmentation", function() {
		id_usersegmentation = $(this).attr("data-id");
	})
	$(document).on("click", ".hapus-dataUserSegmentation", function() {
		var id = id_usersegmentation;

		$.ajax({
				method: "POST",
				url: "<?php echo base_url('UserSegmentation/delete'); ?>",
				data: "id=" + id
			})
			.done(function(data) {
				$('#konfirmasiHapus').modal('hide');
				getListDataUserSegmentation();
				$('.msg').html(data);
				effect_msg();
			})
	})

	$(document).on("click", ".update-dataUserSegmentation", function() {
		var id = $(this).attr("data-id");

		$.ajax({
				method: "POST",
				url: "<?php echo base_url('UserSegmentation/update'); ?>",
				data: "id=" + id
			})
			.done(function(data) {
				$('#temsegmentation-modal').html(data);
				$('#update-usersegmentation').modal('show');
			})
	})


	$(document).on("change", ".changeshop", function() {
		$("#urlshop").val($("#select-urlshop").val());
	})

	$(document).on("change", ".new-input-img", function() {
		var id = $(this).attr("id");
		$("#new-" + id).attr("src", $("#" + id).val());
	})

	$(document).on("click", ".new-img-thumbnail", function() {
		var id = $(this).attr("id");
		$(".img-origin").attr("src", $("#" + id).attr("src"));
		$('#modalimage').modal('show');

	})

	$(document).on("click", ".img-thumbnail", function() {
		var id = $(this).attr("id");
		$(".img-origin").attr("src", $("#" + id).attr("src"));
		$('#modalimage').modal('show');
	})

	$(document).on("click", ".get-shop", function() {
		$array_shop = [];
		if($('#filter-marcas').bootstrapSwitch('state')){$array_shop.push('marcas');}
		if($('#filter-categorias').bootstrapSwitch('state')){$array_shop.push('categorias');}
		if($('#filter-productos').bootstrapSwitch('state')){$array_shop.push('productos');}
		if($('#filter-imagenes').bootstrapSwitch('state')){$array_shop.push('imagenes');}
		if($('#filter-fichas').bootstrapSwitch('state')){$array_shop.push('fichas');}
		if($('#ficha-refactor').bootstrapSwitch('state')){$array_shop.push('ficha_refactor');}
		if($('#filter-precios').bootstrapSwitch('state')){$array_shop.push('precios');}
		if($('#imagen-null').bootstrapSwitch('state')){$array_shop.push('imagen-null');}
		$.ajax({
			method: "GET",
			url: "http://localhost/wp-api-qh/store-front/cron.php",
			data: {
				sku: $('#inputSKU').val(),
				user_id: $('#urlshop').val().split(' - ')[2],
				shop: $('#urlshop').val().split(' - ')[1],
				filtro: $array_shop.join(",")
			}
		})
		.done(function(data) {
			console.log(data);
		})
	})

	$(document).on("click", ".get-category", function() {
		$.ajax({
				method: "POST",
				url: "<?php echo base_url('RefactorImageShop/getListCategory'); ?>",
				data: {
					urlshop: $('#urlshop').val(),
					type: "getCategory"
				}
			})
			.done(function(data) {
				console.log(data);
				$('#data-category').html(data);
				$('.select2').select2();
			})
	})

	$(document).on("click", ".get-manufacturer", function() {
		$.ajax({
				method: "POST",
				url: "<?php echo base_url('RefactorImageShop/getListManufacturer'); ?>",
				data: {
					urlshop: $('#urlshop').val(),
					type: "getManufacturer"
				}
			})
			.done(function(data) {
				console.log(data);
				$('#data-manufacturer').html(data);
				$('.select2').select2();
			})
	})

	$(document).on("click", ".set-shop-prices", function() {
		saveTienda_Prices_Not();	
	})



	$(document).on("click", ".set-reg-segmentation", function() {
		var objData = {
			urlshop: $('#urlshop').val()
		};
		$.ajax({
				method: "POST",
				url: "<?php echo base_url('MatchPricesShop/setRegenerateSeg'); ?>",
				data: objData
			})
			.done(function(data) {
				MyTable.fnDestroy();
				$('#data-refactorimageshop').html(data);
				refresh();
				/* objData.type = 'getCountImage';
				$.ajax({
					method: "POST",
					url: "<?php echo base_url('RefactorImageShop/getCountData'); ?>",
					data: objData
				})
				.done(function(data) {
					console.log(data);			
				}) */
			})

		//e.preventDefault();		
	})

	$(document).on("click", ".get-image", function() {
		var objData = {
			urlshop: $('#urlshop').val(),
			data: {
				numproduct: ($('#select-changenumproduct').val() == 'All') ? '' : $('#select-changenumproduct').val(),
				SKU: $('#inputSKU').val(),
				NameProduct: $('#inputNameProduct').val(),
				Model: $('#inputModel').val(),
				filtercategory: $('#filter-category').val(),
				filtermanufacturer: $('#filter-manufacturer').val(),
				filterImageEmpty: $('#filter-ImageEmpty').bootstrapSwitch('state'),
				filteractive: $('#filter-active').bootstrapSwitch('state'),
				filterprice: $('#filter-price').bootstrapSwitch('state'),
				type: "getImage"
			}
		};
		$.ajax({
				method: "POST",
				url: "<?php echo base_url('RefactorImageShop/getListData'); ?>",
				data: objData
			})
			.done(function(data) {
				MyTable.fnDestroy();
				$('#data-refactorimageshop').html(data);
				refresh();
				/* objData.type = 'getCountImage';
				$.ajax({
					method: "POST",
					url: "<?php echo base_url('RefactorImageShop/getCountData'); ?>",
					data: objData
				})
				.done(function(data) {
					console.log(data);			
				}) */
			})

		//e.preventDefault();		
	})

	$(document).on("click", ".get-shop", function() {
		
		if($("#filter-DataServer").bootstrapSwitch('state')==false){
			//console.log($("#filter-DataServer").bootstrapSwitch('state'));
			//map_progress();
		}
		MyTableExample.ajax.reload();
	});

	$(document).on("click", ".upload-dataRefactorImageShop", function() {
		var id = $(this).attr("data-id");
		var obj = id.split("-");
		var objData = {
			urlshop: $('#urlshop').val(),
			data: {
				pImgen: $('#' + id).val(),
				product_id: obj[0],
				sku: obj[1],
				type: "uploadimage"
			}
		};

		$.ajax({
				method: "POST",
				url: "<?php echo base_url('RefactorImageShop/uploadImageShop'); ?>",
				data: /*JSON.stringify(*/ objData /*)*/
			})
			.done(function(data) {
				/* var out = jQuery.parseJSON(data);

				getListDataUserSegmentation();
				if (out.status == 'form') {				
					$('.form-msg').html(out.msg);
					effect_msg_form();				
				} else {				
					$('.msg').html(out.msg);
					effect_msg();
				} */
			})
		//e.preventDefault();

	})



	$(document).on("click", ".recategorizar", function() {
		$('#edit_news_modal').modal('show');
		/* var obj = MyTableExample.rows(data).data()[0];
		$('#categoria-tienda').val(obj.CategoryShopID).trigger('change');
		$('#marca-tienda').val(obj.ManufacturerShopID).trigger('change');
		$('#categoria-dm').val(obj.CategoryDMID).trigger('change');
		$('#marca-dm').val(obj.ManufacturerDMID).trigger('change');

		$('#name').val(obj.name);
		$('#sku').val(obj.sku);
		$('#modelo').val(obj.modelo);
		$('#ShopPrecio').val(obj.ShopPrecio);
		$('#DMPrecio').val(obj.DMPrecio);
		$('#ShopStock').val(obj.ShopStock);
		$('#DMStock').val(obj.DMStock);
		$('#rootCategory').html("<iframe id=\"ingramIframe\" src=\"https://mx.ingrammicro.com/Site/ProductDetail?id=" + obj.sku + "\" width=\"200\" height=\"200\"></iframe>"); */

	})

	$(document).on("click", ".email-dataUserSegmentation", function() {
		var id = $(this).attr("data-id");

		$.ajax({
				method: "POST",
				url: "<?php echo base_url('Email/send'); ?>",
				data: "id=" + id
			})
			.done(function(data) {
				var out = jQuery.parseJSON(data);

				getListDataUserSegmentation();
				if (out.status == 'form') {
					$('.form-msg').html(out.msg);
					effect_msg_form();
				} else {
					$('.msg').html(out.msg);
					effect_msg();
				}
			})
		//e.preventDefault();
	})

	$('#form-usersegmentation').submit(function(e) {
		var data = $(this).serialize();
		//console.log(data);
		$.ajax({
				method: 'POST',
				url: '<?php echo base_url('UserSegmentation/addUserSegmentation'); ?>',
				data: data
			})
			.done(function(data) {
				var out = jQuery.parseJSON(data);

				getListDataUserSegmentation();
				if (out.status == 'form') {
					$('.form-msg').html(out.msg);
					effect_msg_form();
				} else {
					$('#usersegmentation').modal('hide');
					$('.msg').html(out.msg);
					effect_msg();
				}
			})
		e.preventDefault();
	});

	$(document).on('submit', '#form-update-usersegmentation', function(e) {
		var data = $(this).serialize();

		$.ajax({
				method: 'POST',
				url: '<?php echo base_url('UserSegmentation/updateUserSegmentation'); ?>',
				data: data
			})
			.done(function(data) {
				var out = jQuery.parseJSON(data);

				getListDataUserSegmentation();
				if (out.status == 'form') {
					$('.form-msg').html(out.msg);
					effect_msg_form();
				} else {
					document.getElementById("form-update-usersegmentation").reset();
					$('#update-usersegmentation').modal('hide');
					$('.msg').html(out.msg);
					effect_msg();
				}
			})

		e.preventDefault();
	});

	$('#update-usersegmentation').on('hidden.bs.modal', function(e) {
		//$('.form-msg').html('');	  
	}).on('shown.bs.modal', function(e) {
		//$("#form-usersegmentation").get(0).reset();
	})
	//****************************************************************/

	$('.select2').select2();
</script>