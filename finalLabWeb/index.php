
<?php 
  require 'database.php'
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Document</title>
    <link
      href="https://cdn.jsdelivr.net/npm/daisyui@4.12.14/dist/full.min.css"
      rel="stylesheet"
      type="text/css"
    />
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body>
    <header class="mb-3">
      <img src="Asset/id.png" alt="" srcset="" />
    </header>
    <main class="mb-24">
      <section class="border border-red-700 w-4/5 mx-auto pb-12">
        <div class="w-4/5 border border-red-700 h-auto mt-20 my-4 mx-auto">
            <h3>Book List</h3>
            <table border='1' cellpadding="10" cellspacing="0">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>ISBN</th>
                    <th>Category</th>
                </tr>
                <?php
                // Write the SQL query to fetch all books
                $sql = "SELECT * FROM book";

                // Execute the query
                $result = mysqli_query($conn, $sql);

                // Check if there are rows returned
                if (mysqli_num_rows($result) > 0) {
                    // Fetch each row as an associative array and display it
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['id']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['title']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['isbn']) . "</td>";
                        echo "<td>" . htmlspecialchars($row['category']) . "</td>";
                        echo "</tr>";
                    }
                } else {
                    // If no rows found, display a message
                    echo "<tr><td colspan='4'>No books found in the database.</td></tr>";
                }

                // Close the database connection
                mysqli_close($conn);
                ?>
            </table>       
        </div>


        <div class="w-4/5 border border-green-700 h-auto my-4 mx-auto">
        <div class="w-4/5 border border-red-700 h-auto mt-20 my-4 mx-auto">
    <h3>Book Management</h3>

    <!-- Form to Search Book by ID -->
    <form method="POST" action="">
        <label for="book_id">Search Book by ID:</label>
        <input type="number" name="book_id" id="book_id" required>
        <button type="submit" name="search">Search</button>
    </form>

    <?php
    // Database connection
    $conn = mysqli_connect("localhost", "root", "", "booklist");

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Fetch book details if search is submitted
    if (isset($_POST['search'])) {
        $book_id = intval($_POST['book_id']);
        $sql = "SELECT * FROM book WHERE id = $book_id";
        $result = mysqli_query($conn, $sql);

        if (mysqli_num_rows($result) > 0) {
            $book = mysqli_fetch_assoc($result);
    ?>
            <!-- Display book details in a form for update or delete -->
            <form method="POST" action="">
                <h4>Book Details</h4>
                <input type="hidden" name="book_id" value="<?php echo $book['id']; ?>">
                <label for="title">Title:</label>
                <input type="text" name="title" id="title" value="<?php echo htmlspecialchars($book['title']); ?>" required>
                <br>
                <label for="isbn">ISBN:</label>
                <input type="text" name="isbn" id="isbn" value="<?php echo htmlspecialchars($book['isbn']); ?>" required>
                <br>
                <label for="category">Category:</label>
                <input type="text" name="category" id="category" value="<?php echo htmlspecialchars($book['category']); ?>" required>
                <br>
                <button type="submit" name="update">Update</button>
                <button type="submit" name="delete">Delete</button>
            </form>
    <?php
        } else {
            echo "<p>No book found with ID: $book_id</p>";
        }
    }

    // Update book details
    if (isset($_POST['update'])) {
        $book_id = intval($_POST['book_id']);
        $title = mysqli_real_escape_string($conn, $_POST['title']);
        $isbn = mysqli_real_escape_string($conn, $_POST['isbn']);
        $category = mysqli_real_escape_string($conn, $_POST['category']);

        $sql = "UPDATE book SET title='$title', isbn='$isbn', category='$category' WHERE id=$book_id";
        if (mysqli_query($conn, $sql)) {
            echo "<p>Book updated successfully!</p>";
        } else {
            echo "<p>Error updating book: " . mysqli_error($conn) . "</p>";
        }
    }

    // Delete book
    if (isset($_POST['delete'])) {
        $book_id = intval($_POST['book_id']);
        $sql = "DELETE FROM book WHERE id=$book_id";
        if (mysqli_query($conn, $sql)) {
            echo "<p>Book deleted successfully!</p>";
        } else {
            echo "<p>Error deleting book: " . mysqli_error($conn) . "</p>";
        }
    }

    // Close the database connection
    mysqli_close($conn);
    ?>
</div>

        </div>

        <div class="w-4/5 border border-red-700 h-36 my-4 mx-auto grid grid-cols-2">
        <!-- Available Tokens Section -->
        <div class="border border-r-2 p-4">
          <h1>Available Tokens</h1>
          <ul>
            <?php
            $tokenFile = "./token.json";
            if (file_exists($tokenFile)) {
                $jsonData = json_decode(file_get_contents($tokenFile), true);

                if (isset($jsonData[0]['token'])) {
                    foreach ($jsonData[0]['token'] as $token) {
                        if (!in_array((string)$token, $jsonData[0]['usedToken'])) {
                            echo "<li>Token: $token</li>";
                        }
                    }
                } else {
                    echo "<li>No available tokens found in the JSON file.</li>";
                }
            } else {
                echo "<li>JSON file not found.</li>";
            }
            ?>
          </ul>
        </div>

        <!-- Used Tokens Section -->
        <div class="p-4">
          <h2>Used Tokens</h2>
          <ul>
            <?php
            if (file_exists($tokenFile)) {
                $jsonData = json_decode(file_get_contents($tokenFile), true);

                if (isset($jsonData[0]['usedToken'])) {
                    foreach ($jsonData[0]['usedToken'] as $usedToken) {
                        echo "<li>Token: $usedToken</li>";
                    }
                } else {
                    echo "<li>No used tokens found in the JSON file.</li>";
                }
            } else {
                echo "<li>JSON file not found.</li>";
            }
            ?>
          </ul>
        </div>
      </div>

       

        <section class="grid grid-cols-3 w-4/5 mx-auto gap-4">
          <div
            class="border border-green-800 p-4 flex flex-col items-center justify-between bg-stone-400"
          >
            <img src="Asset/book 1.jpg" class="w-96 h-80 object-contain" />
          </div>
          <div
            class="border border-green-800 p-4 flex flex-col items-center justify-between"
          >
            <img src="Asset/book 2.jpg" class="w-96 h-80 object-contain" />
          </div>
          <div
            class="border border-green-800 p-4 flex flex-col items-center justify-between space-y-4"
          >
            <img src="Asset/book 3.jpg" class="w-96 h-80 object-contain" />
          </div>
        </section>
        <section class="grid grid-cols-3 w-4/5 mx-auto mt-6 gap-4">
          <div class="col-span-2 border border-red-800 h-auto">
            <form action="process.php" method="post" class="p-6 space-y-3">
              <input
                type="text"
                required
                placeholder="Enter your Name"
                name="userName"
                class="border border-black w-4/5 h-8 rounded-xl px-4"
              />
              <input
                type="text"
                required
                placeholder="Enter your Id"
                name="userId"
                class="border border-black w-4/5 h-8 rounded-xl px-4"
              />
              <select
  name="bookName"
  required
  class="border border-black w-4/5 h-8 rounded-xl px-4"
>
  <option value="" disabled selected>Select a Book</option>
  <option value="The Great Gatsby">The boy with the tigers heart</option>
  <option value="To Kill a Mockingbird">Harry Potter</option>
  <option value="1984">1984</option>
  <option value="Pride and Prejudice">Light Beyond the garden</option>
</select>
              <input
                type="number"
                required
                placeholder="EnterToken"
                name="tokenNumber"
                class="border border-black w-4/5 h-8 rounded-xl px-4"
              />
              <input
                type="number"
                required
                placeholder="Fee"
                name="fees"
                class="border border-black w-4/5 h-8 rounded-xl px-4"
              />

              <label for="borrowDate" class="block">Borrow Date:</label>
              <input
                type="date"
                required
                name="borrowDate"
                class="border border-black w-4/5 h-8 rounded-xl px-4"
              />

              <label for="returnDate" class="block">Return Date:</label>
              <input
                type="date"
                required
                name="returnDate"
                class="border border-black w-4/5 h-8 rounded-xl px-4"
              />

              <!-- payment -->
              <br />
              <h3 class="text-xl font-bold">Paid:</h3>
              <div class="px-3">
                <input
                  type="radio"
                  required
                  id="yes"
                  name="payment"
                  value="yes"
                />
                <label for="yes">Yes</label><br />

                <input
                  type="radio"
                  required
                  id="no"
                  name="payment"
                  value="no"
                />
                <label for="no">No</label><br />
              </div>
              <!-- <button class="btn btn-primary">Submit</button> -->
              <input
                type="submit"
                value="Submit"
                class="border border-black px-4 py-2 rounded-2xl bg-stone-200 hover:bg-stone-300"
              />
            </form>
          </div>

          <div class="border border-red-800 h-auto">
            <div class="p-4">
              <form
                action="submit.php"
                method="post"
                class="space-y-3 text-center"
              >
                <input
                  type="text"
                  name="bookName"
                  placeholder="Book Name"
                  class="border border-black rounded-xl px-2 h-8 w-full"
                />
                <input
                  type="text"
                  name="authorName"
                  placeholder="Author Name"
                  class="border border-black rounded-xl px-2 h-8 w-full"
                />
                <input
                  type="text"
                  name="isbnNumber"
                  placeholder="ISBN Number"
                  class="border border-black rounded-xl px-2 h-8 w-full"
                />
                <input
                  type="number"
                  name="bookCount"
                  placeholder="Book Count"
                  class="border border-black rounded-xl px-2 h-8 w-full"
                />
                <input
                  type="text"
                  name="category"
                  placeholder="Book Category"
                  class="border border-black rounded-xl px-2 h-8 w-full"
                />
                <input
                  type="submit"
                  value="SUBMIT"
                  class="font-bold border border-black px-4 py-2 rounded-2xl bg-stone-200 hover:bg-stone-300 w-full"
                />
              </form>
            </div>
          </div>
        </section>
      </section>
    </main>
  </body>
</html>
