<?php
// Include fetch.php to get $result
#include 'fetch.php';


?>

<!DOCTYPE html>
<html lang="kn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ಮುಖ್ಯ ಪುಟ</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('village_panchayath.jpg');
            background-size: cover;
            background-attachment: fixed;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            width: 100%;
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
            height: 30px;
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

        .container {
            text-align: center;
            padding: 30px;
            background-color: rgba(0, 0, 0, 0.6);
            color: white;
            border-bottom: 5px solid rgba(0, 0, 0, 0.8);
            width: 80%;
            margin: 0 auto;
            margin-top: 20px;
            border-radius: 8px;
        }

        /* New Button Styles */
        .btn {
            padding: 1rem 2rem;
            font-weight: 700;
            background: rgba(255, 255, 255, 0.9);
            color: #333;
            cursor: pointer;
            border-radius: 0.5rem;
            border: 2px solid #333;
            transition-duration: 0.3s;
            text-decoration: none;
            display: inline-block;
            margin: 10px;
        }

        .btn:hover {
            background: #333;
            color: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
            transform: translateY(-2px);
        }

        .content {
            margin: 50px auto;
            text-align: center;
            width: 60%;
            background: rgba(255, 255, 255, 0.95);
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
            border-radius: 8px;
            padding: 20px;
        }
        .content p {
            font-size: 1.2rem;
            color: #333;
        }
        .btn-container {
            margin-top: 30px;
        }
        footer {
            text-align: center;
            margin-top: 50px;
            padding: 10px;
            background: #333;
            color: white;
            font-size: 0.9rem;
        }
        .term {
            margin-bottom: 30px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 15px;
        }
        .term h3 {
            font-size: 1.5rem;
        }
        .term p {
            font-size: 1.2rem;
        }
    </style>
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar">
    <a href="https://ka-naada.com/" target="_blank">
        <div class="logo">
            <img src="ka-naada logo.png" alt="Logo">
        </div>
        <div class="nav-links">
            <a href="index.php">ಮುಖ್ಯ ಪುಟ</a>
            <a href="profile.php">ವ್ಯಕ್ತಿಚಿತ್ರ</a>
            <a href="help.php">ಸಹಾಯ ಮತ್ತು ಸಂಪರ್ಕ</a>
            <a href="feedback.php">ಪ್ರತಿಕ್ರಿಯೆ</a>
        </div>
    </nav>

    <div class="container">
        <h1>ಪಂಚಾಯತಿ ಶಬ್ದಕೋಶ ನಿರ್ವಾಹಣೆ</h1>
        <p>ಕನ್ನಡ ಶಬ್ದ ಸೇರಿಸಲು ಮತ್ತು ವೀಕ್ಷಿಸಲು ಪ್ರಾರಂಭಿಸಿ</p>
    </div>

    <div class="content">
        <p>ನೀವು ಶಬ್ದಕೋಶ ದಲ್ಲಿ ಹೊಸ ಕನ್ನಡ ಶಬ್ದಗಳನ್ನು ಸೇರಿಸಬಹುದು ಅಥವಾ ಈಗಿರುವ ಶಬ್ದವನ್ನು ವೀಕ್ಷಿಸಬಹುದು.</p>
        <div class="btn-container">
            <a href="insert.php" class="btn">ಹೊಸ ಶಬ್ದ ಸೇರಿಸಿ</a>
            <a href="fetch.php" class="btn">ಶಬ್ದಕೋಶ ವೀಕ್ಷಿಸಿ</a>
        </div>

        <div class="terms-list">
            <?php
            // Check if the query returned any results
            if (isset($result) && $result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<div class='term'>";
                    echo "<h3>" . $row["term_kannada"] . " (" . $row["term_english"] . ")</h3>";
                    echo "<p><strong>ಕನ್ನಡದಲ್ಲಿ ವಿವರ:</strong><br>" . $row["description_kannada"] . "</p>";
                    echo "<p><strong>ಇಂಗ್ಲಿಷ್ ವಿವರಣೆ:</strong><br>" . $row["description_english"] . "</p>";
                    echo "</div>";
                }
            }
            ?>
        </div>
    </div>

    <footer>
        © <?php echo date("Y"); ?> ಕ-ನಾದ. ಎಲ್ಲ ಹಕ್ಕುಗಳು ಮೀಸಲಾಗಿವೆ.
    </footer>
</body>
</html>
