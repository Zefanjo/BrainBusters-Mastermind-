<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mastermind Board</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f3f3f3;
        }

        .mastermind-board {
            display: grid;
            gap: 10px;
            background-color: #ffffff;
            padding: 20px;
            border: 2px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }

        .row {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .guess {
            display: flex;
            gap: 10px;
        }

        .pin {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: #e0e0e0;
            cursor: pointer;
        }

        .feedback {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            height: 20px;
            width: 30px;
            align-content: center;
        }

        .feedback-pin {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background-color: #e0e0e0;
        }
    </style>
</head>
<body>
<div class="mastermind-board">
    <!-- Example of 10 rows -->
    <div class="row">
        <div class="guess">
            <div id="peg1" class="pin"></div>
            <div id="peg2" class="pin"></div>
            <div id="peg3" class="pin"></div>
            <div id="peg4" class="pin"></div>
        </div>
        <div class="feedback">
            <div class="feedback-pin"></div>
            <div class="feedback-pin"></div>
            <div class="feedback-pin"></div>
            <div class="feedback-pin"></div>
        </div>
    </div>
    <!-- Duplicate the rows as needed -->
    <!-- Add more rows dynamically with JavaScript if necessary -->
</div>


</body>
</html>
