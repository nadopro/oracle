<?php
declare(strict_types=1);

$nameList = [
    1 => [
        '김', '김', '김', '김', '김', '이', '이', '이', '이', '박', '박', '박',
        '최', '최', '정', '정', '조', '조', '윤', '윤', '장', '임', '한', '오',
        '서', '신', '권', '황', '안', '송', '홍', '유', '남', '강', '문', '백'
    ],
    2 => [
        '광', '경', '계', '관', '균', '근', '기', '길', '대', '덕', '도', '동',
        '만', '명', '문', '병', '보', '봉', '상', '석', '성', '세', '수', '순',
        '승', '시', '신', '영', '용', '우', '원', '윤', '응', '의', '인', '재',
        '정', '종', '주', '준', '중', '지', '창', '태', '하', '현', '형', '호'
    ],
    3 => [
        '겸', '경', '계', '규', '근', '기', '길', '담', '도', '동', '량', '명',
        '민', '복', '봉', '빈', '상', '서', '석', '성', '세', '수', '순', '신',
        '영', '용', '우', '욱', '원', '윤', '은', '의', '익', '인', '일', '재',
        '정', '종', '주', '준', '중', '지', '진', '창', '필', '하', '현', '호'
    ],
];

$departments = [
    '컴퓨터공학과', '전자공학과', '경영학과', '영문학과',
    '사회학과', '건축공학과', '소프트웨어학과'
];

$count = filter_input(INPUT_POST, 'count', FILTER_VALIDATE_INT);
$startId = filter_input(INPUT_POST, 'start_id', FILTER_VALIDATE_INT);

$count = ($count !== false && $count !== null) ? $count : 20;
$startId = ($startId !== false && $startId !== null) ? $startId : 101;

$count = max(1, min($count, 1000));
$startId = max(1, $startId);

$rows = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    for ($i = 0; $i < $count; $i++) {
        $name = $nameList[1][array_rand($nameList[1])]
              . $nameList[2][array_rand($nameList[2])]
              . $nameList[3][array_rand($nameList[3])];

        $rows[] = [
            'SAMPLE_ID'  => $startId + $i,
            'NAME'       => $name,
            'DEPARTMENT' => $departments[array_rand($departments)],
            'SCORE'      => random_int(60, 90),
        ];
    }
}

function e(string|int $value): string
{
    return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
?>
<!doctype html>
<html lang="ko">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SAMPLE 데이터 생성기</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<main class="container py-5">
    <h1 class="h3 mb-4">SAMPLE 데이터 생성기</h1>

    <div class="card shadow-sm mb-4">
        <div class="card-header bg-primary text-white">생성 조건</div>
        <div class="card-body">
            <form method="post" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="count" class="form-label">생성 횟수</label>
                    <input type="number" class="form-control" id="count" name="count"
                           min="1" max="1000" value="<?= e($count) ?>" required>
                </div>
                <div class="col-md-4">
                    <label for="start_id" class="form-label">ID 시작 번호</label>
                    <input type="number" class="form-control" id="start_id" name="start_id"
                           min="1" value="<?= e($startId) ?>" required>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-primary w-100">생성하기</button>
                </div>
            </form>
        </div>
    </div>

    <?php if ($rows !== []): ?>
        <div class="d-flex justify-content-between align-items-center mb-2">
            <span class="text-muted">총 <?= e(count($rows)) ?>건</span>
            <button type="button" class="btn btn-outline-success btn-sm" id="copyButton">
                엑셀용 데이터 복사
            </button>
        </div>

        <div class="table-responsive shadow-sm">
            <table class="table table-striped table-hover table-bordered align-middle mb-0" id="resultTable">
                <thead class="table-dark">
                <tr>
                    <th>SAMPLE_ID</th>
                    <th>NAME</th>
                    <th>DEPARTMENT</th>
                    <th>SCORE</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($rows as $row): ?>
                    <tr>
                        <td><?= e($row['SAMPLE_ID']) ?></td>
                        <td><?= e($row['NAME']) ?></td>
                        <td><?= e($row['DEPARTMENT']) ?></td>
                        <td><?= e($row['SCORE']) ?></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</main>

<script>
const copyButton = document.getElementById('copyButton');

if (copyButton) {
    copyButton.addEventListener('click', async () => {
        const lines = [...document.querySelectorAll('#resultTable tr')].map(row =>
            [...row.cells].map(cell => cell.innerText.trim()).join('\t')
        );

        try {
            await navigator.clipboard.writeText(lines.join('\n'));
            copyButton.textContent = '복사 완료';
        } catch (error) {
            alert('자동 복사가 차단되었습니다. 표를 직접 선택해 복사해 주세요.');
        }
    });
}
</script>
</body>
</html>
