<div class="content-wrapper">
    <div class="container" >	
		<div class="row" >
            <div class="col-md-12">
                <div class="row" style="background-color:dimgrey;margin-top:40px;">
                    <div class="col-md-3" style="padding:10px;">
                        <form id="YearMonthForm" name="YearMonthForm" action="<?php print current_url()?>" method="POST" enctype="multipart/form-data">
                            <input id="day" name="day" class="form-control" type="date" value="<?php print $day; ?>" onchange="document.getElementById('YearMonthForm').submit()" required>
                        </form>
                    </div>
                    <div class="col-md-9" style="padding:15px;">
                        <center style="color:white;font-weight:900;font-size:16pt;">Package/Occupation wise Members</center>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-bordered" id="chartContainer_packageTable" style="font-size:14pt;color:white;font-weight:900;">
                            <thead>
                                <th>Package</th>
                                <th>Student</th>
                                <th>Job Holder</th>
                                <th>Business Man</th>
                                <th>Housewife</th>
                                <th>Doctor</th>
                                <th>Teacher</th>
                                <th>Total</th>
                            </thead>
                            <tbody>
                                <tr style="color:turquoise;">
                                    <td>VIP</td>
                                    <td><?php print $vip_student->vip_student; ?></td>
                                    <td><?php print $vip_job_holder->vip_job_holder; ?></td>
                                    <td><?php print $vip_business_man->vip_business_man; ?></td>
                                    <td><?php print $vip_house_wife->vip_house_wife; ?></td>
                                    <td><?php print $vip_doctor->vip_doctor; ?></td>
                                    <td><?php print $vip_teacher->vip_teacher; ?></td>
                                    <td><?php print $total_vip->total_vip; ?></td>
                                </tr>
                                <tr style="color:violet;">
                                    <td>Cozy</td>
                                    <td><?php print $cozy_student->cozy_student; ?></td>
                                    <td><?php print $cozy_job_holder->cozy_job_holder; ?></td>
                                    <td><?php print $cozy_business_man->cozy_business_man; ?></td>
                                    <td><?php print $cozy_house_wife->cozy_house_wife; ?></td>
                                    <td><?php print $cozy_doctor->cozy_doctor; ?></td>
                                    <td><?php print $cozy_teacher->cozy_teacher; ?></td>
                                    <td><?php print $total_cozy->total_cozy; ?></td>
                                </tr>
                                <tr style="color: wheat;">
                                    <td>Elegant</td>
                                    <td><?php print $elegant_student->elegant_student; ?></td>
                                    <td><?php print $elegant_job_holder->elegant_job_holder; ?></td>
                                    <td><?php print $elegant_business_man->elegant_business_man; ?></td>
                                    <td><?php print $elegant_house_wife->elegant_house_wife; ?></td>
                                    <td><?php print $elegant_doctor->elegant_doctor; ?></td>
                                    <td><?php print $elegant_teacher->elegant_teacher; ?></td>
                                    <td><?php print $total_elegant->total_elegant; ?></td>
                                </tr>
                                <tr style="color:lightsalmon;">
                                    <td>Exclusive</td>
                                    <td><?php print $exclusive_student->exclusive_student; ?></td>
                                    <td><?php print $exclusive_job_holder->exclusive_job_holder; ?></td>
                                    <td><?php print $exclusive_business_man->exclusive_business_man; ?></td>
                                    <td><?php print $exclusive_house_wife->exclusive_house_wife; ?></td>
                                    <td><?php print $exclusive_doctor->exclusive_doctor; ?></td>
                                    <td><?php print $exclusive_teacher->exclusive_teacher; ?></td>
                                    <td><?php print $total_exclusive->total_exclusive; ?></td>
                                </tr>
                                <tr style="color:palegreen;">
                                    <td>Economy</td>
                                    <td><?php print $economy_student->economy_student; ?></td>
                                    <td><?php print $economy_job_holder->economy_job_holder; ?></td>
                                    <td><?php print $economy_business_man->economy_business_man; ?></td>
                                    <td><?php print $economy_house_wife->economy_house_wife; ?></td>
                                    <td><?php print $economy_doctor->economy_doctor; ?></td>
                                    <td><?php print $economy_teacher->economy_teacher; ?></td>
                                    <td><?php print $total_economy->total_economy; ?></td>
                                </tr>
                                <tr>
                                    <td>Total</td>
                                    <td><?php print $total_students->total_students; ?></td>
                                    <td><?php print $total_job_holder->total_job_holder; ?></td>
                                    <td><?php print $total_business_man->total_business_man; ?></td>
                                    <td><?php print $total_housewife->total_housewife; ?></td>
                                    <td><?php print $total_doctor->total_doctor; ?></td>
                                    <td><?php print $total_teachers->total_teachers; ?></td>
                                    <td><?php print $total_guest->total_guest; ?></td>
                                </tr>
                            </tbody>
                            <tfoot></tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div> 
</div>
