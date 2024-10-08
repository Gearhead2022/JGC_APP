
<?php
$branch_AVL = new ControllerPensioner();

?>
<style>
  .modal-content {
    width: 1000px;
   
} .addBox {
    border-color: white;

    border-style: groove;
}
#per{
    font-size: 10px;
}

</style>
<div class="clearfix"></div>
  
<div class="content-wrapper">
   <div class="container-fluid">
     <div class="row pt-2 pb-2">
        <div class="col-sm-12">
          <h4 class="page-title">DAILY AVAILMENTS</h4>
        </div>
     </div>

      <div class="row">

        <div class="col-lg-12">
        
          <div class="card">
            <div class="card-header float-sm-right">
              <div class="row">
                <?php if($_SESSION['type']=="admin" || $_SESSION['type']=="backup_user" || $_SESSION['type']=="backup_admin"){?>
                  <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1" data-toggle="modal" data-target="#addDatabaseModal"><i class="fa fa-plus"></i> <span>&nbsp;ADD DATABASE</span> </button>
                  <!-- <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1" onclick="window.location.href=('./branchAPHFilter');"><i class="fa fa-filter"></i> <span>&nbsp;FILTER DATA</span> </button> -->
                <?php  }?>
                  <div class="col-sm-2 form-group" style="padding-top: 10px;margin-bottom: 6px;">
              </div>
            </div>  
            <!-- <div class="row">
                <div class="col-sm-2 form-group">
                      <label for="input-6">SELECT DATE</label>
                      <input type="date" class="form-control monthEnd" id="avl_date"  placeholder="Enter Date"  name="avl_date" autocomplete="nope" required>
              </div>
                <div class="col-sm-2 form-group mt-4">
                  <button type="button" name="generateDailyAvailments" class="btn btn-light btn-round waves-effect waves-light m-1 generateDailyAvailments"><i class="fa fa-print"></i> <span>&nbsp;GENERATE</span> </button>
                </div>
              </div>            -->
            <div class="card-body">
              <div class="col-sm-12">
                <p class="page-">LIST OF UPLOADED DAILY AVAILMENTS</p>
            </div>
            <hr />
            <div class="table-responsive">
              <table id="default-datatable" class="table table-bordered table-hover table-striped dailyAvailmentsTable">
                <thead>
                <tr>
                  <th>Branch Name</th>
                  <th>Entry Data</th>
                  <th>Entry Date</th>
                  <th>Upload Date</th>
                  <th>Actions</th>
                </tr>
                </thead>
              </table>
            </div>
          

            </div>
          </div>
        </div>
      </div> 


  <!-- START modal for add beginning balance-->
      <div class="modal fade" id="addDatabaseModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
             <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">ADD DATABASE</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                <form  method="post"  enctype="multipart/form-data">
                <div class="row">
                <div class="col-sm-6 form-group">
                      <label for="input-6">BRANCH NAME</label>
                      <input type="tect" class="form-control" id="branch_name" readonly value="<?php echo $_SESSION['branch_name'];?>" required placeholder="Enter Folder Name" name="branch_name">
                </div>
                <div class="col-sm-6 form-group">
                      <label for="input-6">SELECT DATE</label>
                      <input type="date" class="form-control" id="date" required placeholder="Enter Folder Name" name="date">
                </div>
                    <div class="col-sm-12 mt-2">
                        <label for="input-6">DATABASE FILES</label>
                        <input type="file" class="form-control" id="file" required placeholder="Enter Folder Name" name="file" value="Import">
                    </div>
                          
            </div> 
                </div>
                <div class="modal-footer">
                        <button type="submit" name ="addAvl" class="btn btn-primary">Submit</button>
                        <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
              </form>
              <?php
                    $branch_AVL -> ctrAddBranchDailyAvailments();
                    ?>
           </div>
        </div>


    <div class="overlay toggle-menu"></div>


  </div>        <!-- container-fluid -->
</div>          <!-- content-wrapper -->
</div>

<?php
 

  $branch_AVL  -> ctrDeleteAPH();
  
?>


  
