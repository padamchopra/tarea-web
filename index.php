<!DOCTYPE html>

<head>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="stylesheet" href="materialize.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

    <title>Home</title>
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <div class="productbold heading">tarea.</div>

    <div class="logintab  product">

        <form method="POST" action="/addnewtask">

            <div class="input-field half-input" style="float:left;">
                <input id="From" type="text" name="from" class="validate product" value="<?php echo $_GET['assignee'] ?>">
                <label for="From">From</label>
            </div>


            <div class="input-field half-input" style="float:right;">
                <input id="To" type="text" name="to" class="validate product" value="<?php echo $_GET['assignedto'] ?>">
                <label for="To">To</label>
            </div>

            <br>
            <br>
            <br>

            <div class="input-field">
                <input id="Title" type="text" name="title" class="validate product">
                <label for="Title">Title</label>
            </div>

            <div class="input-field">
                <textarea id="description" class="materialize-textarea" maxlength="250"></textarea>
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

            <input class="formbutton productbold" type="submit" value="Assign Task" style="float: right;margin-right: 20px; background-color: #4caf50;border-color: black;">



        </form>


    </div>



</body>

</html>
