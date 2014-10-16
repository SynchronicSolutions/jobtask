<html>
<head>
    <link href="calendar.css" type="text/css" rel="stylesheet" />
</head>
<body>

<?php
    include("Database.php");
    include("Event.php");
    include("Calendar.php");

    $calendar = new Calendar();
    echo $calendar->show();
?>
<button type="button" onclick="window.open('EventCreationForm.php')">New Event</button>
</body>
</html>
