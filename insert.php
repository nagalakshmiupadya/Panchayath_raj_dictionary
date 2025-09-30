<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'panchayat_land',3307); // Replace with your database name

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $term_in_kannada = $_POST['term_in_kannada'];
    $english_pronunciation = $_POST['english_pronunciation'];
    $translated_term = $_POST['translated_term'];
    $pronunciation_in_kannada = $_POST['pronunciation_in_kannada'];

    // Update the table name to match your database
    $stmt = $conn->prepare("INSERT INTO panchayat_terms_kannada (kannada_word, english_pronunciation, translated_term, pronunciation_in_kannada) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $term_in_kannada, $english_pronunciation, $translated_term, $pronunciation_in_kannada);

    // Execute and check if the insertion was successful
    if ($stmt->execute()) {
        $message = "New record created successfully.";
    } else {
        $message = "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}

// Include header
//include 'header.php';
?>

<!DOCTYPE html>
<html lang="kn">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ಪದಗಳನ್ನು ಶಬ್ದಕೋಶಕ್ಕೆ ಸೇರಿಸಿ</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('insert_panchayath.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            min-height: 100vh;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            border-radius: 12px;
            box-sizing: border-box;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 30px;
        }

        label {
            font-weight: bold;
            margin-bottom: 8px;
            display: block;
            color: #333;
        }

        input[type="text"] {
            width: 100%;
            padding: 12px;
            padding-right: 45px; /* Increased space for microphone button */
            border: 1px solid rgba(0, 0, 0, 0.2);
            border-radius: 6px;
            font-size: 16px;
            background-color: rgba(255, 255, 255, 0.9);
            box-sizing: border-box;
            height: 45px; /* Fixed height for input */
            line-height: 45px;
        }

        /* New Button Styles */
        .button {
            --black-700: hsla(0 0% 12% / 1);
            --border_radius: 9999px;
            --transtion: 0.3s ease-in-out;
            --offset: 2px;
            cursor: pointer;
            position: relative;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transform-origin: center;
            padding: 1rem 2rem;
            background-color: transparent;
            border: none;
            border-radius: var(--border_radius);
            transform: scale(calc(1 + (var(--active, 0) * 0.1)));
            transition: transform var(--transtion);
            width: 200px;
            margin: 20px auto;
            justify-content: center;  /* Add this line */
        }

        .button::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            height: 100%;
            background-color: var(--black-700);
            border-radius: var(--border_radius);
            box-shadow: inset 0 0.5px hsl(0, 0%, 100%), 
                       inset 0 -1px 2px 0 hsl(0, 0%, 0%),
                       0px 4px 10px -4px hsla(0 0% 0% / calc(1 - var(--active, 0))),
                       0 0 0 calc(var(--active, 0) * 0.375rem) hsl(260 97% 50% / 0.75);
            transition: all var(--transtion);
            z-index: 0;
        }

        .button::after {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 100%;
            height: 100%;
            background-color: hsla(260 97% 61% / 0.75);
            background-image: radial-gradient(
                at 51% 89%,
                hsla(266, 45%, 74%, 1) 0px,
                transparent 50%
            ),
            radial-gradient(at 100% 100%, hsla(266, 36%, 60%, 1) 0px, transparent 50%),
            radial-gradient(at 22% 91%, hsla(266, 36%, 60%, 1) 0px, transparent 50%);
            background-position: top;
            opacity: var(--active, 0);
            border-radius: var(--border_radius);
            transition: opacity var(--transtion);
            z-index: 2;
        }

        .button:is(:hover, :focus-visible) {
            --active: 1;
        }

        .button:active {
            transform: scale(1);
        }

        .button .text_button {
            position: relative;
            z-index: 10;
            color: white;
            font-size: 1rem;
            text-align: center;      /* Add this line */
            width: 100%;            /* Add this line */
        }

        .message {
            text-align: center;
            font-size: 16px;
            color: #333;
            margin-bottom: 20px;
            padding: 10px;
            border-radius: 6px;
            background-color: rgba(255, 255, 255, 0.9);
        }

        /* Navigation and Footer styles from index.php */
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

        footer {
            text-align: center;
            margin-top: 50px;
            padding: 10px;
            background: #333;
            color: white;
            font-size: 0.9rem;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        .form-group {
            position: relative;
            margin-bottom: 20px;
            width: 100%;
        }

        .voice-input-button {
            --black-700: hsla(0 0% 12% / 1);
            position: absolute;
            right: 8px; /* Reduced right margin */
            top: calc(50% + 15px); /* Move down by adding pixels */
            transform: translateY(-50%); /* Adjusted vertical alignment */
            width: 30px;
            height: 30px;
            border: none;
            border-radius: 50%;
            background: var(--black-700);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            cursor: pointer;
            padding: 0;
            font-size: 14px;
            z-index: 2;
            margin-top: 0; /* Removed margin-top */
        }

        .voice-input-button:hover {
            background: #444;
        }

        .voice-input-button.listening {
            background: #ff4444;
            animation: pulse 1.5s infinite;
        }

        @keyframes pulse {
            0% { transform: translateY(-50%); opacity: 1; }
            50% { transform: translateY(-50%); opacity: 0.7; }
            100% { transform: translateY(-50%); opacity: 1; }
        }
    </style>

    <script>
    function startSpeechRecognition(inputId, language) {
        const button = document.querySelector(`#${inputId}_voice`);
        button.classList.add('listening');
        
        let recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
        recognition.lang = language; // "kn-IN" for Kannada, "en-US" for English
        recognition.start();

        recognition.onresult = function(event) {
            document.getElementById(inputId).value = event.results[0][0].transcript;
            button.classList.remove('listening');
        };

        recognition.onerror = function(event) {
            console.error("ದೋಷ ಸಂಭವಿಸಿದೆ: ", event.error);
            button.classList.remove('listening');
        };

        recognition.onend = function() {
            button.classList.remove('listening');
        };
    }
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

    <div class="container">
        <h1>ಪದಗಳನ್ನು ಶಬ್ದಕೋಶಕ್ಕೆ ಸೇರಿಸಿ</h1>

        <?php if (isset($message)) { ?>
            <div class="message"><?php echo $message; ?></div>
        <?php } ?>

        <form method="post">
            <div class="form-group">
                <label for="term_in_kannada">ಕನ್ನಡ ಶಬ್ದ:</label>
                <input type="text" id="term_in_kannada" name="term_in_kannada" required>
                <button type="button" id="term_in_kannada_voice" class="voice-input-button" 
                        onclick="startSpeechRecognition('term_in_kannada', 'kn-IN')" title="ಕನ್ನಡದಲ್ಲಿ ಮಾತನಾಡಿ">
                    🎤
                </button>
            </div>

            <div class="form-group">
                <label for="english_pronunciation">ಇಂಗ್ಲೀಷ್ ಉಚ್ಚಾರಣೆ:</label>
                <input type="text" id="english_pronunciation" name="english_pronunciation" required>
                <button type="button" id="english_pronunciation_voice" class="voice-input-button" 
                        onclick="startSpeechRecognition('english_pronunciation', 'en-US')" title="Speak in English">
                    🎤
                </button>
            </div>

            <div class="form-group">
                <label for="translated_term">ಅನುವಾದಿತ ಪದ:</label>
                <input type="text" id="translated_term" name="translated_term" required>
                <button type="button" id="translated_term_voice" class="voice-input-button" 
                        onclick="startSpeechRecognition('translated_term', 'en-US')" title="Speak in English">
                    🎤
                </button>
            </div>

            <div class="form-group">
                <label for="pronunciation_in_kannada">ಕನ್ನಡದಲ್ಲಿ ಉಚ್ಚಾರಣೆ:</label>
                <input type="text" id="pronunciation_in_kannada" name="pronunciation_in_kannada" required>
                <button type="button" id="pronunciation_in_kannada_voice" class="voice-input-button" 
                        onclick="startSpeechRecognition('pronunciation_in_kannada', 'kn-IN')" title="ಕನ್ನಡದಲ್ಲಿ ಮಾತನಾಡಿ">
                    🎤
                </button>
            </div>

            <button type="submit" class="button">
                <span class="text_button">ಶಬ್ದ ಸೇರಿಸಿ</span>
            </button>
        </form>
    </div>

    <footer>
        © <?php echo date("Y"); ?> ಕ-ನಾದ. ಎಲ್ಲ ಹಕ್ಕುಗಳು ಮೀಸಲಾಗಿವೆ.
    </footer>
</body>
</html>
