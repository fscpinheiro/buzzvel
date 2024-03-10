<!DOCTYPE html>
<html>
<head>
    <title>Holiday Plan</title>
</head>
<body>
    <h1>{{ $holidayPlan->title }}</h1>
    <p>{{ $holidayPlan->description }}</p>
    <p>Date: {{ $holidayPlan->date }}</p>
    <p>Location: {{ $holidayPlan->location }}</p>
    @if($holidayPlan->participants)
        <p>Participants: {{ $holidayPlan->participants }}</p>
    @endif
</body>
</html>