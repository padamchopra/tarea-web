<!DOCTYPE html>

<head>

    <link rel="icon" href="tarea-logo.png" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="materialize.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <script src="https://www.gstatic.com/firebasejs/5.11.1/firebase-app.js"></script>
    <script src="https://www.gstatic.com/firebasejs/5.10.0/firebase-auth.js"></script>
    <script src="https://www.gstatic.com/firebasejs/5.11.1/firebase-firestore.js"></script>
    <title>View task</title>
    <link rel="stylesheet" href="style.css" />
    <script>
        var taskID = "<?php echo $_GET['id']?>";
        var assignedTo = "<?php echo $_GET['mymail']?>";
        // Your web app's Firebase configuration
        var firebaseConfig = {
            apiKey: "AIzaSyDEbxVcQXlE4P0FzfgLK7_hMqFDIiM2M5w",
            authDomain: "tarea-82fee.firebaseapp.com",
            databaseURL: "https://tarea-82fee.firebaseio.com",
            projectId: "tarea-82fee",
            storageBucket: "tarea-82fee.appspot.com",
            messagingSenderId: "591529979499",
            appId: "1:591529979499:web:9c58c129d24943a8"
        };
        // Initialize Firebase
        firebase.initializeApp(firebaseConfig);
        var db = firebase.firestore();
        var emailtoverify = "";
        var emailtoSendTo = "";
        window.onload = function() {
            var Modalelem = document.querySelector('.modal');
            var instanceModal = M.Modal.init(Modalelem);
            firebase.auth().signOut();
            instanceModal.open();
        }

        function askpassword() {
            var Modalelem = document.querySelector('.modal');
            var instanceModal = M.Modal.init(Modalelem);
            instanceModal.open();
        }

        function verify() {
            var firsttime = true;
            var password = document.getElementById("password").value;
            db.collection("tasks").doc(taskID).get()
                .then(function(doc) {
                    if (password == doc.data().pin) {
                        document.getElementById("From").focus();
                        document.getElementById("From").value = doc.data().from;
                        document.getElementById("To").focus();
                        document.getElementById("To").value = doc.data().to;
                        document.getElementById("title").focus();
                        document.getElementById("title").value = doc.data().title;
                        document.getElementById("description").focus();
                        document.getElementById("description").value = doc.data().description;
                        document.getElementById("date").value = doc.data().deadline_date;
                        document.getElementById("time").value = doc.data().deadline_time;
                        document.getElementById("time").value = doc.data().deadline_time;
                        var priority = doc.data().priority;
                        if (priority == "casual") {
                            document.getElementById("taskcard").style.backgroundColor = "#81D4FA";
                        } else if (priority == "important") {
                            document.getElementById("taskcard").style.backgroundColor = "#FFB74D";
                        } else if (priority == "urgent") {
                            document.getElementById("taskcard").style.backgroundColor = "#DD2C00";
                        }
                    } else {
                        M.toast({
                            html: "incorrect pin entered!",
                            classes: 'rounded',
                            displayLength: '2000'
                        });
                    }
                });
        }

        function markcomplete() {
            db.collection("tasks").doc(taskID).update({
                    status: 'completed',
                    pin: 'Deleted'
                })
                .then(function() {
                    M.toast({
                        html: "Marked as complete!",
                        classes: 'rounded',
                        displayLength: '2000'
                    });
                })
                .catch(function(error) {
                    M.toast({
                        html: "Could not mark complete.",
                        classes: 'rounded',
                        displayLength: '2000'
                    });
                });
        }

    </script>
    <style>
        label,
        input,
        form {
            color: black;
        }

    </style>
</head>

<body style="background-color:white;animation: none;">
    <div class="productbold heading" style="color:black;">tarea.</div>

    <div class="logintab  product" id="taskcard">

        <form method="POST" action="/addnewtask.php">

            <div class="input-field half-input" style="float:left;">
                <input id="From" type="text" name="from" class="product" readonly>
                <label for="From">From</label>
            </div>


            <div class="input-field half-input" style="float:right;">
                <input id="To" type="text" name="to" class="product" readonly>
                <label for="To">To</label>
            </div>

            <br>
            <br>
            <br>

            <div class="input-field">
                <input id="title" type="text" name="title" class="product" readonly>
                <label for="Title">Title</label>
            </div>

            <div class="input-field">
                <textarea id="description" class="materialize-textarea" style="color:black;" maxlength="250" readonly></textarea>
                <label for="description" style="margin-left: 0px;padding-left: 0px;">Description</label>
            </div>



            Deadline: <input type="date" id="date" name="date" style="width: 40%;margin-left: 20px;" readonly>
            <input type="time" id="time" name="time" style="width: 40%;float: right;" readonly>

            <br>
            <br>


            <br>
            <br>
            <center>
                <input class="formbutton productbold" id="completebtn" type="button" value="Mark Complete" onclick="markcomplete()" style="background-color: #4caf50;border-color: black;" readonly>

            </center>

        </form>


    </div>
    <div id="modal1" class="modal">
        <div class="modal-content">
            <h6 class="productbold" style="font-size:30px;color:black;">Please enter your pin: </h6>
            <div class="input-field product">
                <input id="password" type="password" name="password" class="validate product" style="color:black;" required>
                <label for="password">Pin</label>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#" class="modal-close waves-effect waves-green btn-flat product">CLOSE</a>
            <a href="#" class="modal-close waves-effect waves-green btn-flat product" onclick="verify()">VERIFY &amp; ADD</a>
        </div>
    </div>


</body>

</html>
