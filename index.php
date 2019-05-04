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
    <title>Add task</title>
    <link rel="stylesheet" href="style.css" />
    <script>
        var assignedFrom = "<?php echo $_GET['assignee']?>";
        var assignedTo = "<?php echo $_GET['assignedto']?>";
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
                    }
                    db.collection("users").where("username", "==", assignedTo).get()
                        .then(function(querySnapshot2) {
                            if (querySnapshot2.size != 0) {
                                document.getElementById("To").focus();
                                document.getElementById("To").value = assignedTo;
                            } else {
                                alert(assignedTo + "- user not found.");
                            }
                            document.getElementById("Title").focus();
                        });
                });
        };

        function askpassword() {
            var password = prompt("Please enter your password", "");
            firebase.auth().signInWithEmailAndPassword(emailtoverify, password).catch(function(error) {
                // Handle Errors here.
                var errorCode = error.code;
                var errorMessage = error.message;
                console.log(errorMessage);
                // ...
            });
            firebase.auth().onAuthStateChanged(function(user) {
                if(user.size > 0){
                    alert(firebase.auth().getUid());
                }else{
                    alert("Authorisation failed. Try again.");
                }
            });
        }

        /*db.collection("tasks").add({
                something: "Random"
            })
            .then(function(docRef) {
                alert(docRef.id);
            })
            .catch(function(error) {
                console.log(error);
            }); */

    </script>
</head>

<body>
    <div class="productbold heading">tarea.</div>

    <div class="logintab  product">

        <form method="POST" action="/addnewtask.php">

            <div class="input-field half-input" style="float:left;">
                <input id="From" type="text" name="from" class="validate product" required>
                <label for="From">From</label>
            </div>


            <div class="input-field half-input" style="float:right;">
                <input id="To" type="text" name="to" class="validate product" required>
                <label for="To">To</label>
            </div>

            <br>
            <br>
            <br>

            <div class="input-field">
                <input id="Title" type="text" name="title" class="validate product" required>
                <label for="Title">Title</label>
            </div>

            <div class="input-field">
                <textarea id="description" class="materialize-textarea" maxlength="250" required></textarea>
                <label for="description" style="margin-left: 0px;padding-left: 0px;">Description</label>
            </div>



            Deadline: <input type="date" name="date" style="width: 40%;margin-left: 20px;">
            <input type="time" name="time" style="width: 40%;float: right;">

            <br>
            <br>


            Priority:

            <label style="width: 30%; margin-left: 30px ">
                <input class="with-gap" name="Priority" type="radio" checked style="width: 30%; margin-left: 20px" />
                <span>Casual</span>
            </label>


            <label style="width: 30%; margin-left: 70px">
                <input class="with-gap" name="Priority" type="radio" />
                <span>Important</span>
            </label>



            <label style="width: 30%; margin-left: 70px ">
                <input class="with-gap" name="Priority" type="radio" style="width: 30%;" />
                <span>Urgent</span>
            </label>

            <br>
            <br>
            <input class="formbutton cancelbutton productbold" type="reset" style="float: left; margin-left: 20px; color: #ff3030; border-color: #ff3030;" value="Cancel">

            <input class="formbutton productbold" type="button" value="Assign Task" onclick="askpassword()" style="float: right;margin-right: 20px; background-color: #4caf50;border-color: black;">



        </form>


    </div>



</body>

</html>
