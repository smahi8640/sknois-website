<!DOCTYPE html>
<html lang="en">
<head>

    <?= $this->include('admin/partial/head') ?>

</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    
  <?= $this->include('admin/partial/top') ?>

  <?= $this->include('admin/partial/sidemenu') ?>

  <?= $this->include('admin/partial/title') ?> 
    <div class="row">
          <div class="col-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"></h3>
                    <form id="banner-add" enctype="multipart/form-data">
                        <div class="row">
                            <div class="form-group col-md-7">
                                <label>Image</label>
                                 <div class="input-group">
                                    <input type="file" name="image[]"  multiple="" class="form-control image_path" id="image">
                                </div>
                            </div>
                            <div class="form-group col-md-5">
                                <button type="submit" class="btn btn-success" style="margin-top:30px;"><i class="fa fa-cloud"></i> Upload</button>
                            </div>    
                        </div>
                    </form>
                  </div>
                </div>
            </div> 
            <div class="col-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"></h3>
                    <form id="banner-add-rings" enctype="multipart/form-data">
                        <div class="row">
                            <div class="form-group col-md-7">
                                <label>Image</label>
                                 <div class="input-group">
                                    <input type="file" name="image[]"  multiple="" class="form-control image_path" id="image">
                                </div>
                            </div>
                            <div class="form-group col-md-5">
                                <button type="submit" class="btn btn-success" style="margin-top:30px;"><i class="fa fa-cloud"></i> RINGS</button>
                            </div>    
                        </div>
                    </form>
                  </div>
                </div>
            </div> 
            <div class="col-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"></h3>
                    <form id="banner-add-pendants" enctype="multipart/form-data">
                        <div class="row">
                            <div class="form-group col-md-7">
                                <label>Image</label>
                                 <div class="input-group">
                                    <input type="file" name="image[]"  multiple="" class="form-control image_path" id="image">
                                </div>
                            </div>
                            <div class="form-group col-md-5">
                                <button type="submit" class="btn btn-success" style="margin-top:30px;"><i class="fa fa-cloud"></i> PENDANTS</button>
                            </div>    
                        </div>
                    </form>
                  </div>
                </div>
            </div>
            <div class="col-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"></h3>
                    <form id="banner-add-necklaces" enctype="multipart/form-data">
                        <div class="row">
                            <div class="form-group col-md-7">
                                <label>Image</label>
                                 <div class="input-group">
                                    <input type="file" name="image[]"  multiple="" class="form-control image_path" id="image">
                                </div>
                            </div>
                            <div class="form-group col-md-5">
                                <button type="submit" class="btn btn-success" style="margin-top:30px;"><i class="fa fa-cloud"></i> NECKLACES</button>
                            </div>    
                        </div>
                    </form>
                  </div>
                </div>
            </div>
            <div class="col-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"></h3>
                    <form id="banner-add-misc" enctype="multipart/form-data">
                        <div class="row">
                            <div class="form-group col-md-7">
                                <label>Image</label>
                                 <div class="input-group">
                                    <input type="file" name="image[]"  multiple="" class="form-control image_path" id="image">
                                </div>
                            </div>
                            <div class="form-group col-md-5">
                                <button type="submit" class="btn btn-success" style="margin-top:30px;"><i class="fa fa-cloud"></i> MISC</button>
                            </div>    
                        </div>
                    </form>
                  </div>
                </div>
            </div>
            <div class="col-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"></h3>
                    <form id="banner-add-earrings" enctype="multipart/form-data">
                        <div class="row">
                            <div class="form-group col-md-7">
                                <label>Image</label>
                                 <div class="input-group">
                                    <input type="file" name="image[]"  multiple="" class="form-control image_path" id="image">
                                </div>
                            </div>
                            <div class="form-group col-md-5">
                                <button type="submit" class="btn btn-success" style="margin-top:30px;"><i class="fa fa-cloud"></i> EARRINGS</button>
                            </div>    
                        </div>
                    </form>
                  </div>
                </div>
            </div>
            <div class="col-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"></h3>
                    <form id="banner-add-charms" enctype="multipart/form-data">
                        <div class="row">
                            <div class="form-group col-md-7">
                                <label>Image</label>
                                 <div class="input-group">
                                    <input type="file" name="image[]"  multiple="" class="form-control image_path" id="image">
                                </div>
                            </div>
                            <div class="form-group col-md-5">
                                <button type="submit" class="btn btn-success" style="margin-top:30px;"><i class="fa fa-cloud"></i> CHARMS</button>
                            </div>    
                        </div>
                    </form>
                  </div>
                </div>
            </div>
            <div class="col-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"></h3>
                    <form id="banner-add-bracelets" enctype="multipart/form-data">
                        <div class="row">
                            <div class="form-group col-md-7">
                                <label>Image</label>
                                 <div class="input-group">
                                    <input type="file" name="image[]"  multiple="" class="form-control image_path" id="image">
                                </div>
                            </div>
                            <div class="form-group col-md-5">
                                <button type="submit" class="btn btn-success" style="margin-top:30px;"><i class="fa fa-cloud"></i> BRACELETS</button>
                            </div>    
                        </div>
                    </form>
                  </div>
                </div>
            </div>
            <div class="col-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title"></h3>
                    <form id="banner-add-category" enctype="multipart/form-data">
                        <div class="row">
                            <div class="form-group col-md-7">
                                <label>Image</label>
                                 <div class="input-group">
                                    <input type="file" name="image[]"  multiple="" class="form-control image_path" id="image">
                                </div>
                            </div>
                            <div class="form-group col-md-5">
                                <button type="submit" class="btn btn-success" style="margin-top:30px;"><i class="fa fa-cloud"></i> CATEGORY</button>
                            </div>    
                        </div>
                    </form>
                  </div>
                </div>
            </div>
        </div>    

	<div class="embed-responsive embed-responsive-16by9 mb-4">
		<iframe class="embed-responsive-item" src="<?php echo base_url('assets/'); ?>/filemanager/dialog.php?type=2&field_id=fieldID&crossdomain=1"></iframe>
	</div>
	
  <?= $this->include('admin/partial/footer') ?> 

  <aside class="control-sidebar control-sidebar-dark">
    
  </aside>
  
</div>

<?= $this->include('admin/partial/js') ?> 
<script>
	$(document).ready(function(){


	$(document).on("submit","#banner-add",function(e){
        e.preventDefault();
        $.ajax({
            url:'<?php echo base_url().'/admin/media/upload'?>',
            method:"POST",
            data:new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
            $("#mab1").show();          
        },
          success(response){
            var obj =  JSON.parse(response);
            console.log(obj);
            if(obj.status){
                setTimeout(function(){
                    swal({
                        title: "Message!",
                        text: obj.message,
                        type: "success"
                    }).then(function() {
                        window.location = "<?php echo base_url().'/admin/media'?>";
                    });
           
                },1000);
                  
            }else{
              swal(obj.message, {
                  icon: "error",
              });
              
            }
          }
        })
      })
      
    
    $(document).on("submit","#banner-add-earrings",function(e){
        e.preventDefault();
        $.ajax({
            url:'<?php echo base_url().'/admin/media/earrings'?>',
            method:"POST",
            data:new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
            $("#mab1").show();          
        },
          success(response){
            var obj =  JSON.parse(response);
            console.log(obj);
            if(obj.status){
                setTimeout(function(){
                    swal({
                        title: "Message!",
                        text: obj.message,
                        type: "success"
                    }).then(function() {
                        window.location = "<?php echo base_url().'/admin/media'?>";
                    });
           
                },1000);
                  
            }else{
              swal(obj.message, {
                  icon: "error",
              });
              
            }
          }
        })
      })
      
      $(document).on("submit","#banner-add-rings",function(e){
        e.preventDefault();
        $.ajax({
            url:'<?php echo base_url().'/admin/media/rings'?>',
            method:"POST",
            data:new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
            $("#mab1").show();          
        },
          success(response){
            var obj =  JSON.parse(response);
            console.log(obj);
            if(obj.status){
                setTimeout(function(){
                    swal({
                        title: "Message!",
                        text: obj.message,
                        type: "success"
                    }).then(function() {
                        window.location = "<?php echo base_url().'/admin/media'?>";
                    });
           
                },1000);
                  
            }else{
              swal(obj.message, {
                  icon: "error",
              });
              
            }
          }
        })
      })
      
      $(document).on("submit","#banner-add-pendants",function(e){
        e.preventDefault();
        $.ajax({
            url:'<?php echo base_url().'/admin/media/pendants'?>',
            method:"POST",
            data:new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
            $("#mab1").show();          
        },
          success(response){
            var obj =  JSON.parse(response);
            console.log(obj);
            if(obj.status){
                setTimeout(function(){
                    swal({
                        title: "Message!",
                        text: obj.message,
                        type: "success"
                    }).then(function() {
                        window.location = "<?php echo base_url().'/admin/media'?>";
                    });
           
                },1000);
                  
            }else{
              swal(obj.message, {
                  icon: "error",
              });
              
            }
          }
        })
      })
      
      $(document).on("submit","#banner-add-necklaces",function(e){
        e.preventDefault();
        $.ajax({
            url:'<?php echo base_url().'/admin/media/necklaces'?>',
            method:"POST",
            data:new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
            $("#mab1").show();          
        },
          success(response){
            var obj =  JSON.parse(response);
            console.log(obj);
            if(obj.status){
                setTimeout(function(){
                    swal({
                        title: "Message!",
                        text: obj.message,
                        type: "success"
                    }).then(function() {
                        window.location = "<?php echo base_url().'/admin/media'?>";
                    });
           
                },1000);
                  
            }else{
              swal(obj.message, {
                  icon: "error",
              });
              
            }
          }
        })
      })
      
      $(document).on("submit","#banner-add-misc",function(e){
        e.preventDefault();
        $.ajax({
            url:'<?php echo base_url().'/admin/media/misc'?>',
            method:"POST",
            data:new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
            $("#mab1").show();          
        },
          success(response){
            var obj =  JSON.parse(response);
            console.log(obj);
            if(obj.status){
                setTimeout(function(){
                    swal({
                        title: "Message!",
                        text: obj.message,
                        type: "success"
                    }).then(function() {
                        window.location = "<?php echo base_url().'/admin/media'?>";
                    });
           
                },1000);
                  
            }else{
              swal(obj.message, {
                  icon: "error",
              });
              
            }
          }
        })
      })
      
      $(document).on("submit","#banner-add-charms",function(e){
        e.preventDefault();
        $.ajax({
            url:'<?php echo base_url().'/admin/media/charms'?>',
            method:"POST",
            data:new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
            $("#mab1").show();          
        },
          success(response){
            var obj =  JSON.parse(response);
            console.log(obj);
            if(obj.status){
                setTimeout(function(){
                    swal({
                        title: "Message!",
                        text: obj.message,
                        type: "success"
                    }).then(function() {
                        window.location = "<?php echo base_url().'/admin/media'?>";
                    });
           
                },1000);
                  
            }else{
              swal(obj.message, {
                  icon: "error",
              });
              
            }
          }
        })
      })
      
      $(document).on("submit","#banner-add-bracelets",function(e){
        e.preventDefault();
        $.ajax({
            url:'<?php echo base_url().'/admin/media/bracelets'?>',
            method:"POST",
            data:new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
            $("#mab1").show();          
        },
          success(response){
            var obj =  JSON.parse(response);
            console.log(obj);
            if(obj.status){
                setTimeout(function(){
                    swal({
                        title: "Message!",
                        text: obj.message,
                        type: "success"
                    }).then(function() {
                        window.location = "<?php echo base_url().'/admin/media'?>";
                    });
           
                },1000);
                  
            }else{
              swal(obj.message, {
                  icon: "error",
              });
              
            }
          }
        })
      })
      
      $(document).on("submit","#banner-add-category",function(e){
        e.preventDefault();
        $.ajax({
            url:'<?php echo base_url().'/admin/media/category'?>',
            method:"POST",
            data:new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            beforeSend: function(){
            $("#mab1").show();          
        },
          success(response){
            var obj =  JSON.parse(response);
            console.log(obj);
            if(obj.status){
                setTimeout(function(){
                    swal({
                        title: "Message!",
                        text: obj.message,
                        type: "success"
                    }).then(function() {
                        window.location = "<?php echo base_url().'/admin/media'?>";
                    });
           
                },1000);
                  
            }else{
              swal(obj.message, {
                  icon: "error",
              });
              
            }
          }
        })
      })
        
        $('.modal').on('hidden.bs.modal', function(){
        $(this).find('form')[0].reset();
    });

        
	})
</script>
</body>
</html>