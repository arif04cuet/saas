{{ content() }}

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

        }
    </style>
    <div class="row">
        <div class="col-md-12">
            <h3><?php echo $application['courseName']?>
                <button style="float: right" id="print" class="btn">Print</button>
            </h3>

            <h4>Government of the People's Republic of Bangladesh
                National Institute Of Mass Communication
                125/A, Darus Salam, Mirpur Road, Dhaka-1216.
                <br>Date : <?php echo date("d-m-Y")?></h4>
            <hr>
        </div>
    </div>
    <div class="row">
        <div class="col-md-8">
            <img style="display: block" src="<?php echo $uploadPath.$application['img']?>" alt="trainee photo">
            <br>
            <table class="table table-bordered">
                <tr>
                    <td><b>Trainee Name</b></td>
                    <td><?php echo $application['txtStuName']?></td>
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
                    <td><b>Present Address</b></td>
                    <td><?php echo $application['txtPresentAdd']?></td>
                </tr>

                <tr>
                    <td><b>Educational Qualification </b></td>
                    <td><?php echo $application['txtQualification']?></td>
                    <td><b>Residence Phone No.</b></td>
                    <td><?php echo $application['txtRPhoneNo']?></td>
                </tr>

                <tr>
                    <td><b>Mobile No. </b></td>
                    <td><?php echo $application['txtMobileNo']?></td>
                    <td><b>E-mail</b></td>
                    <td><?php echo $application['txtEmail']?></td>
                </tr>


                <tr>
                    <td><b>Idea About Tranning</b></td>
                    <td><?php echo $application['txtIdeaTrain']?></td>
                    <td><b>Ambition of Training</b></td>
                    <td><?php echo $application['txtAmbTrain']?></td>
                </tr>

            </table>

            <p>Only For Service Holder</p>
            <?php if($application['txtOfficeAdd']):?>
            <table class="table table-bordered">
                <tr>
                    <td><b>Office Name & Address</b></td>
                    <td><?php echo $application['txtOfficeAdd']?></td>
                    <td><b>Office Responsibility</b></td>
                    <td><?php echo $application['txtOfficeRespon']?></td>
                </tr>

                <tr>
                    <td><b>Service Training(if any)</b></td>
                    <td><?php echo $application['txtServiceTrain']?></td>
                    <td><b>Office Designation</b></td>
                    <td><?php echo $application['txtDegn']?></td>
                </tr>

                <tr>
                    <td><b>Office Phone No.</b></td>
                    <td><?php echo $application['txtOfficePhoneNo']?></td>
                    <td><b>Office FAX</b></td>
                    <td><?php echo $application['txtOfficeFAX']?></td>
                </tr>

            </table>
            <?php else:?>
            N/A
            <?php endif;?>

            <br>
            <p>All Attachements</p>

            <table class="table table-bordered">
                <tr>
                    <td><b>Trainee Photo </b></td>
                    <td><a target="_blank"
                           href="<?php echo $uploadPath.$application['img']?>"><?php echo $application['img']?'Download':''?></a>
                    </td>
                    <td><b>SSC Certificate</b></td>
                    <td><a target="_blank"
                           href="<?php echo $uploadPath.$application['imgSSC']?>"><?php echo $application['imgSSC']?'Download':''?></a>
                    </td>

                </tr>
                <tr>
                    <td><b>HSC Certificate</b></td>
                    <td><a target="_blank"
                           href="<?php echo $uploadPath.$application['imgHSC']?>"><?php echo $application['imgHSC']?'Download':''?></a>
                    </td>
                    <td><b>Hon's Certificate </b></td>
                    <td><a target="_blank"
                           href="<?php echo $uploadPath.$application['imgHONS']?>"><?php echo $application['imgHONS']?'Download':''?></a>
                    </td>
                </tr>
                <tr>
                    <td><b>Masters Certificate</b></td>
                    <td><a target="_blank"
                           href="<?php echo $uploadPath.$application['imgMAS']?>"><?php echo $application['imgMAS']?'Download':''?></a>
                    </td>
                    <td><b>Character Certificate</b></td>
                    <td><a target="_blank"
                           href="<?php echo $uploadPath.$application['imgCHAR']?>"><?php echo $application['imgCHAR']?'Download':''?></a>
                    </td>
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

