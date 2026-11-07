<?php 
include 'header.php'; 

$result_message = "";
$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = trim($_POST['full_name']);
    $score = trim($_POST['score']);
    $major = trim($_POST['major']);

    if (empty($full_name) || empty($score) || empty($major)) {
        $error_message = "Барлық өрістерді толтыру міндетті!";
    } elseif (!is_numeric($score) || $score < 0 || $score > 140) {
        $error_message = "ҰБТ ұпайы 0 мен 140 аралығындағы сан болуы тиіс!";
    } else {
        $min_scores = [
            "ИТ және бағдарламалау" => 115,
            "Инженерия" => 105,
            "Медицина" => 120,
            "Педагогика" => 85
        ];

        $required_score = $min_scores[$major] ?? 90;

        if ($score >= $required_score) {
            $result_message = "Құттықтаймыз, $full_name! Сіздің $score ұпайыңыз '$major' мамандығы бойынша грантқа түсуге мүмкіндік береді (Шекті балл: $required_score).";
        } else {
            $result_message = "Өкінішке орай, $full_name. Сіздің $score ұпайыңыз '$major' мамандығының шекті баллына ($required_score) жетпей тұр.";
        }
    }
}
?>

<h2>🎯 Грант мүмкіндігін есептеу</h2>

<?php if (!empty($error_message)): ?>
    <div class="alert error"><?php echo $error_message; ?></div>
<?php endif; ?>

<?php if (!empty($result_message)): ?>
    <div class="alert success"><?php echo $result_message; ?></div>
<?php endif; ?>

<form action="calculator.php" method="POST" class="form-card">
    <div class="form-group">
        <label for="full_name">Аты-жөніңіз:</label>
        <input type="text" id="full_name" name="full_name" required>
    </div>

    <div class="form-group">
        <label for="score">ҰБТ жинаған ұпайыңыз (0-140):</label>
        <input type="number" id="score" name="score" min="0" max="140" required>
    </div>

    <div class="form-group">
        <label for="major">Таңдаған бағытыңыз / мамандығыңыз:</label>
        <select id="major" name="major" required>
            <option value="">Таңдаңыз...</option>
            <option value="ИТ және бағдарламалау">ИТ және бағдарламалау</option>
            <option value="Инженерия">Инженерия</option>
            <option value="Медицина">Медицина</option>
            <option value="Педагогика">Педагогика</option>
        </select>
    </div>

    <button type="submit" class="btn">Мүмкіндікті есептеу</button>
</form>

<?php include 'footer.php'; ?>