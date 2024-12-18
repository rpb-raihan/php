  <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Quiz</title>
</head>
<body>
    <h1>Online Quiz</h1>
    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Correct answers
        $answers = [
            'q1' => 'a',
            'q2' => 'b',
            'q3' => 'c',
            'q4' => 'a',
            'q5' => 'b',
        ];

        // Calculate the score
        $score = 0;
        foreach ($answers as $question => $correctAnswer) {
            if (isset($_POST[$question]) && $_POST[$question] === $correctAnswer) {
                $score++;
            }
        }

        // Display the total marks
        echo "<h2>Your total score: $score / 5</h2>";
    } else {
        // Display the quiz form
    ?>
    <form method="POST">
        <h3>1. What is the capital of France?</h3>
        <input type="radio" name="q1" value="a" required> Paris<br>
        <input type="radio" name="q1" value="b"> London<br>
        <input type="radio" name="q1" value="c"> Berlin<br>

        <h3>2. What is 2 + 2?</h3>
        <input type="radio" name="q2" value="a" required> 3<br>
        <input type="radio" name="q2" value="b"> 4<br>
        <input type="radio" name="q2" value="c"> 5<br>

        <h3>3. What is the largest planet in the Solar System?</h3>
        <input type="radio" name="q3" value="a" required> Earth<br>
        <input type="radio" name="q3" value="b"> Mars<br>
        <input type="radio" name="q3" value="c"> Jupiter<br>

        <h3>4. What is the boiling point of water?</h3>
        <input type="radio" name="q4" value="a" required> 100°C<br>
        <input type="radio" name="q4" value="b"> 90°C<br>
        <input type="radio" name="q4" value="c"> 110°C<br>

        <h3>5. What is the chemical symbol for water?</h3>
        <input type="radio" name="q5" value="a" required> CO2<br>
        <input type="radio" name="q5" value="b"> H2O<br>
        <input type="radio" name="q5" value="c"> O2<br>

        <br>
        <button type="submit">Submit</button>
    </form>
    <?php
    }
    ?>  

</body>
</html>
