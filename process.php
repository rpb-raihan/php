<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
        $userName = isset($_POST['userName']) ? ($_POST['userName']) : '';
        $userId = isset($_POST['userId']) ? htmlspecialchars($_POST['userId']) : '';
        $bookName = isset($_POST['bookName']) ? htmlspecialchars($_POST['bookName']) : '';
        $tokenNumber = isset($_POST['tokenNumber']) ? htmlspecialchars($_POST['tokenNumber']) : '';
        $fees = isset($_POST['fees']) ? htmlspecialchars($_POST['fees']) : '';
        $borrowDate = isset($_POST['borrowDate']) ? htmlspecialchars($_POST['borrowDate']) : '';
        $returnDate = isset($_POST['returnDate']) ? htmlspecialchars($_POST['returnDate']) : '';
        $payment = isset($_POST['payment']) ? htmlspecialchars($_POST['payment']) : '';
        $flag = true;
        
        echo "<h2>Form Data:</h2>";
        if (preg_match("/^[A-Za-z]+$/", $userName)) {
            echo "<p><strong>Name:</strong> $userName</p>";
        } else {
            echo "Username is invalid. It should only contain letters.";
            echo "<br>";
            $flag = false;
        }
        
        
        if (preg_match("/^\d{2}-\d{5}-[123]$/", $userId)) {
            echo "<p><strong>ID:</strong> $userId</p>";
        } else {
            echo "Error: User ID '$userId' is invalid.";
            echo "<br>";
            $flag = false;
        }

        if (empty($bookName)) {
            echo "Error: Book Name cannot be empty.";
            $flag = false;
        } else {
            echo "<p><strong>Book Title:</strong> $bookName</p>";
            
        }
        
        echo "<p><strong>Token Number:</strong> $tokenNumber</p>";
        echo "<p><strong>Fee:</strong> $fees</p>";
        
        if ($borrowDate && $returnDate) {
            
            $borrowTimestamp = strtotime($borrowDate);
            $returnTimestamp = strtotime($returnDate);
        
            $daysDifference = ($returnTimestamp - $borrowTimestamp) / (60 * 60 * 24);
        
            if ($daysDifference < 0) {
                echo "Return date must be the same or later than the borrow date.";
            } elseif ($daysDifference > 10) {
                echo "Return date must be within 10 days of the borrow date.";
            } else {
                echo "<p><strong>Borrow Date:</strong> $borrowDate</p>";
                echo "<p><strong>Return Date:</strong> $returnDate</p>";
        
            }
        } else {
            echo "Both borrow date and return date are required.";
             $flag = false;
        }
        echo "<p><strong>Payment Status:</strong> $payment</p>";

        // TOKEN
        $tokenNumber = $_POST['tokenNumber'];

        // Path to the token.json file
        $filePath = 'token.json';
    
        // Check if the file exists; if not, create it with an empty structure
        if (!file_exists($filePath)) {
            file_put_contents($filePath, json_encode(['usedTokens' => []], JSON_PRETTY_PRINT));
        }
    
        // Read the current contents of the JSON file
        $jsonData = file_get_contents($filePath);
        $data = json_decode($jsonData, true);
    
        // Ensure 'usedTokens' key exists and is an array
        if (!isset($data['usedTokens']) || !is_array($data['usedTokens'])) {
            $data['usedTokens'] = [];
        }
    
        // Check if the token is already in the usedTokens array
        if (in_array($tokenNumber, $data['usedTokens'])) {
            echo "Invalid token: Token number $tokenNumber has already been used and cannot be reused!";
        } else {
            // Append the new token to the usedTokens array
            $data['usedTokens'][] = $tokenNumber;
    
            // Save the updated data back to the file
            file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT));
            echo "Token number $tokenNumber saved successfully!";
        }
    

        //COOKIE

        //validation code:
        if (!empty($bookName)) {
            // Sanitize the book name to match the cookie format in process.php
            $sanitized_book_name = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $bookName);
        
            if (isset($_COOKIE[$sanitized_book_name])) {
                echo "Book is not available";
            } else {
                $cookie_name = preg_replace('/[^a-zA-Z0-9_\-]/', '_', $bookName); // Replace invalid characters with underscores
                $cookie_value = $userName;
                if ($flag) {
                    // Set the cookie with the sanitized name
                    setcookie($cookie_name, $cookie_value, time() + 120); // Cookie valid for 2 minutes
                    echo "<p>Book Borrowed Successfully</p>";
                }
            }
        } else {
            echo "Invalid book name";
        }
   
      
         
    }

?>   
