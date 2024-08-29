
<?php 
 $branch_list = new ControllerPastdue();
 $branch = $branch_list->ctrShowBranches();




 $permit = (new Connection)->connect()->query("SELECT * from past_due ORDER BY id Desc limit 1")->fetch(PDO::FETCH_ASSOC);
          if(empty($permit)){
            $id = 0;
          }else{
            $id = $permit['id'];
          }
         $last_id = $id + 1;
          $id_holder = "PD" . str_repeat("0",5-strlen($last_id)).$last_id;     

          date_default_timezone_set('Asia/Manila');
		      $date_now =date("F d Y"); 

          $user_id = $_SESSION['user_id'];
          $branch_name = $_SESSION['branch_name'];
?> 
<style>
  .modal-content {
    width: 1000px;
   
} 

</style>
<div class="clearfix"></div>
  
<div class="content-wrapper">
   <div class="container-fluid">
     <div class="row pt-2 pb-2">
        <div class="col-sm-12">
          <h4 class="page-title">PAST DUE COLLECTION</h4>
        </div>
     </div>

      <div class="row">
        <div class="col-lg-12">
        
          <div class="card">
            <div class="card-header float-sm-right">
              <div class="row">
                <?php 
                
                if($_SESSION['type']=="admin" || $_SESSION['type']=="pastdue_user" || $_SESSION['type']=="backup_admin"){?>
                  <!-- <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1" data-toggle="modal" data-target="#exampleModalCenter"><i class="fa fa-plus"></i> <span>&nbsp;ADD DATABASE</span> </button>
                  <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1" data-toggle="modal" data-target="#ledgerModal"><i class="fa fa-book"></i> <span>&nbsp;ADD LEDGER</span> </button> -->
                  <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1" onClick="location.href='pastdueadd'"><i class="fa fa-user-plus"></i></i> <span>&nbsp;ADD ACCOUNTS</span> </button>
                  <button type="button" id="showPrint"  class="btn btn-light btn-round waves-effect waves-light m-1" onClick="location.href='pastduetarget'"><i class="fa fa-plus-circle"></i> <span>&nbsp;BRANCH TARGETS</span> </button>
                  <button type="button" id="showPrint"  class="btn btn-light btn-round waves-effect waves-light m-1" onClick="location.href='pastdueclassreport'"><i class="fa fa-print"></i> <span>&nbsp;CLASS REPORT</span> </button>
                  <button type="button" id="showPrint"  class="btn btn-light btn-round waves-effect waves-light m-1" onClick="location.href='pastdueweeklyreport'"><i class="fa fa-print"></i> <span>&nbsp;WEEKLY REPORTS</span> </button>
                  <button type="button" id="showPrint"  class="btn btn-light btn-round waves-effect waves-light m-1" onClick="location.href='pastduesummary'"><i class="fa fa-print"></i> <span>&nbsp;PDR PERFORMANCE SUMMARY</span> </button>
                  <button type="button" id="showPrint"  class="btn btn-light btn-round waves-effect waves-light m-1" onClick="location.href='badaccounts'"><i class="fa fa-print"></i> <span>&nbsp;SUMMARY OF BAD ACCOUNTS</span> </button>
                  <button type="button" id="showPrint"  class="btn btn-light btn-round waves-effect waves-light m-1" onClick="location.href='pastdueaccntsummary'"><i class="fa fa-address-book"></i> <span>&nbsp;PAsT DUE ACCOUNTS SUMMARY</span> </button>
                  <button type="button" id="showPrint"  class="btn btn-light btn-round waves-effect waves-light m-1" onClick="location.href='pastdueledger'"><i class="fa fa-book"></i> <span>&nbsp;LEDGER</span> </button>
                  <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1 pastdueChecker"><i class="fa fa-refresh"></i> <span>&nbsp;CHECK DUPLICATES</span> </button>
                  <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1 pastdueChecker1"><i class="fa fa-refresh"></i> <span>&nbsp;CHECK LEDGER</span> </button>
                  <button type="button" class="btn btn-light btn-round waves-effect waves-light m-1" data-toggle="modal" data-target="#pastdueChecker2"><i class="fa fa-refresh"></i> <span>&nbsp;CHECK FULLY PAID</span> </button>

              <?php  }?>
               
            </div>            
            <div class="card-body">
              <div class="table-responsive">
              <table id="default-datatable" class="table table-bordered table-hover table-striped pastdueTable">
                <thead>
                <tr>
                  <th>ACCOUNT NUMBER</th>
                  <th>NAME</th>
                  <th>TYPE</th>
                  <th>CLASS</th>
                  <th>BANK</th>
                  <th>ENDORSED</th>
                  <th>BRANCH</th>
                  <th>Action</th>
                </tr>
                </thead>
              </table>
            </div>
            </div>
          </div>
        </div>
                
      </div>    <!-- row -->
      <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
             <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">ADD DATABASE</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                <form  method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-sm-12 form-group">
                    <label   label for="input-6">BRANCH NAME</label>
                    <select class="form-control" name="branch_name" id="branch_name" required>
                      <option value=""><  - - SELECT BRANCHES - - ></option>
                      <?php
                        foreach ($branch as $key => $row) {
                          # code...
                          $full_name = $row['full_name'];
                      ?>
                      <option value="<?php echo $full_name;?>"><?php echo $full_name;?></option>
                     <?php } ?>
                    </select>
                
                    </div>   
            </div> 
                <div class="row">
                    <div class="col-sm-12 form-group">
                        <input type="text" hidden name="id" id="id" value="<?php echo $id; ?>">
                        <input type="text" hidden name="user_id" id="user_id" value="<?php echo $user_id; ?>">
                        <label for="input-6">DATABASE FILES</label>
                        <input type="file" class="form-control" id="file" placeholder="Enter Folder Name" name="file" value="Import">
                    </div>   
            </div> 
                </div>
                <div class="modal-footer">
                        <button type="submit" name ="addPastDue" class="btn btn-primary">Submit</button>
                        <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
              </form>
              <?php
                     $addPastDue = new ControllerPastdue();
                     $addPastDue -> addPastDueRecords();
                    ?>
           </div>
        </div>
     <!-- LEDGER MODAL -->
     <div class="modal fade" id="ledgerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
             <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">ADD LEDGER</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <div class="modal-body">
                <form  method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-sm-12 form-group">
                    <label   label for="input-6">BRANCH NAME</label>
                    <select class="form-control" name="branch_name" id="branch_name" required>
                      <option value=""><  - - SELECT BRANCHES - - ></option>
                      <?php
                        foreach ($branch as $key => $row) {
                          # code...
                          $full_name = $row['full_name'];
                      ?>
                      <option value="<?php echo $full_name;?>"><?php echo $full_name;?></option>
                     <?php } ?>
                    </select>
                
                    </div>   
            </div> 
                <div class="row">
                    <div class="col-sm-12 form-group">
                        <input type="text" hidden name="user_id" id="user_id" value="<?php echo $user_id; ?>">
                        <label for="input-6">LEDGER FILES</label>
                        <input type="file" class="form-control" id="file" placeholder="Enter Folder Name" name="file" value="Import">
                    </div>   
            </div> 
                </div>
                <div class="modal-footer">
                        <button type="submit" name ="addLedger" class="btn btn-primary">Submit</button>
                        <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
              </form>
              <?php
                     $addLedger = new ControllerPastdue();
                     $addLedger -> addLedgerRecord();
                    ?>
           </div>
        </div>
     <!-- END LEDGER MODAL -->

     <!-- CHECKER MODAL -->
     <div class="modal fade" id="pastdueChecker" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
             <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">CHECK DUPLICATION OF ACCOUNTS</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <form  method="post" enctype="multipart/form-data">
                <div class="modal-body">
                <table id="default-datatable" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>BRANCH NAME</th>
                                <th>LAST NAME</th>
                                <th>FIRST NAME</th>
                                <th>COUNT</th>
                            </tr>
                        </thead>
                        <tbody class="checkerBody">
                          
                        </tbody>
                      
                    </table>
                </div>         
                <div class="modal-footer">
                    <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
              </form>
             
           </div>
        </div>
     <!-- END CHECKER MODAL -->

       <!-- CHECKER MODAL1 -->
       <div class="modal fade" id="pastdueChecker1" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
             <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">CHECK LEDGER RECORDS</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <form  method="post" enctype="multipart/form-data">
                <div class="modal-body">
                <table id="default-datatable" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>ACCOUNT NUMBER</th>
                                <th>BRANCH NAME</th>
                            </tr>
                        </thead>
                        <tbody class="checkerBody">
                          
                        </tbody>
                      
                    </table>
                </div>         
                <div class="modal-footer">
                    <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
              </form>
             
           </div>
        </div>
     <!-- END CHECKER MODAL1 -->


        <!-- CHECKER MODAL2 -->
        <div class="modal fade" id="pastdueChecker2" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered" role="document">
             <div class="modal-content">
                <div class="modal-header">
                   <h5 class="modal-title" id="exampleModalLongTitle">CHECK FULLY PAID</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                        </button>
                </div>
                <form  method="post" enctype="multipart/form-data">
                <div class="modal-body">
                <div class="row">
                <div class="col-sm-12 form-group">
                    <label   label for="input-6">BRANCH NAME</label>
                    <select class="form-control branch_name_checker" name="branch_name" id="branch_name_checker" required>
                      <option value=""><  - - SELECT BRANCHES - - ></option>
                      <?php
                        foreach ($branch as $key => $row) {
                          # code...
                          $full_name = $row['full_name'];
                      ?>
                      <option value="<?php echo $full_name;?>"><?php echo $full_name;?></option>
                     <?php } ?>
                    </select>
                
                    </div> 
                </div>
                  

                <table id="default-datatable" class="table table-bordered table-hover table-striped">
                        <thead>
                            <tr>
                                <th>BRANCH NAME</th>
                                <th>ACCOUNT NUMBER</th>
                                <th>LAST NAME</th>
                                <th>TOTAL BALANCE</th>
                            </tr>
                        </thead>
                        <tbody class="checkerBody">
                          
                        </tbody>
                      
                    </table>
                </div>         
                <div class="modal-footer">
                    <button type="button"  class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
              </form>
             
           </div>
        </div>
     <!-- END CHECKER MODAL1 -->


       
</div>

    <div class="overlay toggle-menu"></div>


  </div>        <!-- container-fluid -->
</div>          <!-- content-wrapper -->

<?php
 
  $deletePastDue = new ControllerPastdue();
  $deletePastDue  -> ctrDeletePastdue();
  
?>


  
