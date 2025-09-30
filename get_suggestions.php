<?php
$conn = new mysqli('localhost', 'root', '', 'panchayat_land', 3307);
$conn->set_charset("utf8mb4");

if(isset($_GET['term'])) {
    $search = $_GET['term'];
    $sql = "SELECT DISTINCT kannada_word, english_pronunciation, pronounciation_hindi, translated_term, pronunciation_in_kannada 
            FROM panchayat_terms_kannada 
            WHERE kannada_word LIKE ? 
            OR english_pronunciation LIKE ? 
            OR pronounciation_hindi LIKE ?
            OR translated_term LIKE ?
            OR pronunciation_in_kannada LIKE ?
            LIMIT 5";
    
    $stmt = $conn->prepare($sql);
    $searchTerm = "%$search%";
    $stmt->bind_param("sssss", $searchTerm, $searchTerm, $searchTerm, $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $suggestions = array();
    while($row = $result->fetch_assoc()) {
        $suggestions[] = array(
            'kannada' => $row['kannada_word'],
            'english' => $row['english_pronunciation'],
            'hindi' => $row['pronounciation_hindi'],
            'translated' => $row['translated_term'],
            'kannada_pron' => $row['pronunciation_in_kannada']
        );
    }
    
    echo json_encode($suggestions);
}
$conn->close();
?>

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