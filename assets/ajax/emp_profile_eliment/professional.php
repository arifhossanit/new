<!-- Professional Inforrmation -->
<div class="tab-pane" id="professional">
    <div class="timeline-header no-border">
        <div class="row">
            <div class="col-md-12">
                <h5>Academic Qulification</h5>
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 8%;">Level Of Education</th>
                                    <th style="width: 8%;">Passing Year</th>
                                    <th>Institution</th>
                                    <th style="width: 8%;">Board</th>
                                    <th style="width: 16%;">Group/Subject</th>
                                    <th style="width: 8%;">Division/CGPA</th>
                                    <th style="width: 8%;">GPA/CGPA Scale</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($education_qualification->num_rows != 0){?>
                                    <?php while($education_qualification_row = mysqli_fetch_assoc($education_qualification)){?>
                                        <tr>
                                            <td> <?php echo $education_qualification_row['level_of_education'] ?> </td>
                                            <td> <?php echo $education_qualification_row['passing_year'] ?> </td>
                                            <td> <?php echo $education_qualification_row['institution'] ?> </td>
                                            <td> <?php echo $education_qualification_row['board'] ?> </td>
                                            <td> <?php echo $education_qualification_row['edu_group'] ?> </td>
                                            <td> <?php echo $education_qualification_row['class'] ?> </td>
                                            <td> <?php echo $education_qualification_row['gpa'] ?> </td>
                                        </tr>
                                    <?php } ?>
                                <?php }else{?>
                                    <tr>
                                        <td colspan="8"> No Information </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>										
            </div>
            <div class="col-md-12">
                <h5>Profession Qulification/Training</h5>
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th style="width: 28%;">Name of the Training</th>
                                    <th>Institution</th>
                                    <th style="width: 25%;">Place(Local/Foreign)</th>
                                    <th style="width: 8%;">Completion Year</th>
                                    <th style="width: 10%;">Duration</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($professional_training->num_rows != 0){?>
                                    <?php while($professional_training_row = mysqli_fetch_assoc($professional_training)){?>
                                        <tr>
                                            <td> <?php echo $professional_training_row['training_name'] ?> </td>
                                            <td> <?php echo $professional_training_row['institution'] ?> </td>
                                            <td> <?php echo $professional_training_row['place'] ?> </td>
                                            <td> <?php echo $professional_training_row['completion_year'] ?> </td>
                                            <td> <?php echo $professional_training_row['duration'] ?> </td>
                                        </tr>
                                    <?php } ?>
                                <?php }else{?>
                                    <tr>
                                        <td colspan="6"> No Information </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>										
            </div>
            <div class="col-md-12">
                <h5>Employment History</h5>
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>Employer/Company Name</th>
                                    <th>Designation</th>
                                    <th>Department</th>
                                    <th>From</th>
                                    <th style="width: 8%;">To</th>
                                    <th>Core Responsibility</th>
                                    <th>Reason For Leaving</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if($employment_history->num_rows != 0){?>
                                    <?php while($employment_history_row = mysqli_fetch_assoc($employment_history)){?>
                                        <tr>
                                            <td> <?php echo $employment_history_row['company_name'] ?> </td>
                                            <td> <?php echo $employment_history_row['designation'] ?> </td>
                                            <td> <?php echo $employment_history_row['department'] ?> </td>
                                            <td> <?php echo $employment_history_row['from_date'] ?> </td>
                                            <td> <?php echo $employment_history_row['to_date'] ?> </td>
                                            <td> <?php echo $employment_history_row['responsibility'] ?> </td>
                                            <td> <?php echo $employment_history_row['leaving_reason'] ?> </td>
                                        </tr>
                                    <?php } ?>
                                <?php }else{?>
                                    <tr>
                                        <td colspan="7"> No Information </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>										
            </div>
        </div>
    </div>                            
</div>  