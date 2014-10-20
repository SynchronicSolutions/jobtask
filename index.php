<html>
<head>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css">
    <script src="//code.jquery.com/jquery-1.10.2.js"></script>
    <script src="//code.jquery.com/ui/1.11.1/jquery-ui.js"></script>
    <script src="javascript/mainJS.js"></script>
    <link href="css/basic-grey.css" type="text/css" rel="stylesheet" />

</head>
<body>
    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>" class="basic-grey">
        <label>
            <h1>Show events</h1>
        </label>
        <label>
            <span>Date from</span>
            <input type="text" name="dateFrom" id="dateFrom">
        </label>
        <label>
            <span>Date To</span>
            <input type="text"  name="dateTo" id="dateTo">
        </label>
        <label>
            <button type="button" id="newEventButton" onclick="window.location.href = 'EventCreationForm.php'">New Event</button>
            <input type="submit"  id="showButton" value="Show" /><br /><br /><br />
        </label>
        <label id="eventShow">

            <?php
            include("Database.php");
            include("Event.php");


            Database::create_database();
            Database::create_table("calendar", "event");

            $events = new Event();
            if(isset($_POST['dateFrom']) && isset($_POST['dateTo']))
                $events->getEventsForPeriod($_POST['dateFrom'], $_POST['dateTo']);
            ?>
        </label>
    </form>

</body>
</html>



