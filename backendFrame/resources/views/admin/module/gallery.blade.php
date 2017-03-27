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
      <form action="{{ url('/image/post/') }}" class="dropzone" id="my-dropzone"></form>
      <div class="grid-cover" style="margin-bottom:30px;">
        <a class="waves-effect waves-light btn" id="submitFile" style="display:none;"><i class="material-icons left">cloud</i>Upload File</a>
      </div>
    </div>

  </div>
  <div class="modal-footer">
    <a href="#!" class="modal-action modal-close waves-effect waves-green btn-flat ">Agree</a>
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

  function getListImage() {
    var url = '<?php echo url('/image/get'); ?>';
    var urlImages ='<?php echo URL::asset('/images/'); ?>';
    $.get(url, function( data ) {
      console.log(data);
      for (var i = 0; i < data.length; i++) {
        console.log(data[i]);
        $('.gallery-wrap').append("<a onClick='addToGallery("+data[i].id +", "+ data[i].images+")' class='col l3 item-image' id='image_id-"+ data[i].id +"'><img src='"+urlImages+"/"+data[i].images +"'></a>");
      }
    });
  }

  function addToGallery(id, images) {
    
  }

</script>
