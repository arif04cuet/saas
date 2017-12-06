{{ content() }}
<style>
.table input[type="text"], input[type="password"], input[type="email"], textarea, select{
	width: auto!important;
}
</style>
<div class="printArea">
    <style>
        @media print {

            .table {
                width: 100%;
                margin-bottom: 20px;
            }
            .table-bordered {
                border: 1px solid #ddd;
                border-collapse: separate;
                border-left: 0;
                -webkit-border-radius: 4px;
                -moz-border-radius: 4px;
                border-radius: 4px;
            }
            .table th, .table td {
                padding: 8px;
                line-height: 20px;
                text-align: left;
                vertical-align: top;
                border-top: 1px solid #ddd;
            }
            .no-print, .no-print *
            {
                display: none !important;
            }
        }
    </style>
	<?php $uploadPath = '/npfadmin/app/cache/files/bcsadminacademy.portal.gov.bd/applications/';?>
    <div class="row">
        <div class="col-md-12">
        <?php $application = unserialize($applications['fields']); ?>
            <h3><?php echo $application['courseName']?>
                <button style="float: right" id="print" class="btn no-print">Print</button>
            </h3>

            <h4 style="font-weight:normal;">
                Government of the People's Republic of Bangladesh <br>
                <strong>Bangladesh Civil Service Administration Academy</strong> <br>
                <u>Shahbag, Dhaka-1000.</u>
                <br>Date : <?php echo date("d-m-Y");?>
            </h4>
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <img style="display: block;width: 200px;height: 230px" src="<?php echo $uploadPath.$application['img']?>" alt="trainee photo">
            <br>
            <table class="table table-bordered">
                <tr>
                    <td><b>Course Name</b></td>
                    <td><?php echo $application['courseName']?></td>
                    <td><b>Trainee Name(Eng)</b></td>
                    <td><?php echo $application['applicantName']?></td>
                </tr>
                <tr>
                    <td><b>Trainee Name(Bangla) </b></td>
                    <td><?php echo $application['txtStuNameBn']?></td>
                    <td><b>Batch</b></td>
                    <td><?php echo $application['txtStuBatch']?></td>
                </tr>
                <tr>
                    <td><b>ID No. </b></td>
                    <td><?php echo $application['txtStuId']?></td>
                    <td><b>Father Name</b></td>
                    <td><?php echo $application['txtStuFName']?></td>
                </tr>

                <tr>
                    <td><b>Mother Name </b></td>
                    <td><?php echo $application['txtStuMName']?></td>
                    <td><b>Date Of Birth</b></td>
                    <td><?php echo $application['txtDateOfBirthYear']?></td>
                </tr>

                <tr>
                    <td><b>Sex </b></td>
                    <td><?php echo $application['rdSex']?></td>
                    <td><b>Material status</b></td>
                    <td><?php echo $application['txtMaterialStatus']?></td>
                </tr>


                <tr>
                    <td><b>Present Address</b></td>
                    <td><?php echo $application['txtPresentAdd']?></td>
                    <td><b>Permanent Address</b></td>
                    <td><?php echo $application['txtPermanentAdd']?></td>
                </tr>

                <tr>
                    <td><b>Residence Phone No.</b></td>
                    <td><?php echo $application['txtRPhoneNo']?></td>
                    <td><b>Cell No.</b></td>
                    <td><?php echo $application['txtMobileNo']?></td>
                </tr>

                <tr>
                    <td><b>E-mail</b></td>
                    <td><?php echo $application['txtEmail']?></td>
                    <td><b>Cell No.</b></td>
                    <td><?php echo $application['txtMobileNo']?></td>
                </tr>

            </table>

            <div class="">
              <div class="col-md-8">
                <p>Educational Qualification <span style="color:#FF0000; font-size:16px">*</span></p>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <td>Exam name</td>
                      <td>Name of Institute</td>
                      <td>Board/University</td>
                      <td>Group/Subject</td>
                      <td>Result/Div/CGPA</td>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                      for($i = 1;$i<6;$i++){
                    ?>
                    <tr>
                      <td> <?php echo $application["txtExamName_$i"];?></td>
                      <td> <?php echo $application["txtExamInstitute_$i"];?></td>
                      <td> <?php echo $application["txtExamBoardUniver_$i"];?></td>
                      <td> <?php echo $application["txtGroupSubject_$i"];?></td>
                      <td> <?php echo $application["txtRes_$i"];?></td>

                    </tr>
                    <?php
                  }
                    ?>


                  </tbody>
                </table>
                <h4>Other Qualification </h4>
                <table class="table table-bordered">
                  <thead>
                    <tr>
                      <td>SL</td>
                      <td>Name</td>
                      <td>Details</td>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>1</td>
                      <td>
                        <div class="form-group">
                            Computer Knowledge
                        </div>
                      </td>
                      <td><?php echo $application["txtComputerKnowledge"];?></td>
                    </tr>
                    <tr>
                      <td>2</td>
                      <td>
                        <div class="form-group">
                            Other Knowledge
                        </div>
                      </td>
                      <td><?php echo $application["txtOtherKnowledge"];?></td>

                    </tr>

                  </tbody>
                </table>

              </div>


              <table class="table table-bordered">
                  <tr>
                      <td><b>Idea About Tranning</b></td>
                      <td><?php echo $application['txtIdeaTrain']?></td>
                      <td><b>Ambition of Training</b></td>
                      <td><?php echo $application['txtAmbTrain']?></td>
                  </tr>
                  <tr>
                      <td><b>Service Training(if any)</b></td>
                      <td><?php echo $application['txtServiceTrain']?></td>
                      <td></td>
                      <td></td>
                  </tr>
                  <tr>
                    <td colspan="4"><b>Service Information</b></td>
                  </tr>

                  <tr>
                      <td><b>Present Designation & place of Posting</b></td>
                      <td><?php echo $application['txtOfficeDesignationPlacePosting']?></td>
                      <td><b>Joining date of job</b></td>
                      <td><?php echo $application['txtOfficeJoinDate']?></td>
                  </tr>
                  <tr>
                      <td><b>Office Email</b></td>
                      <td><?php echo $application['txtOfficeEmail']?></td>
                      <td><b>Joining date of job</b></td>
                      <td><?php echo $application['txtOfficeJoinDate']?></td>
                  </tr>
              </table>
              <table class="table table-bordered">
              <tr>
                  <td><b>Signature</b></td>
                  <td><img style="display: block;width: 200px;height: 230px" src="<?php echo $uploadPath.$application['imgSignature'];?>" alt="trainee signature"></td>
              </tr>
                <tr>
                    <td><b>Name</b></td>
                    <td><?php echo $application['txtSignName']?></td>
                </tr>
                <tr>
                    <td><b>Designation</b></td>
                    <td><?php echo $application['txtSignDesignation']?></td>
                </tr>
                <tr>
                    <td><b>Date</b></td>
                    <td><?php //echo $application['txtSignDate'];?></td>
                </tr>

              </table>


        </div>
        <div class="col-md-4"></div>
    </div>

</div>

<script src="https://cdn.rawgit.com/erikzaadi/jQueryPlugins/master/jQuery.printElement/jquery.printElement.min.js"
       ></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#print').click(function () {
            if (confirm("Are you sure to print this application"))
                $('.printArea').printElement({printMode:'popup'});
        });
    });
</script>
