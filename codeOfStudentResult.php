 <!-- This is a start coding of Student Result -->
            <div id="studentResult" style="display: none;" class="section">
                <h3 class="title">Student Result</h3>
                <div class="container-advanceReport">
                    <form method="post">
                        <p class="st">Standard : <?php echo $dataOfUser['standard']; ?></p>
                        <?php
                            $selectDivisionStuRes = "SELECT division_name FROM division WHERE standard = ?";
                            $statSelectDivisionStuRes = $conn->prepare($selectDivisionStuRes);
                            $statSelectDivisionStuRes->execute([$dataOfUser['standard']]);
                        ?>
                        <select onchange="divisionFunStuRes()" id="divisionStuResId" class="se-opt" style="margin-bottom: 10px;">
                            <option value="" selected disabled>Division</option>
                            <?php
                                while ($dataDivisionStuRes = $statSelectDivisionStuRes->fetch()) {
                                ?>
                                    <option value="<?php echo $dataDivisionStuRes['division_name'] ?>"><?php echo $dataDivisionStuRes['division_name'] ?></option>
                                <?php
                                }
                            ?>
                        </select><br>
                        <script>
                            function divisionFunStuRes() {
                                let divStuRes = document.getElementById("divisionStuResId").value;
                                location.href="?divisionStuRe="+divStuRes;
                            } 
                        </script>
                        <?php
                            if (isset($_GET['divisionStuRe'])) {
                                $divisionStuRes = $_GET['divisionStuRe'];
                                $_SESSION['divisionOfStudent'] = $divisionStuRes;
                                $tableStuRes = "standard".$dataOfUser['standard'].$divisionStuRes;
                                $_SESSION['studentData'] = $tableStuRes;

                                $selectUsernmStuRes = "SELECT * FROM $tableStuRes";
                                $statSelectUsernmStuRe = $conn->prepare($selectUsernmStuRes);
                                $statSelectUsernmStuRe->execute();
                            }
                        ?>
                        <select name="usernameStuRes" class="se-opt" required>
                            <option value="">Username</option>
                            <?php
                                while ($dataStudentUsernmStuRes = $statSelectUsernmStuRe->fetch()) {
                                ?>
                                    <option value="<?php echo $dataStudentUsernmStuRes['username']; ?>"><?php echo $dataStudentUsernmStuRes['username']; ?></option>
                                <?php
                                }
                            ?>
                        </select><br>
                        <input type="submit" name="createResult" value="Select" class="btn-selectTableData">
                    </form>
                    <?php
                        if (isset($_POST['createResult'])) {
                            $studentUsername = $_POST['usernameStuRes'];
                            if (isset($_SESSION['studentData'])) {
                                $studentDetail = $_SESSION['studentData'];
                                
                                $selectStudentData = "SELECT * FROM $studentDetail WHERE username LIKE ?";
                                $statSelectStudentDetail = $conn->prepare($selectStudentData);
                                $statSelectStudentDetail->execute([$studentUsername]);
                                $dataStudentDetail = $statSelectStudentDetail->fetch();
                            }
                        }
                    ?>

                    <p class="studentDataTitle" style="margin-bottom: 20px;">Student Detail</p>
                    <p class="UsernmDetail" style="margin-top: -18px;">Roll Number : <?php if(isset($dataStudentDetail['roll_number'])) { echo $dataStudentDetail['roll_number']; } ?></p>
                    <p class="UsernmDetail" style="margin-top: -18px;">Student Name : <?php if(isset($dataStudentDetail['student_name'])) { echo $dataStudentDetail['student_name']; } ?></p>
                    <p class="UsernmDetail" style="margin-top: -18px;">Standard : <?php echo $dataOfUser['standard']; ?></p>
                    <p class="UsernmDetail" style="margin-top: -18px;">Division : <?php if (isset($_SESSION['divisionOfStudent'])) { echo $_SESSION['divisionOfStudent']; } ?></p>

                    <?php
                        if ($dataOfUser['standard'] == 10) {
                        ?>
                            <table>
                                <tr>
                                    <p class="error" id="err"></p>
                                </tr>
                                <tr>
                                    <label class="stuMarksheet">Maths : </label>&nbsp;&nbsp;&nbsp;<input type="number" id="maths" class="markBox"><p id="err-maths" style="color: brown; font-family: verdana; margin-left: 126px;"></p>
                                </tr>
                                <tr>
                                    <label class="stuMarksheet">Gujarati : </label>&nbsp;&nbsp;&nbsp;<input type="number" id="gujarati" class="markBox"><p id="err-gujarati" style="color: brown; font-family: verdana; margin-left: 126px;"></p>
                                </tr>
                                <tr>
                                    <label class="stuMarksheet">Hindi : </label>&nbsp;&nbsp;&nbsp;<input type="number" id="hindi" class="markBox"><p id="err-hindi" style="color: brown; font-family: verdana; margin-left: 126px;"></p>
                                </tr>
                                <tr>
                                    <label class="stuMarksheet">English : </label>&nbsp;&nbsp;&nbsp;<input type="number" id="english" class="markBox"><p id="err-english" style="color: brown; font-family: verdana; margin-left: 126px;"></p>
                                </tr>
                                <tr>
                                    <label class="stuMarksheet">Science : </label>&nbsp;&nbsp;&nbsp;<input type="number" id="science" class="markBox"><p id="err-science" style="color: brown; font-family: verdana; margin-left: 126px;"></p>
                                </tr>
                                <tr>
                                    <label class="stuMarksheet">Drawing : </label>&nbsp;&nbsp;&nbsp;<input type="number" id="drawing" class="markBox"><p id="err-drawing" style="color: brown; font-family: verdana; margin-left: 126px;"></p>
                                </tr>
                                <tr>
                                    <input type="submit" value="Create Result" class="btn" onclick="countResult();">
                                </tr>
                                <tr>
                                    <br>
                                    <p><label class="stuMarksheet">Total : </label>&nbsp;&nbsp;&nbsp;<p id="total"></p></p>
                                    
                                </tr>
                                <tr>
                                    <label class="stuMarksheet">Percentage : </label>&nbsp;&nbsp;&nbsp;<p id="per"></p>
                                </tr>
                                <tr>
                                    <label class="stuMarksheet">Gread : </label>&nbsp;&nbsp;&nbsp;<p id="gread"></p>
                                </tr>
                            </table>

                            <script>
                                function countResult() {
                                    let maths = parseInt(document.getElementById("maths").value);
                                    let guj = parseInt(document.getElementById("gujarati").value);
                                    let hindi = parseInt(document.getElementById("hindi").value);
                                    let eng = parseInt(document.getElementById("english").value);
                                    let sci = parseInt(document.getElementById("science").value);
                                    let dra = parseInt(document.getElementById("drawing").value); 

                                    if (isNaN(maths)) {
                                        document.getElementById("err-maths").innerHTML = "***Please enter the value";
                                    } else if (isNaN(guj)) {
                                        document.getElementById("err-gujarati").innerHTML = "***Please enter the value";
                                    } else if (isNaN(hindi)) {
                                        document.getElementById("err-hindi").innerHTML = "***Please enter the value";
                                    } else if (isNaN(eng)) {
                                        document.getElementById("err-english").innerHTML = "***Please enter the value";
                                    } else if (isNaN(sci)) {
                                        document.getElementById("err-science").innerHTML = "***Please enter the value";
                                    } else if (isNaN(dra)) {
                                        document.getElementById("err-drawing").innerHTML = "***Please enter the value";
                                    } else {
                                        if (maths > 100) {
                                            document.getElementById("err-maths").innerHTML = "***Please enter the mark less than 100";
                                        } else if (guj > 100) {
                                            document.getElementById("err-gujarati").innerHTML = "***Please enter the mark less than 100";
                                        } else if (hindi > 100) {
                                            document.getElementById("err-hindi").innerHTML = "***Please enter the mark less than 100";
                                        } else if (eng > 100) {
                                            document.getElementById("err-english").innerHTML = "***Please enter the mark less than 100";
                                        } else if (sci > 100) {
                                            document.getElementById("err-science").innerHTML = "***Please enter the mark less than 100";
                                        } else if (dra > 100) {
                                            document.getElementById("err-drawing").innerHTML = "***Please enter the mark less than 100";
                                        } else {
                                            if (maths <= 33 || guj <= 33 || hindi <= 33 || eng <= 33 || sci <= 33 || dra <= 33) {
                                                total = parseInt(maths + guj + hindi + eng + sci + dra);
                                                per = parseFloat(total / 6);
                                                gread = "Fail";

                                                document.getElementById('total').innerHTML = total;
                                                document.getElementById('per').innerHTML = per;
                                                document.getElementById("gread").innerHTML = gread;
                                            } else {
                                                total = parseInt(maths + guj + hindi + eng + sci + dra);
                                                per = parseFloat(total / 6);

                                                document.getElementById('total').innerHTML = total;
                                                document.getElementById('per').innerHTML = per;

                                                if (per >= 90 && per <= 100) {
                                                    gread = "A+";
                                                    document.getElementById("gread").innerHTML = gread;
                                                } else if (per >= 80 && per <= 89) {
                                                    gread = "A";
                                                    document.getElementById("gread").innerHTML = gread;
                                                } else if (per >= 70 && per <= 79) {
                                                    gread = "B+";
                                                    document.getElementById("gread").innerHTML = gread;
                                                } else if (per >= 60 && per <= 69) {
                                                    gread = "B";
                                                    document.getElementById("gread").innerHTML = gread;
                                                } else if (per >= 50 && per <= 59) {
                                                    gread = "C+";
                                                    document.getElementById("gread").innerHTML = gread;
                                                } else if (per >= 34 && per <= 49) {
                                                    gread = "C+";
                                                    document.getElementById("gread").innerHTML = gread;
                                                } else {
                                                    gread = "Fail";
                                                    document.getElementById("gread").innerHTML = gread;
                                                }
                                            }
                                        }

                                        location.href="?maths="+maths;
                                        location.href="?gujarati="+guj;
                                        location.href="?hindi="+hindi;
                                        location.href="?english="+eng;
                                        location.href="?science="+sci;
                                        location.href="?drawing="+dra;
                                        location.href="?total="+total;
                                        location.href="?per="+per;
                                        location.href="?gread="+gread;
                                    }
                                }
                            </script>
                        <?php
                            if (isset($_GET['maths'])) { 
                                $mathsMark = $_GET['maths'];
                                if (isset($_GET['gujarati'])) {
                                    $gujaratiMark = $_GET['gujarati'];
                                    if (isset($_GET['hindi'])) {
                                        $hindiMark = $_GET['hindi'];
                                        if (isset($_GET['english'])) {
                                            $engMark = $_GET['english'];
                                            if (isset($_GET['science'])) {
                                                $sciMark = $_GET['science'];
                                                if (isset($_GET['drawing'])) {
                                                    $draMark = $_GET['drawing'];
                                                    if (isset($_GET['total'])) {
                                                        $total = $_GET['total'];
                                                        if (isset($_GET['per'])) {
                                                            $per = $_GET['per'];
                                                            if (isset($_GET['gread'])) {
                                                                $gread = $_GET['gread'];
                                                                // $rollNum = $dataStudentDetail['roll_number'];
                                                                // $stuName = $dataStudentDetail['student_name'];
                                                                // $usrnm = $dataStudentDetail['username'];

                                                                $insertMarkSheet = "INSERT INTO test (maths, gujarati, hindi, english, science, drawing, total, student_percentage, gread) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
                                                                $statInsertMarkSheet = $conn->prepare($insertMarkSheet);

                                                                echo '<script>console.log("This is a execute");</script>';

                                                                if ($statInsertMarkSheet->execute([$mathsMark, $gujaratiMark, $hindiMark, $engMark, $sciMark, $draMark, $total, $per, $gread])) {
                                                                ?>
                                                                    <script>alert("Record inserted successfully");</script>
                                                                <?php
                                                                } else {
                                                                ?>
                                                                    <script>alert("Record cannot inserted please try again");</script>
                                                                <?php
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    ?>
                </div>
            </div>
            <!-- This is a end coding of Student Result -->
