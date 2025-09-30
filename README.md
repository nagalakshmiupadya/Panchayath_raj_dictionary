📖 Introduction

The Panchayath Raj Dictionary is a bilingual web application designed to support local governance and rural communities by simplifying access to administrative terms in both Kannada and English. The idea was to bridge the communication gap between government officials, local representatives, and citizens by providing a simple, interactive, and voice-enabled dictionary.

The system enables users to search for Panchayath Raj-related terminology and instantly get definitions, translations, and contextual meanings in their preferred language. This ensures that governance processes become more transparent, inclusive, and accessible to all citizens, regardless of their English proficiency.

🚀 Features

🔍 Bilingual Search (Kannada/English) – enter a word in either language to get translations and definitions.

🎙️ Voice-Enabled Search – integrated with Speech-to-Text (OpenAI Whisper) for hands-free search in Kannada or English.

📚 Admin Approval System – new terms/definitions suggested by users must be reviewed and approved by an admin before publishing.

🗄️ Database-Driven Storage – all terms, translations, and definitions are stored in a MySQL database for scalability.

🌐 Responsive Design – accessible across desktops, tablets, and mobile devices.

🛡️ Secure Login System – admin authentication to manage the dictionary’s content.

📊 User-Friendly Interface – simple, intuitive UI for both rural citizens and officials.

🛠️ Tech Stack

Frontend: HTML, CSS, JavaScript (Bootstrap for responsiveness)

Backend: Python (Flask/Django)

Database: MySQL (via XAMPP)

APIs/Libraries:

OpenAI Whisper (Speech-to-Text)

Google Translate API (optional, fallback translations)

Tools: XAMPP, phpMyAdmin, GitHub for version control

🔄 How It Works

User Input: The user enters a word (Kannada/English) via text or speech.

Processing:

The system detects the language.

Searches the MySQL database for the matching word and definition.

Output:

Displays the translation + definition in both Kannada & English.

Provides contextual meaning related to Panchayath Raj governance.

Admin Workflow:

Admin logs in to add, edit, or approve new entries.

Unverified entries remain hidden until approval.

🧩 Modules

User Module – search words, view translations, use voice input.

Admin Module – approve/edit dictionary entries, manage user suggestions.

Database Module – structured storage of bilingual terms and metadata.

Speech Module – Whisper API integration for Kannada/English speech recognition.

Website is live now!
https://panchayath.wuaze.com/
