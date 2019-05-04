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

    <title>Guest Session</title>

    <link rel="stylesheet" href="style.css" />
    <script>
        var assignedFrom = "<?php echo $_GET['assignee']?>";
        var pin = "<?php echo $_GET['pin']?>";
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
            db.collection("users").where("username", "==", assignedFrom).get()
                .then(function(querySnapshot) {
                    if (querySnapshot.size != 0) {
                        document.getElementById("From").focus();
                        document.getElementById("From").value = assignedFrom;
                        querySnapshot.forEach(function(doc) {
                            emailtoverify = doc.data().email;
                        });
                    } else {
                        alert(assignedFrom + "- user not found.");
                        window.location.href = "http://tarea-api.herokuapp.com/";
                    }
                });
        };

        function askpassword() {
            var Modalelem = document.querySelector('.modal');
            var instanceModal = M.Modal.init(Modalelem);
            instanceModal.open();
        }

        function verify() {
            var firsttime = true;
            var password = document.getElementById("password").value;
            firebase.auth().signInWithEmailAndPassword(emailtoverify, password).catch(function(error) {
                // Handle Errors here.
                var errorCode = error.code;
                var errorMessage = error.message;
                if (errorMessage.length > 0) {
                    M.toast({
                        html: errorMessage,
                        classes: 'rounded',
                        displayLength: '2000'
                    });
                }
                // ...
            });
            firebase.auth().onAuthStateChanged(function(user) {
                var loggedin = firebase.auth().currentUser;
                if (firsttime) {
                    firsttime = false;
                    var taskId = "";
                    var assignedToEmail = document.getElementById("to").value;
                    db.collection("tasks").add({
                            from: assignedFrom,
                            to: assignedToEmail,
                            title: document.getElementById("title").value,
                            description: document.getElementById("description").value,
                            deadline_date: document.getElementById("date").value,
                            deadline_time: document.getElementById("time").value,
                            priority: document.querySelector('input[name=Priority]:checked').value,
                            pin: pin
                        })
                        .then(function(docRef) {
                            taskId = docRef.id;
                            M.toast({
                                html: "Task Added!",
                                classes: 'rounded',
                                displayLength: '1200'
                            });
                            firebase.auth().signOut();
                            window.location.href = "http://tarea-api.herokuapp.com/guestemail/" + assignedToEmail + "/" + taskId + "/" + pin;
                        })
                        .catch(function(error) {
                            console.log(error);
                            M.toast({
                                html: "Could not add task. Try again.",
                                classes: 'rounded',
                                displayLength: '1200'
                            });
                        });
                }
            });
        }

    </script>

</head>

<body>
    <div class="productbold heading">tarea.</div>

    <div class="logintab  product">

        <form method="POST" action="/addnewtask">

            <div class="input-field half-input" style="float:left;">
                <input id="From" type="text" name="from" class="validate product">
                <label for="From">From</label>
            </div>


            <div class="input-field half-input" style="float:right;">
                <input id="To" type="email" name="Guest Email" class="validate product">
                <label for="To">Guest Email</label>
            </div>

            <br>
            <br>
            <br>

            <div class="input-field">
                <input id="title" type="text" name="title" class="validate product">
                <label for="Title">Title</label>
            </div>

            <div class="input-field">
                <textarea id="description" class="materialize-textarea" maxlength="250"></textarea>
                <label for="description" style="margin-left: 0px;padding-left: 0px;">Description</label>
            </div>



            Deadline: <input type="date" id="date" name="date" style="width: 40%;margin-left: 20px;">
            <input type="time" name="time" id="time" style="width: 40%;float: right;">

            <br>
            <br>


            Priority:

            <label style="width: 30%; margin-left: 30px ">
                <input class="with-gap" name="Priority" type="radio" value="casual" checked style="width: 30%; margin-left: 20px" />
                <span>Casual</span>
            </label>


            <label style="width: 30%; margin-left: 70px">
                <input class="with-gap" name="Priority" value="important" type="radio" />
                <span>Important</span>
            </label>



            <label style="width: 30%; margin-left: 70px ">
                <input class="with-gap" name="Priority" value="urgent" type="radio" style="width: 30%;" />
                <span>Urgent</span>
            </label>

            <br>
            <br>
            <input class="formbutton cancelbutton productbold" type="reset" style="float: left; margin-left: 20px; color: #ff3030; border-color: #ff3030;" value="Cancel">

            <input class="formbutton productbold" type="button" onclick="askpassword()" value="Assign Task" style="float: right;margin-right: 20px; background-color: #4caf50;border-color: black;">



        </form>


    </div>
    <div id="modal1" class="modal">
        <div class="modal-content">
            <h6 class="productbold" style="font-size:30px;color:black;">Please enter your password: </h6>
            <div class="input-field product">
                <input id="password" type="password" name="password" class="validate product" style="color:black;" required>
                <label for="password">Password</label>
            </div>
        </div>
        <div class="modal-footer">
            <a href="#" class="modal-close waves-effect waves-green btn-flat product">CLOSE</a>
            <a href="#" class="modal-close waves-effect waves-green btn-flat product" onclick="verify()">VERIFY &amp; ADD</a>
        </div>
    </div>


</body>

</html>
