<?php
?>


<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Create a new event</title>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="/resources/demos/style.css">
    <link href="basic-grey.css" type="text/css" rel="stylesheet" />
    <script>
        $(function() {
            $( "#dateFrom").datepicker();
            $( "#dateUntil").datepicker();
            $( "#dateEnd").datepicker();

        });
    </script>

    <script type="text/javascript">
        function hide(){
            document.getElementById('repeatType').style.display = "none";
            document.getElementById('repeatType').reset();
        }

        function show(){

            if(document.getElementById('repeatCheckbox').checked == true)
                document.getElementById('repeatType').style.display = "initial";
            else{
                document.getElementById('repeatType').style.display = "none";
                document.getElementById('repeatType').reset();
            }
        }
    </script>
</head>
<body onload="hide()">


<form action="EventCreation.php" method="post" class="basic-grey">
    <h1>Create an event</h1>
    <label>
        <span>Event description</span>
        <input  type="text" name="description" maxlength="500">
    </label>

    <label>
        <span>Date from</span>
        <input type="text" id="dateFrom">
    </label>

    <label>
        <span>Date until</span>
        <input type="text" id="dateUntil">
    </label>

    <label>
        <span>Repeat</span>
        <input onclick="show()" type="checkbox" id="repeatCheckbox" name="repeat" maxlength="30">
    </label>
    <div id="repeatType">
        <label >
            <span>Repeats</span>
            <select name="repeatType">
                <option value="weekly"> Weekly </option>
                <option value="daily"> Daily </option>
                <option value="yearly"> Yearly </option>
                <option value="mwf"> Monday - Wednesday - Friday </option>
            </select>
        </label>
        <label>
            <span>Repeat every</span>
            <input type="text" id="repeatCount">
        </label>
        <label>
            <span>Repeat on</span>
            <input type="checkbox" id="dayMonday" name="repeat">
            <span class="weekday">M</span>
            <input type="checkbox" id="dayTuesday" name="repeat" maxlength="30">
            <span class="weekday">T</span>
            <input type="checkbox" id="dayWednesday" name="repeat" maxlength="30">
            <span class="weekday">W</span>
            <input type="checkbox" id="dayThursday" name="repeat" maxlength="30">
            <span class="weekday">T</span>
            <input type="checkbox" id="dayFriday" name="repeat" maxlength="30">
            <span class="weekday">F</span>
            <input type="checkbox" id="daySaturday" name="repeat" maxlength="30">
            <span class="weekday">S</span>
            <input type="checkbox" id="daySunday" name="repeat" maxlength="30">
            <span class="weekday">S</span>
        </label>
        <label>
            <span>Ends</span>
            <input type="radio" name="occurrenceNever" value="never">Never<br>
            <span></span>
            <input type="radio" name="occurrenceAfter " value="after">After
            <input  type="text" name="numberOfOccurrences" class="occurrences"> occurences<br>
            <input type="radio" name="occurrenceDate" value="date">On
            <span></span>
            <input type="text" id="dateEnd" class="occurrences">
        </label>
    </div>


    <label>
        <span>&nbsp;</span>
        <input type="submit" class="button" value="Send" />
    </label>


</form>



</body>
</html>