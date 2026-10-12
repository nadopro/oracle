<?php
declare(strict_types=1);

// Oracle 접속 정보에 맞게 수정하세요.
$dbUsername = 'KPC';
$dbPassword = 'kpc1111';
$dbConnectionString = 'localhost/FREEPDB1';
$dbCharset = 'AL32UTF8';

$connection = @oci_connect(
    $dbUsername,
    $dbPassword,
    $dbConnectionString,
    $dbCharset
);

if ($connection === false) {
    $error = oci_error();
    http_response_code(500);
    exit('Oracle 데이터베이스 접속 실패: ' . htmlspecialchars($error['message'] ?? '알 수 없는 오류', ENT_QUOTES, 'UTF-8'));
}

$sql = 'SELECT * FROM SAMPLE ORDER BY NAME ASC';
$statement = oci_parse($connection, $sql);

if ($statement === false || !oci_execute($statement)) {
    $error = oci_error($statement ?: $connection);
    oci_close($connection);
    http_response_code(500);
    exit('데이터 조회 실패: ' . htmlspecialchars($error['message'] ?? '알 수 없는 오류', ENT_QUOTES, 'UTF-8'));
}

$columns = [];
$columnCount = oci_num_fields($statement);

for ($index = 1; $index <= $columnCount; $index++) {
    $columns[] = oci_field_name($statement, $index);
}

$rows = [];
while (($row = oci_fetch_assoc($statement)) !== false) {
    $rows[] = $row;
}

oci_free_statement($statement);
oci_close($connection);

function escapeHtml(mixed $value): string
{
    if ($value === null) {
        return '';
    }

    if (is_object($value) && method_exists($value, 'load')) {
        $value = $value->load();
    }

    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
?>
<!doctype html>
<html lang="ko">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SAMPLE 데이터 목록</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<main class="container py-5">
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h1 class="h4 mb-0">SAMPLE 데이터 목록</h1>
        </div>

        <div class="card-body">
            <p class="text-muted">NAME 오름차순 · 총 <?= count($rows) ?>건</p>

            <div class="table-responsive">
                <table class="table table-striped table-hover table-bordered align-middle mb-0">
                    <thead class="table-dark">
                    <tr>
                        <?php foreach ($columns as $column): ?>
                            <th scope="col"><?= escapeHtml($column) ?></th>
                        <?php endforeach; ?>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if ($rows === []): ?>
                        <tr>
                            <td colspan="<?= max(count($columns), 1) ?>" class="text-center py-4">
                                조회된 데이터가 없습니다.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($rows as $row): ?>
                            <tr>
                                <?php foreach ($columns as $column): ?>
                                    <td><?= escapeHtml($row[$column] ?? null) ?></td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
