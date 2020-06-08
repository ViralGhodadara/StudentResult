<div id="studentResult" style="display: none;" class="section">
                <h3 class="title">Student Result</h3>
                <div class="container-advanceReport">
                    <form method="post">
                        <p class="st">Standard : <?php echo $dataOfUser['standard']; ?></p>
                        <select name="divisionStuRe" class="se-opt" style="height: 27px;" required>
                            <option value="" selected disabled>Division</option>
                            <?php
                                $selectDivisionStuRe = "SELECT * FROM division WHERE standard = ?";
                                $statSelectDivisionStuRe = $conn->prepare($selectDivisionStuRe);
                                $statSelectDivisionStuRe->execute([$dataOfUser['standard']]);

                                if ($statSelectDivisionStuRe->rowCount() > 0) {
                                    while ($dataSelectDivisionStuRe = $statSelectDivisionStuRe->fetch()) {
                                    ?>
                                        <option value="<?php echo $dataSelectDivisionStuRe['division_name']; ?>"><?php echo $dataSelectDivisionStuRe['division_name']; ?></option>
                                    <?php
                                    }
                                }
                            ?>
                        </select><br>
                        <input type="submit" value="Submit" name="submit-stdDivStuRe" class="btn-AdvRe">
                    </form>
                    <?php
                        if (isset($_POST['submit-stdDivStuRe'])) {
                            $stdStuRe  = $dataOfUser['standard'];
                            $_SESSION['standardStuRe'] = $stdStuRe;
                            
                            if (isset($_POST['divisionStuRe'])) { 

                                $divStuRe = $_POST['divisionStuRe'];
                                $claaNameStuRe = "standard".$stdStuRe.$divStuRe;

                                $_SESSION['classNameForStudentData'] = $claaNameStuRe;

                                $usernameStuRe = "SELECT username FROM $claaNameStuRe";
                                $statUsernameStuRe = $conn->prepare($usernameStuRe);
                                $statUsernameStuRe->execute();
                            }
                        }
                    ?>
                    <p class="st" style="margin-top: -7px;">Please choose the username and take detail of the student</p>
                    <form method="post" action="http://localhost/viral/school-system/teacherAdmin/createStudentResult.php" target="blanck">
                        <select name="usernameStuRe" class="se-opt" style="height: 27px;" required>
                            <option value="" selected disabled>Username</option>
                            <?php
                                while ($dataUsernameStuRe = $statUsernameStuRe->fetch()) {
                                ?>
                                    <option value="<?php echo $dataUsernameStuRe['username']; ?>"><?php echo $dataUsernameStuRe['username'] ?></option>
                                <?php
                                }
                            ?>
                        </select><br>
                        <button type="submit" name="submit-stdDivStuRe" class="btn-AdvRe">Take Report</button>
                    </form>
                </div>
            </div>