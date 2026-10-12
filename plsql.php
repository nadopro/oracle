<?php
declare(strict_types=1);

$dbUsername = 'KPC';
$dbPassword = 'kpc1111';
$dbConnectionString = 'localhost/FREEPDB1';
$dbCharset = 'AL32UTF8';

function escapeHtml(mixed $value): string
{
    return htmlspecialchars((string) ($value ?? ''), ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

$connection = oci_connect(
    $dbUsername,
    $dbPassword,
    $dbConnectionString,
    $dbCharset
);

if ($connection === false) {
    $error = oci_error();
    http_response_code(500);
    exit('Oracle 데이터베이스 접속 실패: ' . escapeHtml($error['message'] ?? '알 수 없는 오류'));
}

$alertType = '';
$alertMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sampleId = filter_input(INPUT_POST, 'sample_id', FILTER_VALIDATE_INT);
    $newScore = filter_input(INPUT_POST, 'new_score', FILTER_VALIDATE_INT);

    if ($sampleId === false || $sampleId === null || $sampleId < 1) {
        $alertType = 'danger';
        $alertMessage = '올바른 SAMPLE_ID를 입력하세요.';
    } elseif ($newScore === false || $newScore === null || $newScore < 0 || $newScore > 100) {
        $alertType = 'danger';
        $alertMessage = '점수는 0부터 100 사이로 입력하세요.';
    } else {
        // PHP에서 Oracle의 익명 PL/SQL 블록을 실행하는 예제입니다.
        $plsql = <<<'PLSQL'
BEGIN
    :p_found := 0;
    :p_affected_rows := 0;

    SELECT SCORE
      INTO :p_old_score
      FROM SAMPLE
     WHERE SAMPLE_ID = :p_sample_id
       FOR UPDATE;

    UPDATE SAMPLE
       SET SCORE = :p_new_score
     WHERE SAMPLE_ID = :p_sample_id;

    :p_affected_rows := SQL%ROWCOUNT;
    :p_updated_score := :p_new_score;
    :p_found := 1;
EXCEPTION
    WHEN NO_DATA_FOUND THEN
        :p_found := 0;
END;
PLSQL;

        $statement = oci_parse($connection, $plsql);

        $found = 0;
        $oldScore = 0;
        $updatedScore = 0;
        $affectedRows = 0;

        oci_bind_by_name($statement, ':p_sample_id', $sampleId, -1, SQLT_INT);
        oci_bind_by_name($statement, ':p_new_score', $newScore, -1, SQLT_INT);
        oci_bind_by_name($statement, ':p_found', $found, -1, SQLT_INT);
        oci_bind_by_name($statement, ':p_old_score', $oldScore, -1, SQLT_INT);
        oci_bind_by_name($statement, ':p_updated_score', $updatedScore, -1, SQLT_INT);
        oci_bind_by_name($statement, ':p_affected_rows', $affectedRows, -1, SQLT_INT);

        if (!oci_execute($statement, OCI_NO_AUTO_COMMIT)) {
            $error = oci_error($statement);
            oci_rollback($connection);
            $alertType = 'danger';
            $alertMessage = 'PL/SQL 실행 실패: ' . ($error['message'] ?? '알 수 없는 오류');
        } elseif ($found === 0) {
            oci_rollback($connection);
            $alertType = 'warning';
            $alertMessage = '해당 SAMPLE_ID의 데이터가 없습니다.';
        } else {
            oci_commit($connection);
            $alertType = 'success';
            $alertMessage = sprintf(
                'SAMPLE_ID %d의 점수가 %d점에서 %d점으로 변경되었습니다. (처리 행: %d)',
                $sampleId,
                $oldScore,
                $updatedScore,
                $affectedRows
            );
        }

        oci_free_statement($statement);
    }
}

$sql = <<<'SQL'
SELECT SAMPLE_ID,
       NAME,
       DEPARTMENT,
       SCORE,
       TO_CHAR(REG_DATE, 'YYYY-MM-DD HH24:MI:SS') AS REG_DATE
  FROM SAMPLE
 ORDER BY NAME ASC
SQL;

$statement = oci_parse($connection, $sql);

if ($statement === false || !oci_execute($statement)) {
    $error = oci_error($statement ?: $connection);
    oci_close($connection);
    http_response_code(500);
    exit('데이터 조회 실패: ' . escapeHtml($error['message'] ?? '알 수 없는 오류'));
}

$rows = [];
while (($row = oci_fetch_assoc($statement)) !== false) {
    $rows[] = $row;
}

oci_free_statement($statement);
oci_close($connection);
?>
<!doctype html>
<html lang="ko">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>PHP에서 PL/SQL 실행</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<main class="container py-5">
    <h1 class="h3 mb-4">PHP에서 PL/SQL 실행</h1>

    <?php if ($alertMessage !== ''): ?>
        <div class="alert alert-<?= escapeHtml($alertType) ?>" role="alert">
            <?= escapeHtml($alertMessage) ?>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            점수 변경
        </div>
        <div class="card-body">
            <form method="post" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="sample_id" class="form-label">SAMPLE_ID</label>
                    <input type="number" min="1" class="form-control" id="sample_id" name="sample_id" required>
                </div>
                <div class="col-md-4">
                    <label for="new_score" class="form-label">새 점수</label>
                    <input type="number" min="0" max="100" class="form-control" id="new_score" name="new_score" required>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100">PL/SQL로 점수 변경</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong>SAMPLE 데이터</strong>
            <span class="badge text-bg-secondary"><?= count($rows) ?>건</span>
        </div>
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered align-middle mb-0">
                <thead class="table-dark">
                <tr>
                    <th>SAMPLE_ID</th>
                    <th>NAME</th>
                    <th>DEPARTMENT</th>
                    <th>SCORE</th>
                    <th>REG_DATE</th>
                </tr>
                </thead>
                <tbody>
                <?php if ($rows === []): ?>
                    <tr>
                        <td colspan="5" class="text-center py-4">조회된 데이터가 없습니다.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($rows as $row): ?>
                        <tr>
                            <td><?= escapeHtml($row['SAMPLE_ID']) ?></td>
                            <td><?= escapeHtml($row['NAME']) ?></td>
                            <td><?= escapeHtml($row['DEPARTMENT']) ?></td>
                            <td><?= escapeHtml($row['SCORE']) ?></td>
                            <td><?= escapeHtml($row['REG_DATE']) ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
