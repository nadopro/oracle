<?php
// dice.php - 주사위 시뮬레이션 및 Google Charts 시각화
$choices = [6, 60, 600, 6000, 60000, 600000, 6000000, 60000000];
$selected = isset($_POST['trials']) ? (int) $_POST['trials'] : 6;
if (!in_array($selected, $choices, true)) {
    $selected = 6;
}

$dice = array_fill(1, 6, 0);
$executed = false;
$elapsed = 0.0;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 서버의 PHP 실행 제한과 웹서버/프록시 타임아웃은 별개입니다.
    @set_time_limit(0);
    $start = microtime(true);
    for ($i = 0; $i < $selected; $i++) {
        $value = mt_rand(1, 6);
        $dice[$value]++;
    }
    $elapsed = microtime(true) - $start;
    $executed = true;
}

function numfmt($number) {
    return number_format($number);
}
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>주사위 출현 빈도 시뮬레이션</title>
    <script src="https://www.gstatic.com/charts/loader.js"></script>
    <style>
        body { font-family: Arial, 'Malgun Gothic', sans-serif; margin: 0; padding: 30px 18px; color: #1f2937; background: #f5f7fb; }
        .container { max-width: 900px; margin: 0 auto; padding: 26px; background: white; border-radius: 12px; box-shadow: 0 4px 20px #0000000d; }
        h1 { font-size: 25px; margin: 0 0 10px; }
        .sub { color: #64748b; line-height: 1.6; }
        form { display: flex; gap: 12px; align-items: center; flex-wrap: wrap; margin: 24px 0; }
        select, button { font-size: 16px; padding: 10px 14px; border-radius: 7px; }
        select { border: 1px solid #cbd5e1; background: white; }
        button { background: #2458b7; border: 1px solid #2458b7; color: white; cursor: pointer; }
        button:hover { background: #19468f; }
        table { border-collapse: collapse; width: 100%; margin: 18px 0; }
        th, td { border: 1px solid #e2e8f0; text-align: center; padding: 12px 8px; }
        th { background: #eff5ff; }
        .summary { font-weight: bold; margin-top: 20px; }
        #chart { width: 100%; height: 400px; }
        .notice { font-size: 13px; color: #64748b; line-height: 1.6; }
    </style>
</head>
<body>
<div class="container">
    <h1>주사위 던지기 시뮬레이션</h1>
    <p class="sub">주사위를 선택한 횟수만큼 던져 1~6의 출현 횟수를 집계합니다.</p>
    <form method="post">
        <label for="trials">던지는 횟수</label>
        <select id="trials" name="trials">
            <?php foreach ($choices as $choice): ?>
                <option value="<?= $choice ?>" <?= $selected === $choice ? 'selected' : '' ?>><?= numfmt($choice) ?>회</option>
            <?php endforeach; ?>
        </select>
        <button type="submit">주사위 던지기</button>
    </form>

    <?php if ($executed): ?>
        <p class="summary">총 <?= numfmt($selected) ?>회 실행 / 처리 시간 <?= number_format($elapsed, 3) ?>초</p>
        <table>
            <thead><tr><th>주사위 눈</th><th>출현 횟수</th><th>출현 비율</th></tr></thead>
            <tbody>
            <?php for ($face = 1; $face <= 6; $face++): ?>
                <tr>
                    <td><?= $face ?></td>
                    <td><?= numfmt($dice[$face]) ?>회</td>
                    <td><?= number_format($dice[$face] / $selected * 100, 2) ?>%</td>
                </tr>
            <?php endfor; ?>
                <tr><th>합계</th><th><?= numfmt(array_sum($dice)) ?>회</th><th>100.00%</th></tr>
            </tbody>
        </table>
        <h2>주사위 눈별 출현 횟수</h2>
        <div id="chart"></div>
        <p class="notice">점선은 각 눈의 이론적 기대 출현 횟수(전체 횟수 ÷ 6)입니다. 차트 표시에는 인터넷 연결이 필요합니다.</p>
        <script>
            google.charts.load('current', { packages: ['corechart'] });
            google.charts.setOnLoadCallback(drawChart);
            function drawChart() {
                const values = <?= json_encode(array_values($dice), JSON_NUMERIC_CHECK) ?>;
                const expected = <?= json_encode($selected / 6) ?>;
                const data = new google.visualization.DataTable();
                data.addColumn('number', '주사위 눈');
                data.addColumn('number', '출현 횟수');
                data.addColumn('number', '기대 횟수');
                data.addRows(values.map((count, i) => [i + 1, count, expected]));
                const options = {
                    legend: { position: 'bottom' },
                    chartArea: { left: 85, top: 25, width: '82%', height: '70%' },
                    hAxis: { title: '주사위 눈', ticks: [1, 2, 3, 4, 5, 6], viewWindow: { min: 1, max: 6 } },
                    vAxis: { title: '출현 횟수', minValue: 0, format: '#,###' },
                    pointSize: 7,
                    lineWidth: 3,
                    series: { 0: { color: '#2458b7' }, 1: { color: '#e28d40', lineDashStyle: [5, 5], pointSize: 0 } }
                };
                new google.visualization.LineChart(document.getElementById('chart')).draw(data, options);
            }
            window.addEventListener('resize', drawChart);
        </script>
    <?php else: ?>
        <p class="notice">횟수를 선택한 후 실행 버튼을 클릭하면 결과 표와 그래프가 나타납니다.</p>
    <?php endif; ?>
    <p class="notice">참고: 6,000만 회 실행은 서버 환경에 따라 시간이 오래 걸리거나 웹서버 제한으로 중단될 수 있습니다.</p>
</div>
</body>
</html>
