<?php
// search_update.php - MySQL/MariaDB + PDO
// DB 접속 정보 (실습용)
$host = 'localhost';
$dbname = 'kpc';
$username = 'kpc';
$password = '1111';

$rows = [];
$message = '';
$error = '';
$scoreInput = $_POST['score'] ?? '';
$deptInput = $_POST['department'] ?? '';
$updatedCount = 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $score = filter_var($scoreInput, FILTER_VALIDATE_INT);
    $department = trim((string)$deptInput);

    if ($score === false || $scoreInput === '' || $department === '') {
        $error = '점수는 정수로, 학과는 빈칸 없이 입력해 주세요.';
    } elseif (mb_strlen($department, 'UTF-8') > 30) {
        $error = '학과명은 30자 이내로 입력해 주세요.';
    } else {
        try {
            $pdo = new PDO(
                "mysql:host={$host};dbname={$dbname};charset=utf8mb4",
                $username,
                $password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false,
                ]
            );

            $pdo->beginTransaction();

            // 변경 전 대상자를 조회 (트랜잭션 안에서 대상 행 잠금).
            $select = $pdo->prepare(
                'SELECT SAMPLE_ID, NAME, DEPARTMENT, SCORE, REG_DATE
                   FROM SAMPLE
                  WHERE SCORE >= :score
                  ORDER BY SCORE DESC, SAMPLE_ID ASC
                  FOR UPDATE'
            );
            $select->execute(['score' => $score]);
            $rows = $select->fetchAll();

            // 조회된 대상과 동일한 조건으로 학과 일괄 수정.
            $update = $pdo->prepare(
                'UPDATE SAMPLE SET DEPARTMENT = :department WHERE SCORE >= :score'
            );
            $update->execute(['department' => $department, 'score' => $score]);
            $updatedCount = $update->rowCount(); // 실제 변경된 행 수 (설정에 따라 달라질 수 있음)

            $pdo->commit();
            $message = count($rows) . '명을 조회했습니다. 학과를 "' . $department . '"(으)로 변경했습니다.';
        } catch (Throwable $e) {
            if (isset($pdo) && $pdo->inTransaction()) {
                $pdo->rollBack();
            }
            $error = '처리 중 오류가 발생했습니다: ' . $e->getMessage();
        }
    }
}

function e($value): string {
    return htmlspecialchars((string)($value ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SAMPLE 점수 조회 및 학과 변경</title>
    <style>
        body { font-family: Arial, 'Malgun Gothic', sans-serif; margin: 36px auto; max-width: 900px; padding: 0 16px; color: #202938; }
        h1 { font-size: 24px; }
        form { display: flex; flex-wrap: wrap; align-items: end; gap: 14px; padding: 18px; border: 1px solid #d9dee7; border-radius: 8px; }
        label { display: flex; flex-direction: column; gap: 7px; font-weight: bold; }
        input { padding: 10px; border: 1px solid #b8c1ce; border-radius: 5px; font-size: 15px; }
        button { border: 0; border-radius: 5px; padding: 11px 22px; background: #2257a6; color: white; font-size: 15px; cursor: pointer; }
        .message { margin-top: 18px; color: #17663b; }
        .error { margin-top: 18px; color: #a11c22; }
        table { width: 100%; margin-top: 18px; border-collapse: collapse; }
        th, td { padding: 10px; border: 1px solid #d9dee7; text-align: left; }
        th { background: #f2f5f9; }
        .hint { font-size: 13px; color: #586477; }
    </style>
</head>
<body>
    <h1>SAMPLE 점수 조회 및 학과 변경</h1>
    <p class="hint">입력한 점수 이상의 사람을 조회하고, 학과를 지정한 값으로 변경합니다.</p>
    <form method="post">
        <label>기준 점수
            <input type="number" name="score" step="1" required value="<?= e($scoreInput) ?>" placeholder="예: 80">
        </label>
        <label>변경할 학과
            <input type="text" name="department" maxlength="30" required value="<?= e($deptInput) ?>" placeholder="예: 컴퓨터공학과">
        </label>
        <button type="submit">실행</button>
    </form>

    <?php if ($error !== ''): ?>
        <p class="error"><?= e($error) ?></p>
    <?php elseif ($message !== ''): ?>
        <p class="message"><?= e($message) ?></p>
        <p class="hint">아래 표의 '변경 전 학과'는 조회 당시 값이며, '변경 후 학과'는 적용된 값입니다.</p>
        <table>
            <thead><tr><th>SAMPLE_ID</th><th>NAME</th><th>SCORE</th><th>변경 전 학과</th><th>변경 후 학과</th><th>REG_DATE</th></tr></thead>
            <tbody>
            <?php foreach ($rows as $row): ?>
                <tr>
                    <td><?= e($row['SAMPLE_ID']) ?></td>
                    <td><?= e($row['NAME']) ?></td>
                    <td><?= e($row['SCORE']) ?></td>
                    <td><?= e($row['DEPARTMENT']) ?></td>
                    <td><?= e($deptInput) ?></td>
                    <td><?= e($row['REG_DATE']) ?></td>
                </tr>
            <?php endforeach; ?>
            <?php if (!$rows): ?>
                <tr><td colspan="6">조건에 맞는 데이터가 없습니다.</td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
