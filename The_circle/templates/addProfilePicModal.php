
<!-- Modal -->
<div id="addProfilePicModal"  class="modal fade addProfilePicModal" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <form id="uploadimage"  method="post" enctype="multipart/form-data">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h3 class="modal-title">Add a profile picture</h3>
        <p>A profile picture lets your friend recognize you</p>
        <input id="pictureInput" name ="pictureInput" type="file" style="position: fixed; top: -100em">
        <a href= "#"id ="choosePicture"><img src="resources/images/icons/addprofilePicture.png"></a>   

        <button id = "upload" class= "btn btn-lg btn-success" type="submit" name="submit">Add</button>
        <a href="" id = "skip">Skip for now</a>
      </form>
     
      
    </div>

  </div>
</div>