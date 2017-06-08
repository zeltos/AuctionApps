<div id="gallery-modal" class="modal modal-fixed-footer">
  <div class="modal-content">
    <h4 style="margin:0;">Image Gallery </h4>
    <span class="sptr"></span>
    <ul class="tabs-img">
      <li><a href="#content-upload" id="open-upload" class="waves-effect waves-teal btn-flat"><i class="material-icons left">important_devices</i> Upload New Image</a></li>
      <li><a href="#content-gallery" id="open-media" class="waves-effect waves-teal btn-flat active"> <i class="material-icons left">perm_media</i>Insert From Gallery</a></li>
    </ul>
    <script type="text/javascript">
    $(document).ready(function(){
      $('.tabs-img').tabs();
    });
    </script>
    <div id="content-gallery"  style="display:block;">
      <div class="gallery-wrap row"></div>
    </div>

    <div id="content-upload" style="display:none;">
      <form action="{{ url('/image/post/') }}" class="dropzone" id="my-dropzone">{{ csrf_field() }}</form>
      <div class="grid-cover" style="margin-bottom:30px;">
        <a class="waves-effect waves-light btn" id="submitFile" style="display:none;"><i class="material-icons left">cloud</i>Upload File</a>
      </div>
    </div>

  </div>
  <div class="modal-footer">
    <a class="modal-action modal-close waves-effect waves-green btn-flat ">Close</a>
  </div>
</div>
<script type="text/javascript">
  $('#gallery-modal').modal({
      startingTop: '4%', // Starting top style attribute
      endingTop: '10%' // Ending top style attribute
    }
  );
</script>
<script type="text/javascript">
jQuery(document).ready(function($){
  Dropzone.options.myDropzone = {
   autoProcessQueue: false,
     init: function() {
         var _this = this;
         this.on("addedfile", function(file) { $('#submitFile').fadeIn(); });
         this.on("success", function(file) {
             setTimeout(function () {
              _this.removeFile(file);
              console.log(file.name);
              getImageWasAdd(file.name)
              $('#open-media').trigger('click');
            }, 1500);
         });
         $('#submitFile').click(function(event) {
           _this.processQueue();
           $('#submitFile').fadeOut();
         });

       }
     };

     $('#open-upload').click(function(event) {
       $('#content-gallery').fadeOut(0);
     });
  });

  jQuery(window).load(function($) {
    getListImage();
  })

  function getImageWasAdd(file) {
    var url = '<?php echo url('/image/get/'); ?>';
    var urlImages ='<?php echo URL::asset('/images/'); ?>';
    $.get(url+'/'+file, function( data ) {
      console.log(data);
      for (var i = 0; i < data.length; i++) {
        $('.gallery-wrap').append("<div class='img-data col l3'><a onClick='addToGallery("+data[i].images_id+")' class=' item-image' dataid='"+ data[i].images_id +"' id='image_id-"+ data[i].images_id +"'><img src='"+urlImages+"/"+data[i].images +"'></a><span class='deleteImg' title='delete this image' onclick='deleteFile("+data[i].images_id+")'><i class='material-icons'>delete</i></span></div>");
      }
    });
  }

  function deleteFile(id){
    var isConfirm = confirm("are you sure to delete this file?");
    if (!isConfirm) {
      return;
    }

    var url = '<?php echo url('/image/delete'); ?>';
    $.get(url + '/' + id, function(data){
      console.log(data);
      if (data=="success") {
        $('#image_id-'+id).parent('.img-data').remove();
      }
    });
  }

  function getListImage() {
    var url = '<?php echo url('/image/get'); ?>';
    var urlImages ='<?php echo URL::asset('/images/'); ?>';
    $.get(url, function( data ) {
      console.log(data);
      for (var i = 0; i < data.length; i++) {
        console.log(data[i]);
        $('.gallery-wrap').append("<div class='img-data col l3'><a onClick='addToGallery("+data[i].images_id+")' class=' item-image' dataid='"+ data[i].images_id +"' id='image_id-"+ data[i].images_id +"'><img src='"+urlImages+"/"+data[i].images +"'></a><span class='deleteImg' title='delete this image' onclick='deleteFile("+data[i].images_id+")'><i class='material-icons'>delete</i></span></div>");
      }
      // function check has inserted
      hasInserted();
    });
  }

  function hasInserted() {
    console.log('check has inserted');
    $('.item-image').removeClass('hasInserted');
    $('.gallery-item').each(function(index, el) {
      var id_element = $(this).attr('image-id');
      console.log(id_element);
      $('#image_id-'+id_element).addClass('hasInserted');
    });
  }

  function addToGallery(id) {
    console.log("add to Gallery");
    var allowtoInsert = false;
    jQuery('.gallery-item').each(function(index, el) {
      if ($(this).attr('image-id') == id) {
        console.log('this image already inserted');
      } else {
        allowtoInsert = true;
      }
    });
    if ($('.gallery-item').length == 0) {
      allowtoInsert = true;
    }
    if (allowtoInsert == true) {
        var image = $('#image_id-'+id).find('img').attr('src');
        $('#image_id-'+id).addClass('hasInserted');
        $(".list-images-gallery").append("<div class='col l6 gallery-item' image-id='"+id+"'><span class='deleteGallery' onclick='removeAuctionImage("+id+")'><i class='material-icons'>delete</i></span><input type='hidden' name='images_id[]' value='"+id+"'>  <img src='"+image+"' style='width:100%;'></div>");
        console.log(image);
    }
  }

</script>
