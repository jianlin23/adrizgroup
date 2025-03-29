<?php
// JavaScript to handle language selection
// Modify the language selection script
function renderLanguageScript() {
    ?>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const langButtons = document.querySelectorAll('.lang-btn');
        
        langButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const selectedLang = this.getAttribute('data-lang');
                const currentLang = localStorage.getItem('preferredLanguage') || 'en';
                
                // Update active state
                langButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');
                
                // Store language preference in localStorage
                localStorage.setItem('preferredLanguage', selectedLang);
                
                // Get current URL parameters
                const urlParams = new URLSearchParams(window.location.search);
                let activityID = parseInt(urlParams.get('activityID'));
                
                // Adjust activityID based on language switch
                if (activityID) {
                    if (currentLang === 'en' && selectedLang === 'bm') {
                        activityID += 1;
                    } else if (currentLang === 'bm' && selectedLang === 'en') {
                        activityID -= 1;
                    }
                }
                
                // Construct new URL with both language and adjusted activity ID
                let newUrl = `?preferredLanguage=${selectedLang}`;
                if (activityID) {
                    newUrl += `&activityID=${activityID}`;
                }
                
                // Reload page with new parameters
                window.location.href = newUrl;
            });
        });
        
        // Set initial language from localStorage on page load
        const storedLang = localStorage.getItem('preferredLanguage');
        if (storedLang) {
            const activeButton = document.querySelector(`.lang-btn[data-lang="${storedLang}"]`);
            if (activeButton) {
                activeButton.classList.add('active');
            }
        }
    });
    </script>
    <?php
}

// Main language handling function
function handleLanguageSelection() {
    // Get language from localStorage or URL parameter, default to 'en'
    $lang = $_GET['preferredLanguage'] ?? ($_SESSION['preferredLanguage'] ?? 'en');
    
    // Validate language (only allow predefined languages)
    $allowedLanguages = ['bm', 'en'];
    $lang = in_array($lang, $allowedLanguages) ? $lang : 'en';
    
    // Store language in session
    $_SESSION['preferredLanguage'] = $lang;
    
    return $lang;
}

// Usage example
$currentLang = handleLanguageSelection();

// Database connection (similar to your original code)
try {
    $config = require_once('cmp/config.php');
    $pdo = new PDO(
        "mysql:host={$config['host']};dbname={$config['dbname']}", 
        $config['username'], 
        $config['password']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch activities for specific language
    $sql = "SELECT id, title, description, media, language, activity_date FROM activities WHERE language = :lang ORDER BY created_at DESC";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['lang' => $currentLang]);
    $activities = $stmt->fetchAll(PDO::FETCH_ASSOC);    

    // SQL query to fetch top 3 activities ordered by created_at in descending order
    $sqlTop3 = "SELECT * FROM activities WHERE language = :lang ORDER BY created_at DESC LIMIT 3";
    $stmtTop3 = $pdo->prepare($sqlTop3);
    $stmtTop3->execute(['lang' => $currentLang]);
    $topActivities = $stmtTop3->fetchAll(PDO::FETCH_ASSOC);

    

} catch (PDOException $e) {
    $error = "Database Error: " . $e->getMessage();
}

renderLanguageScript();

// echo "<pre>";
// print_r($_SESSION);
// echo "</pre>";
?>