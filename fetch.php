<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'panchayat_land',3307); // Replace with your database name
$conn->set_charset("utf8mb4");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle delete request
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['id'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM panchayat_terms_kannada WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $deleteMessage = "ಡೇಟಾ ಯಶಸ್ವಿಯಾಗಿ ತೆಗೆದುಹಾಕಲಾಗಿದೆ"; // Data removed successfully
    } else {
        $deleteMessage = "ಡೇಟಾ ತೆಗೆದುಹಾಕಲು ವಿಫಲವಾಗಿದೆ"; // Failed to remove data
    }

    $stmt->close();
}

// Add search functionality
$searchQuery = '';
if(isset($_GET['search']) && !empty($_GET['search'])) {
    $searchQuery = $_GET['search'];
    $sql = "SELECT * FROM panchayat_terms_kannada WHERE 
            kannada_word LIKE ? OR 
            english_pronunciation LIKE ? OR 
            pronounciation_hindi LIKE ? OR 
            translated_term LIKE ? OR 
            pronunciation_in_kannada LIKE ?";
    $stmt = $conn->prepare($sql);
    $searchTerm = "%$searchQuery%";
    $stmt->bind_param("sssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $sql = "SELECT * FROM panchayat_terms_kannada";
    $result = $conn->query($sql);
}
?>

<!DOCTYPE html>
<html lang="kn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ಪಂಚಾಯತ್ ರಾಜ್ ಶಬ್ದಕೋಶ</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;  /* Remove padding */
            padding: 0; /* Remove padding */
            background-image: url('fetch_panchayath.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .container {
            flex: 1;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 10px;
            margin: 20px auto;
            max-width: 95%;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
            background-color: rgba(255, 255, 255, 0.95);
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background-color: #000;
            color: white;
            transition: background-color 0.3s;
        }

        th:hover {
            background-color: #333;
        }

        tr:nth-child(even) {
            background-color: rgba(249, 249, 249, 0.9);
        }

        tr:hover {
            background-color: rgba(221, 221, 221, 0.9);
        }

        h1 {
            color: white;
            text-align: center;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
        }

     
       
        /* Navigation Bar Styles */
        .navbar {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 10px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .logo img {
            height: 50px;
            width: auto;
            object-fit: contain;
        }

        .nav-links {
            display: flex;
            gap: 20px;
        }

        .nav-links a {
            text-decoration: none;
            color: #333;
            padding: 8px 15px;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .nav-links a:hover {
            background-color: #f0f0f0;
        }

       

        footer {
            text-align: center;
            padding: 10px;
            background: #333;
            color: white;
            font-size: 0.9rem;
            margin-top: auto;
        }

       
        
        /* Updated Search Bar Styles */
        .search-container {
            display: flex;
            justify-content: center;
            margin: 20px 0;
            padding: 0 20px;
            width: 100%;
        }

        .group {
            display: flex;
            line-height: 28px;
            align-items: center;
            position: relative;
            max-width: 1000px;
            width: 100%;
            transition: all 0.3s ease;
        }

        .input {
            width: 100%;
            height: 60px;
            line-height: 28px;
            padding: 0 1rem;
            padding-left: 3rem;
            border: 2px solid #ddd;
            border-radius: 8px;
            outline: none;
            background-color: #f3f3f4;
            color: #0d0c22;
            transition: .3s ease;
            font-size: 18px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
        }

        .input::placeholder {
            color: #666;
            font-size: 18px;
        }

        .input:hover {
            border-color: #aaa;
            background-color: #fff;
            box-shadow: 0 4px 10px rgba(0,0,0,0.15);
            transform: translateY(-1px);
        }

        .input:focus {
            border-color: #333;
            background-color: #fff;
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
            transform: translateY(-2px);
        }

        .search-form {
            width: 100%;
            max-width: 1000px;
        }

        .icon {
            position: absolute;
            left: 1rem;
            width: 1.5rem;
            height: 1.5rem;
            fill: #666;
            transition: all 0.3s ease;
        }

        .input:hover + .icon,
        .input:focus + .icon {
            fill: #333;
        }

        /* Back Button Styles */
        .back-button {
            position: absolute;
            right: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            text-decoration: none;
            padding: 5px;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .back-button:hover {
            background-color: rgba(0,0,0,0.1);
        }

        .back-icon {
            width: 1.5rem;
            height: 1.5rem;
            fill: #666;
        }
    </style>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script>
    $(document).ready(function() {
        $(".input").autocomplete({
            source: function(request, response) {
                $.getJSON("get_suggestions.php", { term: request.term }, function(data) {
                    response($.map(data, function(item) {
                        return {
                            label: item.kannada + ' - ' + item.english + ' - ' + item.hindi,
                            value: item.kannada
                        };
                    }));
                });
            },
            minLength: 1
        });
    });
    </script>
    <script>
    $(document).ready(function() {
        $(".input").autocomplete({
            source: function(request, response) {
                $.getJSON("get_suggestions.php", { term: request.term }, function(data) {
                    response($.map(data, function(item) {
                        return {
                            label: item.kannada + ' - ' + item.english + ' - ' + item.hindi + ' - ' + item.translated,
                            value: item.kannada
                        };
                    }));
                });
            },
            minLength: 1,
            select: function(event, ui) {
                $(this).val(ui.item.value);
                return false;
            }
        }).autocomplete("instance")._renderItem = function(ul, item) {
            return $("<li>")
                .append("<div>" + item.label + "</div>")
                .appendTo(ul);
        };
    });
    </script>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
        <div class="logo">
            <a href="https://ka-naada.com/" target="_blank">
                <img src="ka-naada logo.png" alt="Logo">
            </a>
        </div>
        <div class="nav-links">
            <a href="index.php">ಮುಖ್ಯ ಪುಟ</a>
            <a href="profile.php">ವ್ಯಕ್ತಿಚಿತ್ರ</a>
            <a href="help.php">ಸಹಾಯ ಮತ್ತು ಸಂಪರ್ಕ</a>
            <a href="feedback.php">ಪ್ರತಿಕ್ರಿಯೆ</a>
        </div>
    </nav>

    <div class="search-container">
        <form method="GET" class="search-form">
            <div class="group">
                <!-- Search Icon -->
                <svg class="icon search-icon" aria-hidden="true" viewBox="0 0 24 24">
                    <g><path d="M21.53 20.47l-3.66-3.66C19.195 15.24 20 13.214 20 11c0-4.97-4.03-9-9-9s-9 4.03-9 9 4.03 9 9 9c2.215 0 4.24-.804 5.808-2.13l3.66 3.66c.147.146.34.22.53.22s.385-.073.53-.22c.295-.293.295-.767.002-1.06zM3.5 11c0-4.135 3.365-7.5 7.5-7.5s7.5 3.365 7.5 7.5-3.365 7.5-7.5 7.5-7.5-3.365-7.5-7.5z"></path></g>
                </svg>
                <input 
                    name="search" 
                    placeholder="ಕನ್ನಡ ಅಥವಾ ಇಂಗ್ಲಿಷ್‌ನಲ್ಲಿ ಹುಡುಕಿ..." 
                    type="search" 
                    class="input"
                    value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
                    autocomplete="off"
                >
                <!-- Back Button -->
                <?php if(isset($_GET['search'])): ?>
                    <a href="fetch.php" class="back-button">
                        <svg class="icon back-icon" viewBox="0 0 24 24">
                            <path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"/>
                        </svg>
                    </a>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <div class="container">
        <h1>ಪಂಚಾಯತ್ ರಾಜ್ ಶಬ್ದಕೋಶ</h1>

        <?php if ($searchQuery && $result->num_rows === 0): ?>
            <p style='text-align: center; color: #333;'>ಯಾವುದೇ ಫಲಿತಾಂಶಗಳು ಕಂಡುಬಂದಿಲ್ಲ: "<?php echo htmlspecialchars($searchQuery); ?>"</p>
        <?php endif; ?>

        <?php if ($result->num_rows > 0): ?>
            <table>
                <tr>
                    <th>ಕನ್ನಡ ಶಬ್ದ<br><small>kannada_script</small></th>
                    <th>ಇಂಗ್ಲೀಷ್ ಉಚ್ಚಾರಣೆ<br><small>english_pronounciation</small></th>
                    <th>हिंदी शब्द<br><small>hindi_pronounciation</small></th>
                    <th>ಅನುವಾದಿತ ಪದ<br><small>english term</small></th>
                    <th>ಕನ್ನಡದಲ್ಲಿ ಉಚ್ಚಾರಣೆ<br><small>kannada_pronounciation</small></th>
                </tr>
                <?php while($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row["kannada_word"]); ?></td>
                        <td><?php echo htmlspecialchars($row["english_pronunciation"]); ?></td>
                        <td><?php echo htmlspecialchars($row["pronounciation_hindi"]); ?></td>
                        <td><?php echo htmlspecialchars($row["translated_term"]); ?></td>
                        <td><?php echo htmlspecialchars($row["pronunciation_in_kannada"]); ?></td>
                    </tr>
                <?php endwhile; ?>
            </table>
        <?php endif; ?>
    </div>

    <footer>
        © <?php echo date("Y"); ?> ಕ-ನಾದ. ಎಲ್ಲ ಹಕ್ಕುಗಳು ಮೀಸಲಾಗಿವೆ.
    </footer>
</body>
</html>
